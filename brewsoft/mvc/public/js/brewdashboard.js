function updateIngredients() {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getIngredients",
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);

      console.log(response);
      
      document.getElementById("barley-update").value = response.barley;
      document.getElementById("hops-update").value = response.hops;
      document.getElementById("malt-update").value = response.malt;
      document.getElementById("wheat-update").value = response.wheat;
      document.getElementById("yeast-update").value = response.yeast;
    }
  });
}

function updateProductionData() {
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getProductionData",
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);

      console.log(response);
      
      document.getElementById("product-type-update").value = response.productType;
      document.getElementById("batch-id-update").value = response.batchID;
      document.getElementById("to-be-produced-update").value = response.toBeProduced;
      document.getElementById("products-per-minut-update").value = response.productsPerMinut;
    }
  });
}

function updateproducedData()
{
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getProducedData",
    datatype: "json",
    async: true,
    success: function(data){

      var response = JSON.parse(data);

      console.log(response);
      
      document.getElementById("produced-update").value = response.produced;
      document.getElementById("acceptable-products-update").value = response.acceptableCount;
      document.getElementById("defect-products-update").value = response.defectCount;
    }
  });
}

function updateMachineData()
{
  $.ajax({
    type: "GET",
    url: "/brewsoft/mvc/app/services/ProductionDataService.php?method=getMachineData",
    datatype: "json",
    async: true,
    success: function(data){

      console.log(data);

      var response = JSON.parse(data);

      console.log(response);
      
      document.getElementById("temperature-update").value = response.temperature;
      document.getElementById("humidity-update").value = response.humidity;
      document.getElementById("vibration-update").value = response.vibration;
      document.getElementById("stop-reason-update").value = response.stopReason;
      document.getElementById("maintenance-status-update").value = response.maintenance;
      document.getElementById("state-update").value = response.state;
    }
  });
}

var updateIngredientsInterval;
var updateProducedDataInterval;
var updateMachineDataInterval;

function startProduction()
{
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