package com.BrewSoft.MachineControllerAPI.data.interfaces;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
//import com.mycompany.crossCutting.objects.BeerTypes;
import java.util.ArrayList;
//import java.util.List;

public interface IManagementData {

    //public List<BeerTypes> getBeerTypes();

    public ArrayList<Batch> getCompletedBatches();

}
