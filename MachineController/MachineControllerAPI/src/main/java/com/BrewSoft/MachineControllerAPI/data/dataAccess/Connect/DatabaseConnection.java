package com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.QueueObject;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.DatabaseQueue;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.LinkedList;
import java.util.Queue;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;

public class DatabaseConnection {

    final private String url;
    final private String user;
    final private String password;
    private Connection con;
    Queue<QueueObject> queue;
    private int t;
    //

    public DatabaseConnection() {
        this.url = "jdbc:postgresql://tek-mmmi-db0a.tek.c.sdu.dk:5432/si3_2019_group_2_db";
        this.user = "si3_2019_group_2";
        this.password = "did3+excises";
        this.queue = new LinkedList();
        this.t = new Random().nextInt();
        //dq = new DatabaseQueue();
    }

    private Connection connect() throws SQLException, ClassNotFoundException {
        return DriverManager.getConnection(url, user, password);

    }
    
    public int addToQueue(String fn, String sql, Object... values) {
        QueueObject qo = new QueueObject(fn, sql, values);
        queue.add(qo);
        System.out.println("DC: "+t);
        for (QueueObject queueObject : queue) {
            //System.out.println(queueObject);
        }
        return queue.size();
    }

    public void runQueue() {
        for (QueueObject queueObject : queue) {
            try {
                System.out.println("--------- RUNNING QUEUE ----------");
                String sql = queueObject.getSql();
                Method m = this.getClass().getDeclaredMethod(queueObject.getFunction(), String.class, Object[].class);
                m.invoke(this, sql, queueObject.getValues());
            } catch (NoSuchMethodException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
                System.out.println("METHOD NOT FOUND");
            } catch (SecurityException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IllegalAccessException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
                System.out.println("ILLEGAL ACCESS?");
            } catch (IllegalArgumentException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
                System.out.println("ILLEGAL ARGUMENT?");
            } catch (InvocationTargetException ex) {
                Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    private PreparedStatement prepareStatement(String query, Object... values) {
        PreparedStatement statement = null;

        try {
            con = connect();
            statement = con.prepareStatement(query);

            for (int i = 0; i < values.length; i++) {
                statement.setObject(i + 1, values[i]);
            }

        } catch (SQLException ex) {
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
        }
        return statement;
    }

    public int queryUpdate(String query, Object... values) {
        int affectedRows = 0;
        try (PreparedStatement statement = prepareStatement(query, values)) {

            statement.executeUpdate();

        } catch (SQLException ex) {
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
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
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            disconnect();
            return set;
        }
    }

    private void disconnect() {
        try {
            con.close();
        } catch (SQLException ex) {
            Logger.getLogger(DatabaseConnection.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
