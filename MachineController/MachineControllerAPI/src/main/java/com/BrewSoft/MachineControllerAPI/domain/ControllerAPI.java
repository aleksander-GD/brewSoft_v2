package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.ChooseMachineDataHandler;
import com.fasterxml.jackson.databind.JsonNode;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;
/**
 * Remember to have an copy of the simulator running.
 * @author Mathias
 */
@RestController
public class ControllerAPI {
    private Machine machineObj = new Machine(1, "localhost", 4840);
    private MachineSubscriber sub = new MachineSubscriber(machineObj);
    private MachineController mc = new MachineController(machineObj, sub);
    
    @GetMapping("/machineStart")
    public String mcStart() {
        //MachineController mc = new MachineController(machineObj, sub);
        return mc.startProduction();
    }
    
    @GetMapping("/machineReset")
    public String mcReset() {
        //MachineController mc = new MachineController(machineObj, sub);
        return mc.resetMachine();
    }
    
    @GetMapping("/machineClear")
    public String mcClear() {
        //MachineController mc = new MachineController(machineObj, sub);
        return mc.clearState();
    }
    
    @GetMapping("/machineAbort")
    public String mcAbort() {
        //MachineController mc = new MachineController(machineObj, sub);
        return mc.abortProduction();
    }
    
    @GetMapping("/machineStop")
    public String mcStop() {
        //MachineController mc = new MachineController(machineObj, sub);
        return mc.stopProduction();
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
     * @param control
     * @return 
     */
    @PostMapping("/ControlMachine")
    public String controlMachine(@RequestBody JsonNode control) {
        String c = control.findValue("command").textValue();
        String txt;
        switch(c) {
            case "Start":
                txt = mc.startProduction();
                break;
            case "Stop":
                txt = mc.stopProduction();
                break;
            case "Reset":
                txt = mc.resetMachine();
                break;
            case "Clear":
                txt = mc.clearState();
                break;
            case "Abort":
                txt = mc.abortProduction();
                break;
            default:
                txt = "Unknown command";
                break;
        }
        
        return txt;
    }
    
    /**
     * 
     * @return 
     */
    @GetMapping("/ChooseMachine")
    public List<Machine> chooseMachine() {
        ChooseMachineDataHandler cmdh = new ChooseMachineDataHandler();
        return cmdh.getMachineList();
    }
    
    /**
     * 
     * @param chosenMachine
     * @return 
     */
    @PostMapping("/MachineChoice")
    public String machineChoice(@RequestBody Machine chosenMachine) {
        machineObj = chosenMachine;
        sub = new MachineSubscriber(machineObj);
        mc = new MachineController(machineObj, sub);
        return "Machine " + machineObj.getMachineID() + " chosen";
    }
}