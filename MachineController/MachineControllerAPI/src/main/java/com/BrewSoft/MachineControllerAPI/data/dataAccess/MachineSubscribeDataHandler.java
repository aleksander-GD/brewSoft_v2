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
            float humidity, float temperature, float vibration) {
        float humidityMin = 21.0f;
        float humidityMax = 34.0f;
        float temperatureMin = 26.0f;
        float temperatureMax = 33.0f;
        String humidityAlarm = "Humidity alarm!";
        String temperatureAlarm = "Temperature alarm!";

        Timestamp ts = getTimestamp();
        Timestamp td = getDatestamp();

        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }

        String sql = "INSERT INTO ProductionInfo(productionListID, breweryMachineID, humidity, temperature, vibration, entrytime, entrydate) VALUES (?,?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql, productionListID, BreweryMachineID, humidity, temperature, vibration, ts, td);

        if (result == 0) {
            dq.addToQueue("queryUpdate", sql, productionListID, BreweryMachineID, humidity, temperature, vibration, ts, td);
        }

        /* MAYBE USE productionlist AND NOT productioninfo? ALARM BLIVER IKKE SAT I KØ */
        // if info outside safe ranges, get productioninfoID and insert alarm into alarm table.
        if (humidity <= humidityMin || humidity >= humidityMax || temperature <= temperatureMin || temperature >= temperatureMax) {
            String getSql = "SELECT * FROM productioninfo ORDER BY productioninfoid DESC limit 1;";
            SimpleSet set = connection.query(getSql);
            int productionInfoID = 0;
            for (int i = 0; i < set.getRows(); i++) {
                productionInfoID = Integer.valueOf(String.valueOf(set.get(i, "productioninfoid")));
            }
            String alarmSql = "INSERT INTO alarmlog(productioninfoid, alarm, entrytime) VALUES (?,?,?);";
            if (humidity <= humidityMin || humidity >= humidityMax) {
                int humidInsert = connection.queryUpdate(alarmSql, productionInfoID, humidityAlarm, ts);
            }
            if (temperature <= temperatureMin || temperature >= temperatureMax) {
                int tempInsert = connection.queryUpdate(alarmSql, productionInfoID, temperatureAlarm, ts);
            }
        }

    }

    private Timestamp getTimestamp() {
        ZoneId zoneId = ZoneId.of("Europe/Copenhagen");
        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("HH:mm:ss.SSS");
        ZonedDateTime zdt = ZonedDateTime.now(zoneId);
        Timestamp ts = Timestamp.from(zdt.toInstant());
        return ts;
    }

    private Timestamp getDatestamp() {
        ZoneId zoneId = ZoneId.of("Europe/Copenhagen");
        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("YYYY/MM/DD");
        ZonedDateTime zdt = ZonedDateTime.now(zoneId);
        Timestamp ts = Timestamp.from(zdt.toInstant());
        return ts;
    }

    @Override
    public void insertTimesInStates(int ProductionListID, int BreweryMachineID, int MachinestateID) {
        Timestamp ts = getTimestamp();
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }

        String sql = "INSERT INTO timeInstate (productionListID, breweryMachineID, machineStateID, StartTimeInState) VALUES (?,?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, MachinestateID, ts);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, MachinestateID, ts);
        }
    }

    @Override
    public void insertStopsDuringProduction(int ProductionListID, int BreweryMachineID, int stopReasonID) {
        Timestamp ts = getTimestamp();
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }

        String sql = "INSERT INTO stopDuringProduction (ProductionListID, BreweryMachineID, stopReasonID, entrytime) VALUES (?,?,?,?)";
        int result = connection.queryUpdate(sql, ProductionListID, BreweryMachineID, stopReasonID, ts);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql, ProductionListID, BreweryMachineID, stopReasonID, ts);
        }

    }

    /*
    public void insertFinalBatchInformation(int ProductionListID,
            int BreweryMachineID, String deadline, String dateOfCreation,
            String dateOfCompleation, int productID, float totalCount, int defectCount, int acceptedCount) {

        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }

        String sql = "INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, "
                + "dateOfCreation, dateOfCompletion, productID, totalCount, "
                + "defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql,
                ProductionListID, BreweryMachineID, Date.valueOf(deadline),
                Date.valueOf(dateOfCreation), Date.valueOf(dateOfCompleation),
                productID, totalCount, defectCount, acceptedCount);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql,
                    ProductionListID, BreweryMachineID, Date.valueOf(deadline),
                    Date.valueOf(dateOfCreation), Date.valueOf(dateOfCompleation),
                    productID, totalCount, defectCount, acceptedCount);
        }
    }
     */
    @Override
    public void insertFinalBatchInformation(int ProductionListID, int BreweryMachineID,
            String deadline, String dateOfCreation, int productID, float totalCount,
            int defectCount, int acceptedCount) {
        Timestamp td = getDatestamp();
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }

        /*String sql = "INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, dateOfCreation, "
                + "productID, totalCount, defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?)";*/
        String sql = "INSERT INTO finalBatchInformation "
                + "(ProductionListID, BreweryMachineID, deadline, "
                + "dateOfCreation, dateOfCompletion, productID, totalCount, "
                + "defectCount, acceptedCount) "
                + "values(?,?,?,?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql,
                ProductionListID,
                BreweryMachineID,
                Date.valueOf(deadline),
                Date.valueOf(dateOfCreation),
                td,
                productID,
                totalCount,
                defectCount,
                acceptedCount);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql,
                    ProductionListID,
                    BreweryMachineID,
                    Date.valueOf(deadline),
                    Date.valueOf(dateOfCreation),
                    td,
                    productID,
                    totalCount,
                    defectCount,
                    acceptedCount);
        }
        changeMachineStatus(false, ProductionListID);
    }

    @Override
    public void changeMachineStatus(boolean Status, int breweryMachineId) {
        String sql = "UPDATE brewerymachine SET running = ? WHERE breweryMachineId = ?";
        int result = connection.queryUpdate(sql, Status, breweryMachineId);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql, Status, breweryMachineId);
        }
    }
    
    @Override
    public boolean checkMachineStatus(int breweryMachineId) {
        String sql = "SELECT running FROM brewerymachine WHERE breweryMachineId = ?";
        SimpleSet set = connection.query(sql, breweryMachineId);
        boolean t = Boolean.valueOf(String.valueOf(set.get(0, "running")));
        //Arrays.deepToString(values)
        System.out.println(t);
        return t;
    }
    
    @Override
    public boolean hasQueue() {
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
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
        Batch batch = null;                                                                
        SimpleSet batchSet = connection.query("SELECT * FROM productionlist WHERE status = 'queued' OR status = 'stopped' ORDER BY deadline ASC limit 1");

        if (batchSet.isEmpty()) {
            return null;
        } else if ("stopped".equals(String.valueOf(batchSet.get(0, "status")))) {
            TemporaryProductionBatch tpb = getTemporaryProductionBatch((int) batchSet.get(0, "productionlistid"));
            if (tpb != null) {
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
                // IN CASE DATA WAS DELETED FROM TEMPORARY PRODUCTION TABLE - WITHOUT THE STATUS BEING CHANGED
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
    public void changeProductionListStatus(int productionListID, String newStatus, int machineID) {
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
        String sql = "UPDATE productionList SET status = ?, machineid = ? WHERE productionListID = ?";
        int result = connection.queryUpdate(sql, newStatus, machineID, productionListID);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql, newStatus, machineID, productionListID);
        }
    }

    @Override
    public void insertStoppedProductionToTempTable(TemporaryProductionBatch tempBatch) {
        Timestamp ts = getDatestamp();
        if (connection.isConnected()) {
            if (dq.isQueueExisting() && !dq.isRunningQueue()) {
                dq.runQueue();
            }
        }
        String sql = "INSERT INTO temporaryproduction (productionlistid, acceptedcount,defectcount,dateforstop) VALUES (?,?,?,?)";

        int result = connection.queryUpdate(sql,
                tempBatch.getProductionListId(),
                tempBatch.getAcceptedCount(),
                tempBatch.getDefectCount(),
                ts);
        if (result == 0) {
            dq.addToQueue("queryUpdate", sql,
                    tempBatch.getProductionListId(),
                    tempBatch.getAcceptedCount(),
                    tempBatch.getDefectCount(),
                    ts);
        }
    }

    @Override
    public void ingredientsUpdate(int barley, int hops, int malt, int wheat, int yeast, int machineID) {
        String sql = "INSERT INTO ingredientsupdate (barley, hops, malt, wheat, yeast, brewerymachineid) VALUES (?,?,?,?,?,?)";
        int result = connection.queryUpdate(sql, barley, hops, malt, wheat, yeast, machineID);
    }

    @Override
    public void machinedata(int machineID, float maintenace, int state) {
        String sql = "INSERT INTO machinedata (brewerymachineid, maintenace, state) VALUES (?,?,?)";
        int result = connection.queryUpdate(sql, machineID, maintenace, state);
    }

    @Override
    public void producedData(int productionlistid, int produced, int acceptable, int defect, int machineid) {
        String sql = "INSERT INTO produceddata (productionlistid, produced, acceptable, defect, brewerymachineid) VALUES (?,?,?,?,?)";
        int result = connection.queryUpdate(sql, productionlistid, produced, acceptable, defect, machineid);
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
