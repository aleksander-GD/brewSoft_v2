// Consider using jQuery for element selection
// Consider rewrite to POST?
function updateIngredients() {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getIngredients&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);
      var inventoryMax = 30000;
      var b = ((inventoryMax-response.barley)/inventoryMax)*100;
      var h = ((inventoryMax-response.hops)/inventoryMax)*100;
      var m = ((inventoryMax-response.malt)/inventoryMax)*100;
      var w = ((inventoryMax-response.wheat)/inventoryMax)*100;
      var y = ((inventoryMax-response.yeast)/inventoryMax)*100;

      document.querySelector("#barley-update").value = response.barley;
      document.querySelector("#barley-statusbar").style.height = b;
      document.querySelector("#hops-update").value = response.hops;
      document.querySelector("#hops-statusbar").style.height = h;
      document.querySelector("#malt-update").value = response.malt;
      document.querySelector("#malt-statusbar").style.height = m;
      document.querySelector("#wheat-update").value = response.wheat;
      document.querySelector("#wheat-statusbar").style.height = w;
      document.querySelector("#yeast-update").value = response.yeast;
      document.querySelector("#yeast-statusbar").style.height = y;
    }
  });
}

function updateProductionData(machineId, productionListID) {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getProductionData&machineId="+machineID+"&productionListID="+productionlistID,
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);

      document.querySelector("#product-type-update").value = response.productType;
      document.querySelector("#batch-id-update").value = response.batchID;
      document.querySelector("#to-be-produced-update").value = response.toBeProduced;
      document.querySelector("#products-per-minut-update").value = response.productsPerMinut;
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
console.log(data)
      var response = JSON.parse(data);

      document.querySelector("#produced-update").value = response.produced;
      document.querySelector("#acceptable-products-update").value = response.acceptableCount;
      document.querySelector("#defect-products-update").value = response.defectCount;
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
      var m = ((maintenanceFull-response.maintenance)/maintenanceFull)*100;
      document.querySelector("#temperature-update").value = response.temperature;
      document.querySelector("#humidity-update").value = response.humidity;
      document.querySelector("#vibration-update").value = response.vibration;
      document.querySelector("#stop-reason-update").value = response.stopReason;
      document.querySelector("#maintenance-status-update").value = m;// response.maintenance;
      document.querySelector("#maintenance-statusbar").style.width = m;
      document.querySelector("#state-update").value = response.state;
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
  console.log(machineID, productionlistID);
  updateProductionData();
  updateIngredientsInterval = setInterval(updateIngredients, 1000);
  updateProducedDataInterval = setInterval(updateproducedData, 1000);
  updateMachineDataInterval = setInterval(updateMachineData, 1000);
}

function stopProduction()
{
  clearInterval(updateIngredientsInterval);
  clearInterval(updateProducedDataInterval);
  clearInterval(updateMachineDataInterval);
}
