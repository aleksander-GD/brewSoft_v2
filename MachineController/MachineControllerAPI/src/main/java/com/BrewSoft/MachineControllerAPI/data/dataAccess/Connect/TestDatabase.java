package com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

public class TestDatabase extends DatabaseConnection {

    final private String url;
    final private String user;
    final private String password;
    private Connection con;

    public TestDatabase() {
        this.url = "jdbc:postgresql://localhost:5432/TestDatabase";
        this.user = "postgres";
        this.password = "secret";
    }

    private Connection connect() throws SQLException, ClassNotFoundException {
        return DriverManager.getConnection(url, user, password);

    }

    private PreparedStatement prepareStatement(String query, Object... values) throws SQLException, ClassNotFoundException {
        con = connect();
        PreparedStatement statement = con.prepareStatement(query);

        for (int i = 0; i < values.length; i++) {
            statement.setObject(i + 1, values[i]);
        }
        return statement;
    }

    public int queryUpdate(String query, Object... values) {
        int affectedRows = 0;
        try (PreparedStatement statement = prepareStatement(query, values)) {

            statement.executeUpdate();

        } catch (SQLException ex) {
            Logger.getLogger(TestDatabase.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(TestDatabase.class.getName()).log(Level.SEVERE, null, ex);
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
            Logger.getLogger(TestDatabase.class.getName()).log(Level.SEVERE, null, ex);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(TestDatabase.class.getName()).log(Level.SEVERE, null, ex);
        }
        finally{
            disconnect();
            return set;
        }
        
    }
    
    private void disconnect(){
        try {
            con.close();
        } catch (SQLException ex) {
            Logger.getLogger(TestDatabase.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
