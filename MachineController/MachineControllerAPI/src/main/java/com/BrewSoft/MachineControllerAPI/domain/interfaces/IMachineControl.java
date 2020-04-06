package com.BrewSoft.MachineControllerAPI.domain.interfaces;

public interface IMachineControl {

    public String startProduction();

    public String resetMachine();

    public String stopProduction();

    public String abortProduction();

    public String clearState();
}
