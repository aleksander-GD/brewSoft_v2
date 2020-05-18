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
import java.util.LinkedList;
import java.util.Queue;
import java.util.logging.Level;
import java.util.logging.Logger;

public class DatabaseQueue {

    private DatabaseConnection con;
    private boolean queueExist;
    private boolean queueRunning;
    private String filename;

    public DatabaseQueue() {
        this.con = new DatabaseConnection();
        this.queueExist = false;
        this.queueRunning = false;
        this.filename = "queue.txt";
    }

    public boolean isQueueExisting() {
        File f = new File(this.filename);
        if(f.isFile()) {
            queueExist = true;
        }
        return queueExist;
    }

    public boolean isRunningQueue() {
        return queueRunning;
    }
    
    public void addToQueue(String fn, String sql, Object... values) {
        QueueObject qo = new QueueObject(fn, sql, values);
        this.saveObjectToFile(qo);
        this.queueExist = true;
    }
 /**
  * PROBABLY NOT THE MOST EFFICIENT WAY OF DOING IT
  * @param queueObject 
  */
    private void saveObjectToFile(QueueObject queueObject) {
        Queue<QueueObject> fileQueue = readFile();
        fileQueue.add(queueObject);
        saveListToFile(fileQueue);
    }

    private void saveListToFile(Queue<QueueObject> queueList) {
        FileOutputStream f = null;
        ObjectOutputStream o = null;
        File fil = new File(this.filename);
        fil.delete();
        queueExist = false;
        if (!queueList.isEmpty()) {
            try {
                f = new FileOutputStream(fil);
                o = new ObjectOutputStream(f);
                for (QueueObject qo : queueList) {
                    o.writeObject(qo);
                }
                o.close();
                f.close();
                queueExist = true;
            } catch (FileNotFoundException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } finally {
                try {
                    if(f != null) {
                        f.close();
                    }
                    if(o != null) {
                        o.close();
                    }
                } catch (IOException ex) {
                    Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
    }

    private Queue readFile() {
        FileInputStream fi = null;
        Queue<QueueObject> fileQueue = new LinkedList();
        File fil = new File(this.filename);
        if(fil.exists()) {
            try {
                fi = new FileInputStream(fil);
                ObjectInputStream oi = new ObjectInputStream(fi);
                boolean notEOF = true;
                while (notEOF) {
                    QueueObject qo = null;
                    if (fi.available() != 0) {
                        qo = (QueueObject) oi.readObject();
                        fileQueue.add(qo);
                    } else {
                        notEOF = false;
                    }
                }
                oi.close();
                fi.close();

            } catch (FileNotFoundException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (ClassNotFoundException ex) {
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } finally {
                try {
                    fi.close();
                } catch (IOException ex) {
                    Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
        return fileQueue;
    }
    
    public void runQueue() {
        System.out.println("RUNNING QUEUE!");
        queueRunning = true;
        Queue<QueueObject> fileQueue = this.readFile();
        Queue<QueueObject> deleteQueue = new LinkedList();
        for (QueueObject queueObject : fileQueue) {
            try {
                Method m = con.getClass().getDeclaredMethod(queueObject.getFunction(), String.class, Object[].class);
                m.invoke(con, queueObject.getSql(), queueObject.getValues());
                deleteQueue.add(queueObject);
            } catch (NoSuchMethodException ex) {
                System.out.println("METHOD NOT FOUND");
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IllegalAccessException ex) {
                System.out.println("ILLEGAL ACCESS?");
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IllegalArgumentException ex) {
                System.out.println("ILLEGAL ARGUMENT?");
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            } catch (InvocationTargetException ex) {
                System.out.println("Invocation Target?");
                Logger.getLogger(DatabaseQueue.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        fileQueue.removeAll(deleteQueue);
        this.saveListToFile(fileQueue);
        queueRunning = false;
    }
}
