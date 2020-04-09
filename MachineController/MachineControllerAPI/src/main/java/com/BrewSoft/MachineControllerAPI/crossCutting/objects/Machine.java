package com.BrewSoft.MachineControllerAPI.crossCutting.objects;

public class Machine {

    private String hostname;
    private Integer port;
    private Integer machineID;
    
    public Machine(Integer machineID, String hostname, Integer port) {
        this.machineID = machineID;
        this.hostname = hostname;
        this.port = port;
    }
    
    public Integer getMachineID() {
        return machineID;
    }

    public String getHostname() {
        return hostname;
    }

    public void setHostname(String hostname) {
        this.hostname = hostname;
    }

    public void setPort(int port) {
        this.port = port;
    }

    public Integer getPort() {
        return port;
    }

    @Override
    public String toString() {
        return getMachineID() + " " + getHostname() + " " + getPort();
    }

    
}
