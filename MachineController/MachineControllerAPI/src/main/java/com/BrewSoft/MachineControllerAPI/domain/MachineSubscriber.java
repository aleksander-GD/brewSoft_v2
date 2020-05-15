package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.TemporaryProductionBatch;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import com.BrewSoft.MachineControllerAPI.domain.interfaces.IMachineSubscribe;
import java.math.BigDecimal;
import java.math.RoundingMode;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.atomic.AtomicLong;
import java.util.function.Consumer;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.eclipse.milo.opcua.sdk.client.api.subscriptions.UaMonitoredItem;
import org.eclipse.milo.opcua.sdk.client.api.subscriptions.UaSubscription;
import org.eclipse.milo.opcua.stack.core.AttributeId;
import org.eclipse.milo.opcua.stack.core.types.builtin.DataValue;
import org.eclipse.milo.opcua.stack.core.types.builtin.NodeId;
import org.eclipse.milo.opcua.stack.core.types.builtin.unsigned.Unsigned;
import org.eclipse.milo.opcua.stack.core.types.enumerated.MonitoringMode;
import org.eclipse.milo.opcua.stack.core.types.enumerated.TimestampsToReturn;
import org.eclipse.milo.opcua.stack.core.types.structured.MonitoredItemCreateRequest;
import org.eclipse.milo.opcua.stack.core.types.structured.MonitoringParameters;
import org.eclipse.milo.opcua.stack.core.types.structured.ReadValueId;

public class MachineSubscriber implements IMachineSubscribe {

    private static final AtomicLong ATOMICLOMG = new AtomicLong(1L);
    private MachineConnection mconn;
    private Map<String, String> consumerMap;

    private IMachineSubscriberDataHandler msdh;

    // Production detail nodes
    private final NodeId batchIdNode = new NodeId(6, "::Program:Cube.Status.Parameter[0].Value");
    private final NodeId totalProductsNode = new NodeId(6, "::Program:Cube.Status.Parameter[1].Value");
    private final NodeId tempNode = new NodeId(6, "::Program:Cube.Status.Parameter[2].Value");
    private final NodeId humidityNode = new NodeId(6, "::Program:Cube.Status.Parameter[3].Value");
    private final NodeId vibrationNode = new NodeId(6, "::Program:Cube.Status.Parameter[4].Value");
    private final NodeId producedCountNode = new NodeId(6, "::Program:Cube.Admin.ProdProcessedCount");
    private final NodeId defectCountNode = new NodeId(6, "::Program:Cube.Admin.ProdDefectiveCount");
    private final NodeId productsPrMinuteNode = new NodeId(6, "::Program:Cube.Status.MachSpeed");
    private final NodeId acceptableCountNode = new NodeId(6, "::Program:product.good");

    // Production detail nodes.
    private final NodeId productBadNode = new NodeId(6, "::Program:product.bad");
    private final NodeId productProducedAmountNode = new NodeId(6, "::Program:product.produce_amount");
    private final NodeId productProducedNode = new NodeId(6, "::Program:product.produced");

    // Machine specific nodes
    private final NodeId stopReasonNode = new NodeId(6, "::Program:Cube.Admin.StopReason.ID");
    private final NodeId stateCurrentNode = new NodeId(6, "::Program:Cube.Status.StateCurrent");
    private final NodeId maintenanceCounterNode = new NodeId(6, "::Program:Maintenance.Counter");
    private final NodeId maintenanceStateNode = new NodeId(6, "::Program:Maintenance.State");
    private final NodeId maintenanceTriggerNode = new NodeId(6, "::Program:Maintenance.Trigger");

    // Material nodes
    private final NodeId barleyNode = new NodeId(6, "::Program:Inventory.Barley");
    private final NodeId hopsNode = new NodeId(6, "::Program:Inventory.Hops");
    private final NodeId maltNode = new NodeId(6, "::Program:Inventory.Malt");
    private final NodeId wheatNode = new NodeId(6, "::Program:Inventory.Wheat");
    private final NodeId yeastNode = new NodeId(6, "::Program:Inventory.Yeast");

    private float batchIDValue;
    private float totalProductValue;
    private float temperaturValue;
    private float humidityValue;
    private float vibrationValue;
    private int productionCountValue;
    private int defectCountValue;
    private int acceptableCountValue;
    private float productionPrMinValue;

    private int StopReasonID;
    private int currentStateValue;
    private int maintenanceValue;

    private float barleyValue;
    private float hopsValue;
    private float maltValue;
    private float wheatValue;
    private float yeastValue;

    private Batch batch;
    private Machine machineObj;
    
    //Software sim value faker system.
    private final String SOFTWARESIM = "127.0.0.1";
    private int tempProducts = 0;

    public MachineSubscriber(Machine machineObj) {
        mconn = new MachineConnection(machineObj.getHostname(), machineObj.getPort());
        consumerMap = new HashMap();
        this.machineObj = machineObj;
    }

    @Override
    public void setSubscriberDataHandler(IMachineSubscriberDataHandler msdh) {
        this.msdh = msdh;
    }

    @Override
    public String connectMachine() {
        if (!this.mconn.getStatus()) {
            this.mconn.connect();
        }
        return "Connected to machine: " + machineObj.getMachineID();
    }

    @Override
    public void setCurrentBatch(Batch currentBatch) {
        this.batch = currentBatch;
    }

    @Override
    public void subscribe() {
        if (this.mconn.getStatus()) {
            List<MonitoredItemCreateRequest> requestList = new ArrayList();
            requestList.add(new MonitoredItemCreateRequest(readValueId(batchIdNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(totalProductsNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(tempNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(humidityNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(vibrationNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(productProducedNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(defectCountNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(acceptableCountNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(stopReasonNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(stateCurrentNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(productsPrMinuteNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(barleyNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(hopsNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(maltNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(wheatNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(yeastNode), MonitoringMode.Reporting, monitoringParameters()));
            requestList.add(new MonitoredItemCreateRequest(readValueId(maintenanceCounterNode), MonitoringMode.Reporting, monitoringParameters()));

            Consumer<DataValue> onBatchIdItem = (dataValue) -> consumerStarter(BATCHID_NODENAME, dataValue);
            Consumer<DataValue> onTotalProductsItem = (dataValue) -> consumerStarter(TOTAL_PRODUCTS_NODENAME, dataValue);
            Consumer<DataValue> onTempratureItem = (dataValue) -> consumerStarter(TEMPERATURE_NODENAME, dataValue);
            Consumer<DataValue> onHumidityItem = (dataValue) -> consumerStarter(HUMIDITY_NODENAME, dataValue);
            Consumer<DataValue> onVibrationItem = (dataValue) -> consumerStarter(VIBRATION_NODENAME, dataValue);
            Consumer<DataValue> onProducedItem = (dataValue) -> consumerStarter(PRODUCED_PRODUCTS_NODENAME, dataValue);
            Consumer<DataValue> onDefectItem = (dataValue) -> consumerStarter(DEFECT_PRODUCTS_NODENAME, dataValue);
            Consumer<DataValue> onAcceptableItem = (dataValue) -> consumerStarter(ACCEPTABLE_PRODUCTS_NODENAME, dataValue);
            Consumer<DataValue> onStopReasonItem = (dataValue) -> consumerStarter(STOP_REASON_NODENAME, dataValue);
            Consumer<DataValue> onStateReadItem = (dataValue) -> consumerStarter(STATE_CURRENT_NODENAME, dataValue);
            Consumer<DataValue> onProductsPrMinuteReadItem = (dataValue) -> consumerStarter(PRODUCTS_PR_MINUTE_NODENAME, dataValue);

            Consumer<DataValue> onBarleyReadItem = (dataValue) -> consumerStarter(BARLEY_NODENAME, dataValue);
            Consumer<DataValue> onHopsReadItem = (dataValue) -> consumerStarter(HOPS_NODENAME, dataValue);
            Consumer<DataValue> onMaltReadItem = (dataValue) -> consumerStarter(MALT_NODENAME, dataValue);
            Consumer<DataValue> onWheatReadItem = (dataValue) -> consumerStarter(WHEAT_NODENAME, dataValue);
            Consumer<DataValue> onYeastReadItem = (dataValue) -> consumerStarter(YEAST_NODENAME, dataValue);

            Consumer<DataValue> onMaintenanceCounterReadItem = (dataValue) -> consumerStarter(MAINTENANCE_COUNTER_NODENAME, dataValue);

            try {
                UaSubscription subscription = mconn.getClient().getSubscriptionManager().createSubscription(1000.0).get();
                List<UaMonitoredItem> items = subscription.createMonitoredItems(TimestampsToReturn.Both, requestList).get();

                //Sets consumer on specific subscription.
                items.get(0).setValueConsumer(onBatchIdItem);
                items.get(1).setValueConsumer(onTotalProductsItem);
                items.get(2).setValueConsumer(onTempratureItem);
                items.get(3).setValueConsumer(onHumidityItem);
                items.get(4).setValueConsumer(onVibrationItem);
                items.get(5).setValueConsumer(onProducedItem);
                items.get(6).setValueConsumer(onDefectItem);
                items.get(7).setValueConsumer(onAcceptableItem);
                items.get(8).setValueConsumer(onStopReasonItem);
                items.get(9).setValueConsumer(onStateReadItem);
                items.get(10).setValueConsumer(onProductsPrMinuteReadItem);
                items.get(11).setValueConsumer(onBarleyReadItem);
                items.get(12).setValueConsumer(onHopsReadItem);
                items.get(13).setValueConsumer(onMaltReadItem);
                items.get(14).setValueConsumer(onWheatReadItem);
                items.get(15).setValueConsumer(onYeastReadItem);
                items.get(16).setValueConsumer(onMaintenanceCounterReadItem);

            } catch (InterruptedException ex) {
                Logger.getLogger(MachineSubscriber.class.getName()).log(Level.SEVERE, null, ex);
            } catch (ExecutionException ex) {
                Logger.getLogger(MachineSubscriber.class.getName()).log(Level.SEVERE, null, ex);
            }

        } else {
//            return "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort();
        }
    }

    public void sendProductionData() {
        float checkHumidity = 0;
        float checkTemperatur = 0;
        if (checkHumidity != humidityValue || checkTemperatur != temperaturValue) {
            checkHumidity = humidityValue;
            checkTemperatur = temperaturValue;
            msdh.insertProductionInfo(batch.getProductionListID(), machineObj.getMachineID(), humidityValue, temperaturValue);
        }
    }

    public void sendTimeInState() {
        int checkCurrentState = -1;
        if (checkCurrentState != currentStateValue) {
            checkCurrentState = currentStateValue;
            msdh.insertTimesInStates(batch.getProductionListID(), machineObj.getMachineID(), currentStateValue);
        }
    }

    public void sendStopDuingProduction() {
        if (StopReasonID != 0) {
            msdh.insertStopsDuringProduction(batch.getProductionListID(), machineObj.getMachineID(), StopReasonID);
        } else {
            System.out.println("stopreasonid: " + StopReasonID);
        }
    }

    public void completedBatch() {
        if (batch.getTotalAmount() <= this.productionCountValue) {
            msdh.changeProductionListStatus(batch.getProductionListID(), "Completed");
            msdh.insertFinalBatchInformation(batch.getProductionListID(), machineObj.getMachineID(), batch.getDeadline(),
                    batch.getDateofCreation(), batch.getType(),
                    totalProductValue, defectCountValue, acceptableCountValue);

        }
    }

    private MonitoringParameters monitoringParameters() {
        return new MonitoringParameters(
                Unsigned.uint(ATOMICLOMG.getAndIncrement()),
                1000.0, // sampling interval
                null, // filter, null means use default
                Unsigned.uint(10), // queue size
                true // discard oldest
        );
    }

    private ReadValueId readValueId(NodeId name) {
        return new ReadValueId(name, AttributeId.Value.uid(), null, null);
    }

    private void consumerStarter(String nodename, DataValue dataValue) {
        //System.out.println("node: " + nodename);
        switch (nodename) {
            case BATCHID_NODENAME:
                this.batchIDValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case TOTAL_PRODUCTS_NODENAME:
                this.totalProductValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case TEMPERATURE_NODENAME:
                this.temperaturValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                System.out.println("temp");
            case HUMIDITY_NODENAME:
                System.out.println("humid");
                if (nodename.equals(HUMIDITY_NODENAME)) {
                    this.humidityValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                }
                this.sendProductionData();
                break;
            case VIBRATION_NODENAME:
                this.vibrationValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;

            case DEFECT_PRODUCTS_NODENAME:
                this.defectCountValue = Integer.parseInt(dataValue.getValue().getValue().toString());
                break;
            case PRODUCTS_PR_MINUTE_NODENAME:
                this.productionPrMinValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case ACCEPTABLE_PRODUCTS_NODENAME:
                this.acceptableCountValue = Integer.parseInt(dataValue.getValue().getValue().toString());
                break;
            case STOP_REASON_NODENAME:
                this.StopReasonID = Integer.parseInt(dataValue.getValue().getValue().toString());
                sendStopDuingProduction();
                break;
            case STATE_CURRENT_NODENAME:
                this.currentStateValue = Integer.parseInt(dataValue.getValue().getValue().toString());
                sendTimeInState();
                break;
            case MAINTENANCE_COUNTER_NODENAME:
                this.maintenanceValue = Integer.parseInt(dataValue.getValue().getValue().toString());
                // To simulate values on software simulator
                if (machineObj.getHostname().equals(SOFTWARESIM)) {
                    this.generateRandomProdValues();
                    this.sendProductionData();
                }
                // End of software simulator values
                break;
            case BARLEY_NODENAME:
                this.barleyValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case HOPS_NODENAME:
                this.hopsValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case MALT_NODENAME:
                this.maltValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case WHEAT_NODENAME:
                this.wheatValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case YEAST_NODENAME:
                this.yeastValue = Float.parseFloat(dataValue.getValue().getValue().toString());
                break;
            case PRODUCED_PRODUCTS_NODENAME:
                this.productionCountValue = Integer.parseInt(dataValue.getValue().getValue().toString());
                if(machineObj.getHostname().equals(this.SOFTWARESIM)){
                    this.generateRandomAmountProduced();
                }
                this.completedBatch();
                break;
            default:
        }
    }

    @Override
    public void stoppedproduction(int productionlistid) {
        TemporaryProductionBatch tpb = new TemporaryProductionBatch(productionlistid, acceptableCountValue, defectCountValue, totalProductValue);
        msdh.insertStoppedProductionToTempTable(tpb);
    }

    @Override
    public String stateTranslator(String state) {
        switch (state) {
            case DEACTIVATED:
                return "Deactivated";
            case CLEARING:
                return "Clearing";
            case STOPPED:
                return "Stopped";
            case STARTING:
                return "Starting";
            case IDLE:
                return "Idle";
            case SUSPENDED:
                return "Suspended";
            case EXECUTE:
                return "Execute";
            case STOPPING:
                return "Stopping";
            case ABORTING:
                return "Aborting";
            case ABORTED:
                return "Aborted";
            case HOLDING:
                return "Holding";
            case HELD:
                return "Held";
            case RESETTING:
                return "Resetting";
            case COMPLETING:
                return "Completing";
            case COMPLETE:
                return "Complete";
            case DEACTIVATING:
                return "Deactivating";
            case ACTIVATING:
                return "Activating";
        }
        return "Unknown State code: " + state;
    }

    private void generateRandomProdValues() {
        Random random = new Random();
        int value = random.nextInt(2000);
       
        System.out.println("Random value:" + value);
        if (value > 1 && value < 5) {
            humidityValue = Math.round((float) (Math.random() * (21 - 17) + 17) * 100.0 / 100.0); // low humid alarm
        } else if (value > 5 && value < 10) {
            temperaturValue = Math.round((float) (Math.random() * (26 - 20) + 20) * 100.0 / 100.0);   // low temp alarm
        } else if (value > 10 && value < 15) {
            humidityValue = Math.round((float) (Math.random() * (38 - 34) + 34) * 100.0 / 100.0);     // high humid alarm
        } else if (value > 15 && value < 20) {
            temperaturValue = Math.round((float) (Math.random() * (38 - 33) + 33) * 100.0 / 100.0);   // high temp alarm
        } else {
            temperaturValue = Math.round((float) (Math.random() * (30 - 27) + 27) * 100.0 / 100.0);  // Normal values
            humidityValue = Math.round((float) (Math.random() * (30 - 27) + 27) * 100.0 / 100.0);
        }
    }
    
    
    
    
    private void generateRandomAmountProduced() {
        int prodDiff = this.productionCountValue - tempProducts;
        tempProducts = this.productionCountValue;
        Random random = new Random();
        int randomValue = random.nextInt(10);
        if(randomValue < 3){
            defectCountValue += prodDiff;
        } else {
            acceptableCountValue += prodDiff;
        }
        System.out.println("defects: " + this.defectCountValue);
        System.out.println("accepted: " + this.acceptableCountValue);
        //totalProductValue = this.productionCountValue;
        //Random random = new Random();
        //acceptableCountValue = random.nextInt(this.productionCountValue + 1);
        //defectCountValue = (int) totalProductValue - acceptableCountValue;
    }
}
