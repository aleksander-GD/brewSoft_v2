package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.TemporaryProductionBatch;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.SimpleSet;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.TestDatabase;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import java.sql.Date;

public class MachineSubscribeDataHandler implements IMachineSubscriberDataHandler {

    public DatabaseConnection connection;
    private DatabaseQueue dq;
    

    public MachineSubscribeDataHandler() {
        connection = new DatabaseConnection();
        dq = new DatabaseQueue();
        
    }

    public MachineSubscribeDataHandler(TestDatabase testDatabase) {
        connection = testDatabase;
        dq = new DatabaseQueue();
    }

    @Override
    public void insertProductionInfo(int productionListID, int BreweryMachineID,
            float humidity, float temperature) {
        String sql = "INSERT INTO ProductionInfo(productionListID, breweryMachineID, humidity, temperature) VALUES (?,?,?,?)";
        int result = connection.queryUpdate(sql, productionListID, BreweryMachineID, humidity, temperature);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, productionListID, BreweryMachineID, humidity, temperature);
        }
    }

    @Override
    public void insertTimesInStates(int ProductionListID, int BreweryMachineID, int MachinestateID) {
        String sql = "INSERT INTO timeInstate (productionListID, breweryMachineID, machineStateID) VALUES (?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, MachinestateID);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, MachinestateID);
        }
    }

    @Override
    public void insertStopsDuringProduction(int ProductionListID, int BreweryMachineID, int stopReasonID) {
        String sql = "INSERT INTO stopDuringProduction (ProductionListID, BreweryMachineID, stopReasonID) VALUES (?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, stopReasonID);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, stopReasonID);
        }
    }

    public void insertFinalBatchInformation(int ProductionListID,
            int BreweryMachineID, String deadline, String dateOfCreation,
            String dateOfCompleation, int productID, float totalCount, int defectCount, int acceptedCount) {
        String sql = "INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, "
                + "dateOfCreation, dateOfCompletion, productID, totalCount, "
                + "defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql,
                ProductionListID, BreweryMachineID, Date.valueOf(deadline),
                Date.valueOf(dateOfCreation), Date.valueOf(dateOfCompleation),
                productID, totalCount, defectCount, acceptedCount);
        
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, Date.valueOf(deadline),
                Date.valueOf(dateOfCreation), Date.valueOf(dateOfCompleation),
                productID, totalCount, defectCount, acceptedCount);
        }
    }

    @Override
    public void insertFinalBatchInformation(int ProductionListID, int BreweryMachineID,
            String deadline, String dateOfCreation, int productID, float totalCount,
            int defectCount, int acceptedCount) {
        String sql = "INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, dateOfCreation, "
                + "productID, totalCount, defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql,
                ProductionListID,
                BreweryMachineID,
                Date.valueOf(deadline),
                Date.valueOf(dateOfCreation),
                productID,
                totalCount,
                defectCount,
                acceptedCount);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql,
                ProductionListID,
                BreweryMachineID,
                Date.valueOf(deadline),
                Date.valueOf(dateOfCreation),
                productID,
                totalCount,
                defectCount,
                acceptedCount);
        }
    }

    @Override
    public Batch getNextBatch() {
        Batch batch = null;
        SimpleSet batchSet = connection.query("SELECT * FROM productionlist WHERE status = 'queued' OR status = 'stopped' ORDER BY deadline ASC limit 1");

        if (batchSet.isEmpty()) {
            return null;
        } else if ("stopped".equals(String.valueOf(batchSet.get(0, "status")))) {
            TemporaryProductionBatch tpb = getTemporaryProductionBatch((int) batchSet.get(0, "productionlistid"));
            for (int i = 0; i < batchSet.getRows(); i++) {
                batch = new Batch(
                        (int) batchSet.get(i, "productionListID"),
                        (int) batchSet.get(i, "batchid"),
                        (int) batchSet.get(i, "productid"),
                        (int) batchSet.get(i, "productamount") - (int) tpb.getAcceptedCount(),
                        String.valueOf(batchSet.get(i, "deadline")),
                        Float.parseFloat(String.valueOf(batchSet.get(i, "speed"))),
                        String.valueOf(batchSet.get(i, "dateofcreation"))
                );
            }
        } else {
            for (int i = 0; i < batchSet.getRows(); i++) {
                batch = new Batch(
                        (int) batchSet.get(i, "productionListID"),
                        (int) batchSet.get(i, "batchid"),
                        (int) batchSet.get(i, "productid"),
                        (int) batchSet.get(i, "productamount"),
                        String.valueOf(batchSet.get(i, "deadline")),
                        Float.parseFloat(String.valueOf(batchSet.get(i, "speed"))),
                        String.valueOf(batchSet.get(i, "dateofcreation"))
                );
            }
        }
        return batch;
    }

    @Override
    public void changeProductionListStatus(int productionListID, String newStatus) {
        String sql = "UPDATE productionList SET status = ? WHERE productionListID = ?";
        int result = connection.queryUpdate(sql, newStatus, productionListID);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, newStatus, productionListID);
        }
    }

    @Override
    public void insertStoppedProductionToTempTable(TemporaryProductionBatch tempBatch) {
        String sql = "INSERT INTO temporaryproduction (productionlistid, acceptedcount,defectcount) VALUES (?,?,?)";
        
        int result = connection.queryUpdate(sql,
                tempBatch.getProductionListId(),
                tempBatch.getAcceptedCount(),
                tempBatch.getDefectCount());
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql,
                    tempBatch.getProductionListId(),
                    tempBatch.getAcceptedCount(),
                    tempBatch.getDefectCount());
        }
    }

    private TemporaryProductionBatch getTemporaryProductionBatch(int productionlistid) {
        TemporaryProductionBatch tpb = null;
        
        SimpleSet set = connection.query("SELECT tp.*, pl.productamount "
                + "FROM temporaryproduction AS tp, productionlist AS pl "
                + "WHERE tp.productionlistid = ?", productionlistid);
        if (set.isEmpty()) {
            return null;
        } else {
            for (int i = 0; i < set.getRows(); i++) {
                tpb = new TemporaryProductionBatch(
                        productionlistid,
                        Float.parseFloat(String.valueOf(set.get(i, "acceptedcount"))),
                        Float.parseFloat(String.valueOf(set.get(i, "defectcount")))
                );
            }
            return tpb;
        }
    }
}
