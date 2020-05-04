var productionListID;

function updatebarley() {
  $.ajax({
    url: "/brewsoft/mvc/app/services/ProductionData.php?getBarley = " + productionListID,
    type: "GET",
    async: true,
    data: "productionListID",
    success: function (data) {
      console.log("data:" + data);
      return data;
    }
  });
}


function startProduction() {
  productionListID = 1;
}


document.getElementById("barley-update").value = setInterval(updatebarley, 1000);
document.getElementById("hops-update").value = 1;