package com.BrewSoft.MachineControllerAPI.data.interfaces;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
//import com.mycompany.crossCutting.objects.BatchReport;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.BeerTypes;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.MachineHumiData;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.MachineState;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.MachineTempData;
import java.util.ArrayList;
import java.util.List;

public interface IBatchDataHandler {

    public void insertBatchToQueue(Batch batch);

    public ArrayList<Batch> getQueuedBatches();

    public Integer getLatestBatchID();

    public List<MachineState> getMachineState(int prodListID, int machineID);

    public List<MachineTempData> getMachineTempData(int prodID, int machineID);

    public List<MachineHumiData> getMachineHumiData(int prodID, int machineID);

    // public MachineData getMachineTempData(int prodID, int machineID);
    //public BatchReport getBatchReportProductionData(int batchID, int machineID);

    public void editQueuedBatch(Batch batch);

    //public List getAcceptedCount(LocalDate dateofcompleation);
    
    public List<BeerTypes> getBeerTypes();
}
