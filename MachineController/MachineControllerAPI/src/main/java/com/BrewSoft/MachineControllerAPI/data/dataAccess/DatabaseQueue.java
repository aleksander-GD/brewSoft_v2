package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.QueueObject;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;
import java.util.Queue;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Mathias
 */
public class DatabaseQueue {
    Queue<QueueObject> queue;
    DatabaseConnection con;
    
    public DatabaseQueue() {
        this.con = new DatabaseConnection();
        this.queue = new LinkedList();
    }
    
    public int addToQueue(String fn, String sql, Object... values) {
        QueueObject qo = new QueueObject(fn, sql, values);
        queue.add(qo);
        for (QueueObject queueObject : queue) {
            //System.out.println(queueObject);
        }   
        this.saveToFile(queue);
        return queue.size();
    }

    private void saveToFile(Queue<QueueObject> queueList) {
        FileOutputStream f = null;
        try {
            f = new FileOutputStream(new File("queue.txt"));
            ObjectOutputStream o = new ObjectOutputStream(f);
            for (QueueObject qo : queueList) {
                o.writeObject(qo);
            }
            o.close();
            f.close();
        } catch (FileNotFoundException ex) {
            Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            try {
                f.close();
            } catch (IOException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    public void runQueue() {
        try {
            FileInputStream fi = new FileInputStream(new File("queue.txt"));
            ObjectInputStream oi = new ObjectInputStream(fi);
            boolean notEOF = true;
            Queue<QueueObject> fileQueue = new LinkedList();
            while(notEOF) {
                if(fi.available() != 0) {
                    fileQueue.add((QueueObject) oi.readObject());
                } else {
                    notEOF = false;
                }
            }
            Queue<QueueObject> deleteQueue = new LinkedList();
            for (QueueObject queueObject : fileQueue) {
                try {
                    String sql = queueObject.getSql();
                    Method m = con.getClass().getDeclaredMethod(queueObject.getFunction(), String.class, Object[].class);
                    m.invoke(con, sql, queueObject.getValues());
                    System.out.println("sql: " + sql);
                    deleteQueue.add(queueObject);
                } catch(NoSuchMethodException ex) {
                    System.out.println("METHOD NOT FOUND");
                } catch (IllegalAccessException ex) {
                    Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
                    System.out.println("ILLEGAL ACCESS?");
                } catch (IllegalArgumentException ex) {
                    Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
                    System.out.println("ILLEGAL ARGUMENT?");
                } catch (InvocationTargetException ex) {
                    Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
            fileQueue.removeAll(deleteQueue);
            this.saveToFile(fileQueue);
        } catch (FileNotFoundException ex) {
            Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
        }
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
            System.out.println("SECURITY VIOLATED?");
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
