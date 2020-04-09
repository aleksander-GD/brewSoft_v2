package com.BrewSoft.MachineControllerAPI.domain;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.ChooseMachineDataHandler;
import java.util.List;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
/**
 * This has not been tested yet, but should work.
 * TODO: setting up database connection
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
    /**
     * NO IDEA IF THIS WORKS
     * TODO: Catch response and create the correct machineObj
     * @return 
     */
    @GetMapping("/ChooseMachine")
    public List<Machine> chooseMachine() {
        ChooseMachineDataHandler cmdh = new ChooseMachineDataHandler();
        return cmdh.getMachineList();
    }
    
    @PostMapping("/MachineChoice")
    public String machineChoice(@RequestBody Machine chosenMachine) {
        machineObj = chosenMachine;
        sub = new MachineSubscriber(machineObj);
        mc = new MachineController(machineObj, sub);
        return "Machine chosen";
    }
}