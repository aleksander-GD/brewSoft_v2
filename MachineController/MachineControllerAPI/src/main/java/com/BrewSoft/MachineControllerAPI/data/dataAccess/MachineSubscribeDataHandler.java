package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.Batch;
import com.BrewSoft.MachineControllerAPI.crossCutting.objects.TemporaryProductionBatch;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.SimpleSet;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.TestDatabase;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IMachineSubscriberDataHandler;
import java.sql.Date;
import java.sql.Timestamp;
import java.time.ZoneId;
import java.time.ZonedDateTime;
import java.time.format.DateTimeFormatter;

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
        Timestamp ts = getTimestamp();
        String sql = "INSERT INTO ProductionInfo(productionListID, breweryMachineID, humidity, temperature, timestamp) VALUES (?,?,?,?,?)";
        int result = connection.queryUpdate(sql, productionListID, BreweryMachineID, humidity, temperature, ts);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, productionListID, BreweryMachineID, humidity, temperature, ts);
        } else {
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
    }

    private Timestamp getTimestamp() {
        ZoneId zoneId = ZoneId.of("Europe/Copenhagen");
        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm:SS");
        ZonedDateTime zdt = ZonedDateTime.now(zoneId);
        Timestamp ts = Timestamp.from(zdt.toInstant());
        return ts;
    }
    
    private Timestamp getDatestamp() {
        ZoneId zoneId = ZoneId.of("Europe/Copenhagen");
        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("YYYY:MM:DD");
        ZonedDateTime zdt = ZonedDateTime.now(zoneId);
        Timestamp ts = Timestamp.from(zdt.toInstant());
        return ts;
    }
    
    @Override
    public void insertTimesInStates(int ProductionListID, int BreweryMachineID, int MachinestateID) {
        Timestamp ts = getTimestamp();
        
        String sql = "INSERT INTO timeInstate (productionListID, breweryMachineID, machineStateID, StartTimeInState) VALUES (?,?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, MachinestateID, ts);
        System.out.println("Res states: "+result);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, MachinestateID, ts);
        } else {
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
    }

    @Override
    public void insertStopsDuringProduction(int ProductionListID, int BreweryMachineID, int stopReasonID) {
        
        String sql = "INSERT INTO stopDuringProduction (ProductionListID, BreweryMachineID, stopReasonID) VALUES (?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, stopReasonID);
        System.out.println("Res stops: "+result);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, stopReasonID);
        } else {
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
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
        } else {
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
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
        } else {
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
    }
    
    @Override
    public boolean hasQueue(){
        return dq.isQueueExisting();
    }
    
    /**
     * HOW TO RUN THIS AUTOMATICALLY WHEN CONNECTION IS BACK??
     */
    @Override
    public void runQueue() {
        dq.runQueue();
    }

    @Override
    public Batch getNextBatch() {
        System.out.println(dq.isQueueExisting() + " : " + dq.isRunningQueue());
        if(dq.isQueueExisting() && !dq.isRunningQueue()) {
            dq.runQueue();
        }
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
        System.out.println("Res status: "+result);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql, newStatus, productionListID);
        } else {
            System.out.println("status " +dq.isQueueExisting() + " : " + dq.isRunningQueue());
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
    }

    @Override
    public void insertStoppedProductionToTempTable(TemporaryProductionBatch tempBatch) {
        Timestamp ts = getDatestamp();
        String sql = "INSERT INTO temporaryproduction (productionlistid, acceptedcount,defectcount,dateforstop) VALUES (?,?,?,?)";
        
        int result = connection.queryUpdate(sql,
                tempBatch.getProductionListId(),
                tempBatch.getAcceptedCount(),
                tempBatch.getDefectCount(),
                ts);
        System.out.println("Res temp: "+result);
        if(result == 0) {
            dq.addToQueue("queryUpdate", sql,
                    tempBatch.getProductionListId(),
                    tempBatch.getAcceptedCount(),
                    tempBatch.getDefectCount(),
                    ts);
        } else {
            System.out.println("temp " +dq.isQueueExisting() + " : " + dq.isRunningQueue());
            if(dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
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
