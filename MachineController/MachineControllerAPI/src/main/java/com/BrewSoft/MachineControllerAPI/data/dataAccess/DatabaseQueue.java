package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.QueueObject;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.LinkedList;
import java.util.Queue;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Mathias
 */
public class DatabaseQueue {
    Queue<QueueObject> queue;
    private int t;
    //DatabaseConnection con;
    
    public DatabaseQueue() {
        //this.con = new DatabaseConnection();
        this.queue = new LinkedList();
        this.t = new Random().nextInt();
    }
    
    public int addToQueue(String fn, String sql, Object... values) {
        QueueObject qo = new QueueObject(fn, sql, values);
        queue.add(qo);
        System.out.println("DQ: "+t);
        for (QueueObject queueObject : queue) {
            //System.out.println(queueObject);
        }
        return queue.size();
    }

    public void runQueue() {
        /*
        for (QueueObject queueObject : queue) {
            try {
                System.out.println("--------- RUNNING QUEUE ----------");
                String sql = queueObject.getSql();
                Method m = con.getClass().getDeclaredMethod(queueObject.getFunction(), String.class, Object[].class);
                m.invoke(con, sql, queueObject.getValues());
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
        */
    }
}
