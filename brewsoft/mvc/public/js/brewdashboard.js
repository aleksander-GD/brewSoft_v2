// Consider using jQuery for element selection
// Consider rewrite to POST?

function updateProductionData(machineId, productionListID) {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getProductionData&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);

      $("#product-type-update").val(response.productType);
      $("#batch-id-update").val(response.batchID);
      $("#to-be-produced-update").val(response.toBeProduced);
      $("#products-per-minut-update").val(response.productsPerMinut);
    }
  });
}

function updateIngredients() {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getIngredients&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);
      var inventoryMax = 36000;
      var b = 100 - (((inventoryMax-response.barley)/inventoryMax)*100);
      var h = 100 - (((inventoryMax-response.hops)/inventoryMax)*100);
      var m = 100 - (((inventoryMax-response.malt)/inventoryMax)*100);
      var w = 100 - (((inventoryMax-response.wheat)/inventoryMax)*100);
      var y = 100 - (((inventoryMax-response.yeast)/inventoryMax)*100);

      //$("#barley-update").value = b;
      $("#barley-statusbar").css("height", b+"%");
      //$("#hops-update").value = h;
      $("#hops-statusbar").css("height", h+"%");
      //$("#malt-update").value = m;
      $("#malt-statusbar").css("height", m+"%");
      //$("#wheat-update").value = w;
      $("#wheat-statusbar").css("height", w+"%");
      //$("#yeast-update").value = y;
      $("#yeast-statusbar").css("height", y+"%");
      updateIngredientsInterval = setTimeout(updateIngredients, 1000);
    }
  });
}

function updateproducedData()
{
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getProducedData&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){
console.log(data);
      var response = JSON.parse(data);

      $("#produced-update").val(response.produced);
      $("#acceptable-products-update").val(response.acceptableCount);
      $("#defect-products-update").val(response.defectCount);
      updateProducedDataInterval = setTimeout(updateproducedData, 1000);
    }
  });
}

function updateMachineData()
{
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getMachineData&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);
      var maintenanceFull = 30000;
      var m = 100 - (((maintenanceFull-response.maintenance)/maintenanceFull)*100);
      $("#temperature-update").val(response.temperature);
      $("#humidity-update").val(response.humidity);
      $("#vibration-update").val(response.vibration);
      $("#stop-reason-update").val(response.stopReason);
      //$("#maintenance-status-update").value = m;// response.maintenance;
      $("#maintenance-statusbar").css("height", m+"%");
      $("#state-update").val(response.state);
      updateMachineDataInterval = setTimeout(updateMachineData, 1000);
    }
  });
}

var updateIngredientsInterval;
var updateProducedDataInterval;
var updateMachineDataInterval;

var machineID;
var productionlistID;

function startProduction(machineId, productionListID)
{
  machineID = machineId
  productionlistID = productionListID;

  updateProductionData();
  //updateIngredientsInterval = setInterval(updateIngredients, 1000);
  /* CONSIDER USING 1 CALL FOR THESE 3 */
  updateIngredients();
  //updateProducedDataInterval = setInterval(updateproducedData, 1000);
  updateproducedData();
  //updateMachineDataInterval = setInterval(updateMachineData, 1000);
  updateMachineData();
}

function stopProduction()
{
  clearTimeout(updateIngredientsInterval);
  clearTimeout(updateProducedDataInterval);
  clearTimeout(updateMachineDataInterval);
  //clearInterval(updateIngredientsInterval);
  //clearInterval(updateProducedDataInterval);
  //clearInterval(updateMachineDataInterval);
}
