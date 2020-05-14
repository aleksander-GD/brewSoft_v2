package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.SimpleSet;
import java.util.ArrayList;
import java.util.List;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IChooseMachineDataHandler;

public class ChooseMachineDataHandler implements IChooseMachineDataHandler {
    private DatabaseConnection dbConnection;

    public ChooseMachineDataHandler() {
        dbConnection = new DatabaseConnection();
    }
    
    @Override
    public List<Machine> getMachineList() {
        List<Machine> machineList = new ArrayList();
        
        SimpleSet set = dbConnection.query("SELECT * FROM brewerymachine;");
        for (int i = 0; i < set.getRows(); i++) {
            machineList.add(new Machine(
                    (int) set.get(i, "brewerymachineid"),
                    String.valueOf(set.get(i, "hostname")),
                    (int) set.get(i, "port")
            ));
        }
        
        return machineList;
    }

}
