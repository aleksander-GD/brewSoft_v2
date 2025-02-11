package com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect;

import com.BrewSoft.MachineControllerAPI.data.dataAccess.DatabaseQueue;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

public class DatabaseConnection {

    final private String url;
    final private String user;
    final private String password;
    private Connection con;
    private boolean connected;

    public DatabaseConnection() {
        this.url = "jdbc:postgresql://tek-mmmi-db0a.tek.c.sdu.dk:5432/si3_2019_group_2_db";
        this.user = "si3_2019_group_2";
        this.password = "did3+excises";
        connected = false;
    }

    private Connection connect() throws SQLException, ClassNotFoundException {
        return DriverManager.getConnection(url, user, password);

    }
    
    private PreparedStatement prepareStatement(String query, Object... values) {
        PreparedStatement statement = null;

        try {
            con = connect();
            connected = true;
            statement = con.prepareStatement(query);

            for (int i = 0; i < values.length; i++) {
                statement.setObject(i + 1, values[i]);
            }
            //System.out.println("statement: "+statement);
        } catch (SQLException ex) {
            if(ex.getSQLState().equalsIgnoreCase("08001")) {
                /**
                 * HUGE GAMBLE, NO IDEA ABOUT "smells"
                 * 
                 */
                connected = false;
                //System.out.println("prepare USING QUEUE AND NOT DATABASE?!?");
                /* THREADING NEEDED FOR THIS TO WORK
                while(!connected) {
                    try {
                        con = connect();
                        connected = true;
                        databasequeue.runQueue();
                    } catch (SQLException ex1) {
                        if(ex.getSQLState().equalsIgnoreCase("08001")) {
                            System.out.println("Still not connected to database");
                            // Return value perhaps?
                        } else {
                            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex1);
                        }
                    } catch (ClassNotFoundException ex1) {
                        Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex1);
                    }
                }
*/
                // retry connecting to DB automatically?
            } else {
                System.out.println("SQL exception - logging");
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
        }
        return statement;
    }

    public int queryUpdate(String query, Object... values) {
        int affectedRows = 0;
        try (PreparedStatement statement = prepareStatement(query, values)) {

            affectedRows = statement.executeUpdate();

        } catch (SQLException ex) {
            if(ex.getSQLState().equalsIgnoreCase("08001")) {
                System.out.println("USING QUEUE AND NOT DATABASE?!?");
                // retry connecting to DB automatically?
            } else {
                System.out.println("SQL exception - logging");
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
        } finally {
            disconnect();
            return affectedRows;
        }
    }

    public SimpleSet query(String query, Object... values) {

        SimpleSet set = new SimpleSet();
        try (PreparedStatement statement = prepareStatement(query, values)) {
            try (ResultSet rs = statement.executeQuery()) {
                while (rs.next()) {

                    int count = rs.getMetaData().getColumnCount();
                    String[] labels = new String[count];
                    Object[] objcts = new Object[count];

                    for (int i = 0; i < count; i++) {
                        labels[i] = rs.getMetaData().getColumnName(i + 1);
                        objcts[i] = rs.getObject(i + 1);

                        if (rs.wasNull()) {
                            objcts[i] = null;
                        }
                    }

                    set.add(labels, objcts);
                }
            }
        } catch (SQLException ex) {
            if(ex.getSQLState().equalsIgnoreCase("08001")) {
                System.out.println("GETTING BATCH INFO WITHOUT DATABASE?!?");
                // retry connecting to DB automatically?
            } else {
                System.out.println("SQL exception - logging");
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
        } finally {
            disconnect();
            return set;
        }
    }

    private void disconnect() {
        if(con != null) {
            try {
                con.close();
                //connected = false;
            } catch (SQLException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    public boolean isConnected() {
        return this.connected;
    }
}
