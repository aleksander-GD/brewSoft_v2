package com.BrewSoft.MachineControllerAPI.data.dataAccess;

import com.BrewSoft.MachineControllerAPI.crossCutting.objects.BeerTypes;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.DatabaseConnection;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.SimpleSet;
import com.BrewSoft.MachineControllerAPI.data.dataAccess.Connect.TestDatabase;
import com.BrewSoft.MachineControllerAPI.data.interfaces.IBatchDataHandler;
import java.util.ArrayList;
import java.util.List;

public class BatchDataHandler implements IBatchDataHandler {

    private DatabaseConnection dbConnection;

    public BatchDataHandler() {
        dbConnection = new DatabaseConnection();
    }

    public BatchDataHandler(TestDatabase testDatabase) {
        dbConnection = testDatabase;
    }

    @Override
    public List<BeerTypes> getBeerTypes() {
        List<BeerTypes> beerTypeList = new ArrayList<>();
        SimpleSet beerTypes = dbConnection.query("SELECT * FROM producttype");

        for (int i = 0; i < beerTypes.getRows(); i++) {
            beerTypeList.add(new BeerTypes(
                    (int) beerTypes.get(i, "productid"),
                    String.valueOf(beerTypes.get(i, "productname")),
                    Float.parseFloat(String.valueOf(beerTypes.get(i, "speed")))
            ));
        }
        return beerTypeList;
    }
}
