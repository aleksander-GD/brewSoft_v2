package com.BrewSoft.MachineControllerAPI.data.interfaces;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Machine;
import java.util.List;

public interface IChooseMachineDataHandler {
    public List<Machine> getMachineList();
}
