var oldClass = "";
function fillHiddenForm() {
  if(oldClass != "" && oldClass != $("#machineSelect :selected").attr('class')) {
    $("#machineSelect").removeClass(oldClass);
  }
  oldClass = $("#machineSelect :selected").attr('class');
  $("#machineSelect").addClass(oldClass);
  /*$("#machineSelect").toggleClass(function() {
    console.log($("#machineSelect :selected").attr('class'));
    if($(this).hasClass($("#machineSelect :selected").attr('class'))) {
      return "";
    } else {
      return $("#machineSelect :selected").attr('class');
    }

  });*/
  var select = $("#machineSelect");
  var json = JSON.parse(select.val());
  $("#hostname").val(json.hostname);
  $("#port").val(json.port);
  $("#machineID").val(json.brewerymachineid);
}

function changeCommand(button) {
  input = $('#command');
  input.val(button.value);
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(function() {
  $("#viewForm").submit(function(e) {
    e.preventDefault();

    var command = $('#command').val();

    // Shows the spinner on button
    $('#'+command+'-spn').toggleClass('d-none');

    var form = $(this);
    var machineID = $("#machineID").val();
    var url = "/brewsoft/mvc/app/services/ProductionDataService.php?method=productionListInProduction&machineId="+machineID

    $("#output-response").empty();

    $.ajax({
      type: 'get',
      url: url,
      data: form.serialize()
    })
    .done(function(data) {
      console.log(data)
      json = JSON.parse(data);
      console.log(json)
      if(json.hasOwnProperty("Error")) {
        txt = document.createTextNode(json.Error);
        console.log(json.Error);
        stopProduction();
        $("#output-response").append(txt);
        $("#responseModal").modal("show");
      } else {
        if(command == "view") {
          startProduction(machineID, json.productionlistid);
          txt = document.createTextNode("Monitoring machine: " + machineID);
          $("#output-response").append(txt);
          $("#responseModal").modal("show");
        } else {
          stopProduction();
          txt = document.createTextNode("Stopped monitoring machine: " + machineID);
          $("#output-response").append(txt);
          $("#responseModal").modal("show");
        }
      }
      $('#'+command+'-spn').toggleClass('d-none');
    })
    .fail(function(data) {
      console.log(data);
      // Show some error message
      $('#view-spn').toggleClass('d-none');
    })
  });
});
$(document).ready(fillHiddenForm);
