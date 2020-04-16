package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.MachineSubscribeDataHandler;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import com.BrewSoft.MachineControllerAPI.domain.interfaces.IMachineControl;
import com.BrewSoft.MachineControllerAPI.domain.interfaces.IMachineSubscribe;
import java.util.concurrent.ExecutionException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.eclipse.milo.opcua.stack.core.types.builtin.DataValue;
import org.eclipse.milo.opcua.stack.core.types.builtin.NodeId;
import org.eclipse.milo.opcua.stack.core.types.builtin.Variant;

public class MachineController implements IMachineControl {

    private MachineConnection mconn;

    private NodeId cntrlCmdNodeId = new NodeId(6, "::Program:Cube.Command.CntrlCmd");
    private NodeId cmdChangeRequestNodeId = new NodeId(6, "::Program:Cube.Command.CmdChangeRequest");

    private Batch newBatch;

    private IMachineSubscriberDataHandler msdh = new MachineSubscribeDataHandler();

    private IMachineSubscribe subscriber;
    private Machine machineObj;

    public MachineController(Machine machineObj, IMachineSubscribe subscriber) {
        this.machineObj = machineObj;
        this.mconn = new MachineConnection(machineObj.getHostname(), machineObj.getPort());
        this.mconn.connect();
        this.subscriber = subscriber;
    }

    @Override
    public String startProduction() {
        newBatch = msdh.getNextBatch();
        subscriber.setCurrentBatch(newBatch);
        msdh.changeProductionListStatus(newBatch.getProductionListID(), "In Production");
        try {
            // Set parameter[0], batchid > 65536
            NodeId batchIDNode = new NodeId(6, "::Program:Cube.Command.Parameter[0].Value");
            mconn.getClient().writeValue(batchIDNode, DataValue.valueOnly(new Variant((float) newBatch.getBatchID()))).get();

            // Set parameter[1], Product id [0..5]
            NodeId productIdNode = new NodeId(6, "::Program:Cube.Command.Parameter[1].Value");
            mconn.getClient().writeValue(productIdNode, DataValue.valueOnly(new Variant((float) newBatch.getType()))).get();

            // Set parameter[2], Amount >65536
            NodeId quantityNode = new NodeId(6, "::Program:Cube.Command.Parameter[2].Value");
            mconn.getClient().writeValue(quantityNode, DataValue.valueOnly(new Variant((float) newBatch.getTotalAmount()))).get();

            // Set the speed of production, table for speeds in projektoplæg.pdf
            // Need to calculate the "right" speeds, maybe in mathlab
            NodeId speedNode = new NodeId(6, "::Program:Cube.Command.MachSpeed");
            mconn.getClient().writeValue(speedNode, DataValue.valueOnly(new Variant(newBatch.getSpeedforProduction())));
        } catch (InterruptedException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ExecutionException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        }

        // Start the production
        sendCntrlCmd(new Variant(2));
        sendCmdRequest();
        //System.out.println(newBatch.getBatchID() + " : " + newBatch.getProductionListID() + " : " + newBatch.getTotalAmount());
        return "Machine started. If we're lucky!";
    }
// Not used?

    private void changeSpeed(float machSpeed) {
        NodeId speedNode = new NodeId(6, "::Program:Cube.Command.MachSpeed");
        mconn.getClient().writeValue(speedNode, DataValue.valueOnly(new Variant((float) machSpeed)));
    }

    @Override
    public String resetMachine() {
        sendCntrlCmd(new Variant(1));
        sendCmdRequest();
        return "Machine reset";
    }

    @Override
    public String stopProduction() {
        String returnTxt;
        if (newBatch != null) {
            msdh.changeProductionListStatus(newBatch.getProductionListID(), "stopped");
            subscriber.stoppedproduction(newBatch.getProductionListID());
            sendCntrlCmd(new Variant(3));
            sendCmdRequest();
            returnTxt = "Machine stopped. If we're lucky!";
        } else {
            returnTxt = "The machine has not been started yet, you dimwit!";
        }
        return returnTxt;
    }

    @Override
    public String abortProduction() {
        String returnTxt;
        if (newBatch != null) {
            sendCntrlCmd(new Variant(4));
            msdh.changeProductionListStatus(newBatch.getProductionListID(), "aborted");
            sendCmdRequest();
            subscriber.stoppedproduction(newBatch.getProductionListID());
            returnTxt = "Aborted production.";
        } else {
            returnTxt = "The machine has not been started yet, you dimwit!";
        }
        return returnTxt;
    }

    @Override
    public String clearState() {
        sendCntrlCmd(new Variant(5));
        sendCmdRequest();
        return "Machine has been cleared, whatever that means?!?";
    }

    private void sendCntrlCmd(Variant variantNo) {
        try {
            mconn.getClient().writeValue(cntrlCmdNodeId, DataValue.valueOnly(variantNo)).get();
        } catch (InterruptedException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ExecutionException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private void sendCmdRequest() {
        try {
            mconn.getClient().writeValue(cmdChangeRequestNodeId, DataValue.valueOnly(new Variant(true))).get();
        } catch (ExecutionException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        } catch (InterruptedException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
