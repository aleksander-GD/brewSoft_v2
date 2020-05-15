package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.MachineSubscribeDataHandler;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import com.BrewSoft.MachineControllerAPI.domain.interfaces.IMachineControl;
import com.BrewSoft.MachineControllerAPI.domain.interfaces.IMachineSubscribe;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;
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

    private IMachineSubscriberDataHandler msdh;

    private IMachineSubscribe subscriber;
    private Machine machineObj;
    
    private int id;

    public MachineController(Machine machineObj, IMachineSubscribe subscriber) {
        this.machineObj = machineObj;
        this.mconn = new MachineConnection(machineObj.getHostname(), machineObj.getPort());
        this.subscriber = subscriber;
        this.msdh = new MachineSubscribeDataHandler();
        subscriber.setSubscriberDataHandler(msdh);
        this.id = new Random().nextInt();
    }

    @Override
    public Map<String, String> connectMachine() {
        if (!this.mconn.getStatus()) {
            this.mconn.connect();
        }
        Map<String, String> rtm = new HashMap();
        rtm.put("Success", "Connected to machine: " + machineObj.getMachineID());
        return rtm;
    }

    /**
     * TODO: Check if the machine actually starts, somehow...
     * @return 
     */
    @Override
    public Map<String, String> startProduction() {
        String returnTxt;
        Map<String, String> rtm = new HashMap();
        if (this.mconn.getStatus()) {
            newBatch = msdh.getNextBatch();
            if(newBatch != null) {
                subscriber.setCurrentBatch(newBatch);
                msdh.changeProductionListStatus(newBatch.getProductionListID(), "In Production", machineObj.getMachineID());
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
                    System.out.println("MC execute " + ex.getMessage() +" : "+ ex.getCause());
                    returnTxt = "Connection between controller and machine lost. Check the java program and machine are both running.";
                    rtm.put("error", returnTxt);
                    //Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
                }

                // Start the production
                sendCntrlCmd(new Variant(2));
                sendCmdRequest();
                //System.out.println(newBatch.getBatchID() + " : " + newBatch.getProductionListID() + " : " + newBatch.getTotalAmount());
                returnTxt = this.id + " Machine started.";
                rtm.put("Success", returnTxt);
            } else {
                returnTxt = "No batch in queue.";
                rtm.put("Error", returnTxt);
            }
        } else {
            returnTxt = "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort();
            rtm.put("Error", returnTxt);
        }
        return rtm;
    }
    
    @Override
    public Map<String, String> resetMachine() {
        Map<String, String> rtm = new HashMap();
        if(this.mconn.getStatus()) {
            if(msdh.hasQueue()) {
                msdh.runQueue();
            }
            String res = sendCntrlCmd(new Variant(1));
            if(res.equals("")) {
                sendCmdRequest();
                rtm.put("Success", this.id + " Machine reset.");
            } else {
                rtm.put("Error", res);
            }
        } else {
            rtm.put("Error", "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort());
        }
        return rtm;
    }

    @Override
    public Map<String, String> stopProduction() {
        String returnTxt;
        Map<String, String> rtm = new HashMap();
        if(this.mconn.getStatus()) {
            if (newBatch != null) {
                String res = sendCntrlCmd(new Variant(3));
                if(res.equals("")) {
                    msdh.changeProductionListStatus(newBatch.getProductionListID(), "stopped");
                    subscriber.stoppedproduction(newBatch.getProductionListID());
                    sendCmdRequest();
                    returnTxt = this.id + " Machine stopped.";
                    rtm.put("Success", returnTxt);
                } else {
                    rtm.put("Error", res);
                }
            } else {
                returnTxt = "The machine has not been started yet!";
                rtm.put("Error", returnTxt);
            }
        } else {
            returnTxt = "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort();
            rtm.put("Error", returnTxt);
        }
        return rtm;
    }

    @Override
    public Map<String, String> abortProduction() {
        String returnTxt;
        Map<String, String> rtm = new HashMap();
        if(this.mconn.getStatus()) {
            if (newBatch != null) {
                String res = sendCntrlCmd(new Variant(4));
                if(res.equals("")) {
                    msdh.changeProductionListStatus(newBatch.getProductionListID(), "aborted");
                    sendCmdRequest();
                    subscriber.stoppedproduction(newBatch.getProductionListID());
                    returnTxt = "Aborted production.";
                    rtm.put("Success", returnTxt);
                } else {
                    rtm.put("Error", res);
                }
            } else {
                returnTxt = "The machine has not been started yet!";
                rtm.put("Error", returnTxt);
            }
        } else {
            returnTxt = "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort();
            rtm.put("Error", returnTxt);
        }
        return rtm;
    }

    @Override
    public Map<String, String> clearState() {
        Map<String, String> rtm = new HashMap();
        if(this.mconn.getStatus()) {
            String res = sendCntrlCmd(new Variant(5));
            if(res.equals("")) {
                sendCmdRequest();
                rtm.put("Success", "Machine has been cleared.");
            } else {
                rtm.put("Error", res);
            }
        } else {
            rtm.put("Error", "No machine available on host: " + this.machineObj.getHostname() + " port: " + this.machineObj.getPort());
        }
        return rtm;
    }

    private String sendCntrlCmd(Variant variantNo) {
        String returnTxt = "";
        try {
            mconn.getClient().writeValue(cntrlCmdNodeId, DataValue.valueOnly(variantNo)).get();
        } catch (InterruptedException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ExecutionException ex) {
            returnTxt = "Connection between controller and machine lost. Check the java program and machine are both running.";
            //rtm.put("error", returnTxt);
            //Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        }
        return returnTxt;
    }

    private void sendCmdRequest() {
        try {
            mconn.getClient().writeValue(cmdChangeRequestNodeId, DataValue.valueOnly(new Variant(true))).get();
        } catch (ExecutionException ex) {
            Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        } catch (InterruptedException ex) {
            //returnTxt = "Connection between controller and machine lost. Check the java program and machine are both running.";
            //rtm.put("error", returnTxt);
            //Logger.getLogger(MachineController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
