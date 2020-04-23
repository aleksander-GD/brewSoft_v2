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
 * Remember to have an copy of the simulator running.
 * TODO: Validation of inputs
 * TODO: Clean up of instantiations
 * @author Mathias
 */
@RestController
public class ControllerAPI {
    private Machine machineObj = new Machine(1, "localhost", 4840);
    private Map<Integer, MachineController> machineControllerMap = new HashMap();
    private Map<Integer, MachineSubscriber> machineSubscriberMap = new HashMap(); // NEEDED FOR SHOWING THE "LIVE" DASHBOARD
    private MachineSubscriber sub = new MachineSubscriber(machineObj);
    private MachineController mc = new MachineController(machineObj, sub);
    
    @GetMapping("/machineStart")
    public String mcStart(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Integer machineID;
        if(!machineId.isBlank()) {
            machineID = Integer.parseInt(machineId);
            if(machineControllerMap.containsKey(machineID)) {
                mc = machineControllerMap.get(machineID);
                returnText = mc.startProduction();
            } else {
                returnText = "Error, machineId not found!";
            }
        } else {
            returnText = "Error, no machine chosen!";
        }
        return returnText;
    }
    
    @GetMapping("/machineReset")
    public String mcReset(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Integer machineID;
        if(!machineId.isBlank()) {
            machineID = Integer.parseInt(machineId);
            if(machineControllerMap.containsKey(machineID)) {
                mc = machineControllerMap.get(machineID);
                returnText = mc.resetMachine();
            } else {
                returnText = "Error, machineId not found!";
            }
        } else {
            returnText = "Error, no machine chosen!";
        }
        return returnText;
    }
    
    @GetMapping("/machineClear")
    public String mcClear(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Integer machineID;
        if(!machineId.isBlank()) {
            machineID = Integer.parseInt(machineId);
            if(machineControllerMap.containsKey(machineID)) {
                mc = machineControllerMap.get(machineID);
                returnText = mc.clearState();
            } else {
                returnText = "Error, machineId not found!";
            }
        } else {
            returnText = "Error, no machine chosen!";
        }
        return returnText;
    }
    
    @GetMapping("/machineAbort")
    public String mcAbort(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Integer machineID;
        if(!machineId.isBlank()) {
            machineID = Integer.parseInt(machineId);
            if(machineControllerMap.containsKey(machineID)) {
                mc = machineControllerMap.get(machineID);
                returnText = mc.abortProduction();
            } else {
                returnText = "Error, machineId not found!";
            }
        } else {
            returnText = "Error, no machine chosen!";
        }
        return returnText;
    }
    
    @GetMapping("/machineStop")
    public String mcStop(@RequestParam(value = "machineId") String machineId) {
        String returnText;
        Integer machineID;
        if(!machineId.isBlank()) {
            machineID = Integer.parseInt(machineId);
            if(machineControllerMap.containsKey(machineID)) {
                mc = machineControllerMap.get(machineID);
                returnText = mc.stopProduction();
            } else {
                returnText = "Error, machineId not found!";
            }
        } else {
            returnText = "Error, no machine chosen!";
        }
        return returnText;
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
        ChooseMachineDataHandler cmdh = new ChooseMachineDataHandler();
        return cmdh.getMachineList();
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