package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.ChooseMachineDataHandler;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

/**
 * Remember to have an copy of the simulator running. TODO: Validation of inputs TODO: Clean up of instantiations
 *
 * @author Mathias
 */
@RestController
public class ControllerAPI {

    private Machine machineObj;// = new Machine(1, "localhost", 4840);
    private Map<Integer, MachineController> machineControllerMap = new HashMap();
    private Map<Integer, MachineSubscriber> machineSubscriberMap = new HashMap(); // NEEDED FOR SHOWING THE "LIVE" DASHBOARD
    private MachineSubscriber sub;// = new MachineSubscriber(machineObj);
    private MachineController mc;// = new MachineController(machineObj, sub);
    private ChooseMachineDataHandler cmdh;// = new ChooseMachineDataHandler();
    private boolean initialised;

    public ControllerAPI() {
        this.initialised = init();
    }

    private boolean init() {
        cmdh = new ChooseMachineDataHandler();
        List<Machine> machineList = cmdh.getMachineList();
        if (machineList.isEmpty()) {
            return false;
        }
        MachineSubscriber subscriber;
        for (Machine machine : machineList) {
            subscriber = new MachineSubscriber(machine);
            this.machineSubscriberMap.put(machine.getMachineID(), subscriber);
            this.machineControllerMap.put(machine.getMachineID(), new MachineController(machine, subscriber));
        }
        return true;
    }

    @GetMapping("/machineStart")
    public Map<String, String> mcStart(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Map<String, String> rtm = new HashMap();
        Integer machineID;
        if (!initialised) {
            initialised = init();
        }
        if (initialised) {
            if (!machineId.isBlank()) {
                machineID = Integer.parseInt(machineId);
                if (machineControllerMap.containsKey(machineID)) {
                    mc = machineControllerMap.get(machineID);
                    mc.connectMachine();
                    //returnText = mc.startProduction();
                    rtm.putAll(mc.startProduction());
                    System.out.println(rtm);
                    sub = machineSubscriberMap.get(machineID);
                    sub.connectMachine();
                    sub.subscribe();
                } else {
                    returnText = "MachineId not found!";
                    rtm.put("Error", returnText);
                }
            } else {
                returnText = "No machine chosen!";
                rtm.put("Error", returnText);
            }
        } else {
            returnText = "Connection to database failed. No machine information available.";
            rtm.put("Error", returnText);
        }
        return rtm;
    }

    @GetMapping("/machineReset")
    public Map<String, String> mcReset(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Map<String, String> rtm = new HashMap();
        Integer machineID;
        if (!initialised) {
            initialised = init();
        }
        if (initialised) {
            if (!machineId.isBlank()) {
                machineID = Integer.parseInt(machineId);
                if (machineControllerMap.containsKey(machineID)) {
                    mc = machineControllerMap.get(machineID);
                    mc.connectMachine();
                    //returnText = mc.resetMachine();
                    rtm.putAll(mc.resetMachine());
                    //rtm.put("Success",returnText);
                } else {
                    returnText = "MachineId not found!";
                    rtm.put("Error", returnText);
                }
            } else {
                returnText = "No machine chosen!";
                rtm.put("Error", returnText);
            }
        } else {
            returnText = "Connection to database failed. No machine information available.";
            rtm.put("Error", returnText);
        }
        return rtm;
    }

    @GetMapping("/machineClear")
    public Map<String, String> mcClear(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Map<String, String> rtm = new HashMap();
        Integer machineID;
        if (!initialised) {
            initialised = init();
        }
        if (initialised) {
            if (!machineId.isBlank()) {
                machineID = Integer.parseInt(machineId);
                if (machineControllerMap.containsKey(machineID)) {
                    mc = machineControllerMap.get(machineID);
                    mc.connectMachine();
                    //returnText = mc.clearState();
                    rtm.putAll(mc.clearState());
                } else {
                    returnText = "MachineId not found!";
                    rtm.put("Error", returnText);
                }
            } else {
                returnText = "No machine chosen!";
                rtm.put("Error", returnText);
            }
        } else {
            returnText = "Connection to database failed. No machine information available.";
            rtm.put("Error", returnText);
        }
        return rtm;
    }

    @GetMapping("/machineAbort")
    public Map<String, String> mcAbort(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Map<String, String> rtm = new HashMap();
        Integer machineID;
        if (!initialised) {
            initialised = init();
        }
        if (initialised) {
            if (!machineId.isBlank()) {
                machineID = Integer.parseInt(machineId);
                if (machineControllerMap.containsKey(machineID)) {
                    mc = machineControllerMap.get(machineID);
                    mc.connectMachine();
                    //returnText = mc.abortProduction();
                    rtm.putAll(mc.abortProduction());
                } else {
                    returnText = "MachineId not found!";
                    rtm.put("Error", returnText);
                }
            } else {
                returnText = "No machine chosen!";
                rtm.put("Error", returnText);
            }
        } else {
            returnText = "Connection to database failed. No machine information available.";
            rtm.put("Error", returnText);
        }
        return rtm;
    }

    @GetMapping("/machineStop")
    public Map<String, String> mcStop(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Map<String, String> rtm = new HashMap();
        Integer machineID;
        if (!initialised) {
            initialised = init();
        }
        if (initialised) {
            if (!machineId.isBlank()) {
                machineID = Integer.parseInt(machineId);
                if (machineControllerMap.containsKey(machineID)) {
                    mc = machineControllerMap.get(machineID);
                    mc.connectMachine();
                    //returnText = mc.stopProduction();
                    rtm.putAll(mc.stopProduction());
                } else {
                    returnText = "MachineId not found!";
                    rtm.put("Error", returnText);
                }
            } else {
                returnText = "No machine chosen!";
                rtm.put("Error", returnText);
            }
        } else {
            returnText = "Connection to database failed. No machine information available.";
            rtm.put("Error", returnText);
        }
        return rtm;
    }

    // Rewrite to get list of controls from class?
    @GetMapping("/MachineControls")
    public Map<String, List> machineControls() {
        Map<String, List> machineControls = new HashMap();
        List<String> controls = new ArrayList();
        controls.add("Start");
        controls.add("Stop");
        controls.add("Reset");
        controls.add("Clear");
        controls.add("Abort");
        machineControls.put("commands", controls);
        return machineControls;
    }

    /**
     *
     * @return
     */
    @GetMapping("/availableMachines")
    public List<Machine> availableMachine() {
        return this.cmdh.getMachineList();
    }

    /**
     *
     * @param chosenMachine
     * @return
     */
    @PostMapping("/chooseMachine")
    public String chooseMachine(@RequestBody Machine chosenMachine) {
        machineObj = chosenMachine;
        sub = new MachineSubscriber(machineObj);
        machineSubscriberMap.put(machineObj.getMachineID(), sub);
        mc = new MachineController(machineObj, sub);
        machineControllerMap.put(machineObj.getMachineID(), mc);
        return "Machine " + machineObj.getMachineID() + " chosen";
    }
}
