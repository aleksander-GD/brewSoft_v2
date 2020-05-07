package com.BrewSoft.MachineControllerAPI.crossCutting.objects;

import java.io.Serializable;

public class QueueObject implements Serializable {
    private String sql;
    private String function;
    private Object[] values;
    
    public QueueObject(String function, String sql, Object... values) {
        this.function = function;
        this.sql = sql;
        this.values = values;
    }

    public String getSql() {
        return sql;
    }

    public void setSql(String sql) {
        this.sql = sql;
    }

    public String getFunction() {
        return function;
    }

    public void setFunction(String function) {
        this.function = function;
    }

    public Object[] getValues() {
        return values;
    }

    public void setValues(Object[] values) {
        this.values = values;
    }

//    @Override
//    public String toString() {
//        return "QueueObject{\n" + "sql=" + sql + "\nfunction=" + function + "\nvalues=" + values.toString() + "\n}";
//    }
    
    
}
