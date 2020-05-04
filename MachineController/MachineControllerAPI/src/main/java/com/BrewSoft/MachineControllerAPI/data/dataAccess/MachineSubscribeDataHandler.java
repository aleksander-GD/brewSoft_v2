package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.TemporaryProductionBatch;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.SimpleSet;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.TestDatabase;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import java.sql.Date;
import java.util.Random;

public class MachineSubscribeDataHandler implements IMachineSubscriberDataHandler {

    public DatabaseConnection connection;
    private int queueLength;
    private int t;
    private DatabaseQueue dq;

    public MachineSubscribeDataHandler() {
        connection = new DatabaseConnection();
        this.t = new Random().nextInt();
        dq = new DatabaseQueue();
    }

    public MachineSubscribeDataHandler(TestDatabase testDatabase) {
        connection = testDatabase;
    }

    @Override
    public void insertProductionInfo(int productionListID, int BreweryMachineID,
            float humidity, float temperature) {
        String sql = "INSERT INTO ProductionInfo(productionListID, breweryMachineID, humidity, temperature) VALUES (?,?,?,?)";
        queueLength = dq.addToQueue("queryUpdate", sql, productionListID, BreweryMachineID, humidity, temperature);
        System.out.println("msdh: " + t + " ipi - queue: " + queueLength);
//        queueLength = connection.addToQueue("queryUpdate", sql, productionListID, BreweryMachineID, humidity, temperature);
//        System.out.println("msdh: " + t + " ipi - queue: " + queueLength);
//        if(queueLength > 5) {
//            connection.runQueue();
//        }
/*
        connection.queryUpdate("INSERT INTO ProductionInfo(productionListID, breweryMachineID, humidity, temperature) VALUES (?,?,?,?)",
                productionListID, BreweryMachineID, humidity, temperature);
*/
    }

    @Override
    public void insertTimesInStates(int ProductionListID, int BreweryMachineID, int MachinestateID) {
       // connection.queryUpdate("INSERT INTO timeInstate (productionListID, breweryMachineID, machineStateID) VALUES (?,?,?)",
       //         ProductionListID, BreweryMachineID, MachinestateID);
    }

    @Override
    public void insertStopsDuringProduction(int ProductionListID, int BreweryMachineID, int stopReasonID) {
        //connection.queryUpdate("INSERT INTO stopDuringProduction (ProductionListID, BreweryMachineID, stopReasonID) VALUES (?,?,?)",
        //        ProductionListID, BreweryMachineID, stopReasonID);
    }

    public void insertFinalBatchInformation(int ProductionListID,
            int BreweryMachineID, String deadline, String dateOfCreation,
            String dateOfCompleation, int productID, float totalCount, int defectCount, int acceptedCount) {
        /*connection.queryUpdate("INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, "
                + "dateOfCreation, dateOfCompletion, productID, totalCount, "
                + "defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?,?)",
                ProductionListID, BreweryMachineID, Date.valueOf(deadline),
                Date.valueOf(dateOfCreation), Date.valueOf(dateOfCompleation),
                productID, totalCount, defectCount, acceptedCount);
        */
    }

    @Override
    public void insertFinalBatchInformation(int ProductionListID, int BreweryMachineID,
            String deadline, String dateOfCreation, int productID, float totalCount,
            int defectCount, int acceptedCount) {
        /*connection.queryUpdate("INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, dateOfCreation, "
                + "productID, totalCount, defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?)",
                ProductionListID,
                BreweryMachineID,
                Date.valueOf(deadline),
                Date.valueOf(dateOfCreation),
                productID,
                totalCount,
                defectCount,
                acceptedCount);
        */
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
        queueLength = dq.addToQueue("queryUpdate", sql, newStatus, productionListID);
        System.out.println("msdh: " + t + " cpls - queue: " + queueLength);
//        queueLength = connection.addToQueue("queryUpdate", sql, newStatus, productionListID);
//        System.out.println("msdh: " + t + " cpls - queue: " + queueLength);
//        if(queueLength > 5) {
//            connection.runQueue();
//        }
/*        
connection.queryUpdate("UPDATE productionList SET status = ? WHERE productionListID = ?",
                newStatus,
                productionListID);
*/
    }

    @Override
    public void insertStoppedProductionToTempTable(TemporaryProductionBatch tempBatch) {
        String sql = "INSERT INTO temporaryproduction (productionlistid, acceptedcount,defectcount) VALUES (?,?,?)";
        queueLength = dq.addToQueue("queryUpdate", sql, tempBatch);
        System.out.println("msdh: " + t + " ispttt - queue: " + queueLength);
//        queueLength = connection.addToQueue("queryUpdate", sql, tempBatch);
//        System.out.println("msdh: " + t + " ispttt - queue: " + queueLength);
//        if(queueLength > 5) {
//            connection.runQueue();
//        }
/*
        connection.queryUpdate("INSERT INTO temporaryproduction (productionlistid, acceptedcount,defectcount) VALUES (?,?,?)",
                tempBatch.getProductionListId(),
                tempBatch.getAcceptedCount(),
                tempBatch.getDefectCount());
*/
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
