package com.BrewSoft.MachineControllerAPI.domain.interfaces;

import java.util.Map;

public interface IMachineControl {

    public Map<String, String> connectMachine();
    
    public Map<String, String> startProduction();

    public Map<String, String> resetMachine();

    public Map<String, String> stopProduction();
    
    public Map<String, String> abortProduction();
    
    public Map<String, String> clearState();

}
