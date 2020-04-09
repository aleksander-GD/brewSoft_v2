package com.BrewSoft.MachineControllerAPI.data.interfaces;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.BeerTypes;
import java.util.List;

public interface IBatchDataHandler {
    public List<BeerTypes> getBeerTypes();
}
