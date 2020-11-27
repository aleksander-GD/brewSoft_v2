var oldClass = "";
function fillHiddenForm() {
  if(oldClass != "" && oldClass != $("#machineSelect :selected").attr('class')) {
    $("#machineSelect").removeClass(oldClass);
  }
  oldClass = $("#machineSelect :selected").attr('class');
  $("#machineSelect").addClass(oldClass);
  var select = $("#machineSelect").val();
  var json = JSON.parse(select);
  $("#hostname").val(json.hostname);
  $("#port").val(json.port);
  $("#machineID").val(json.brewerymachineid);
}

function changeCommand(button) {
  input = $('#command');
  input.val(button.value);
}

$(function() {
// Auto close response modal after 5sec
  $('.modal-auto-clear').on('shown.bs.modal', function () {
    $(this).delay(5000).fadeOut(200, function () {
      $(this).modal('hide');
    })
  })

  $("#controlForm").submit(function(e) {
    e.preventDefault();

    var command = $('#command').val();

    // Shows the spinner on button
    $('#'+command+'-spn').toggleClass('d-none');

    var form = $(this);
    var url = "/brewsoft/mvc/public/machineapi/"+command;

    $.ajax({
      type: 'post',
      url: url,
      data: form.serialize()
    })
    .done(function (data) {

      json = JSON.parse(data);

      $("#output-response").empty();
      $("#stopModalTitle").empty();
      $("#stopReason").val('');

      if(json.hasOwnProperty("Success")) {
        txt = document.createTextNode(json.Success[0]);
        $("#output-response").append(txt);
        if(command == "Start") {
          startProduction(json.machineID[0], json.productionListID[0]);
        }
        if(command == "Stop" || command == "Abort") {
          stopProduction();
          title = document.createTextNode("Manual " + command)
          $("#stopModalTitle").append(title);
          $('#manualStopReason').modal('show');
        } else {
          $("#responseModal").modal("show");
        }
      }
      if(json.hasOwnProperty("Error")) {
        txt = document.createTextNode(json.Error);
        $("#output-response").append(txt);
        $("#responseModal").modal("show");
      }

      // Hides the spinner on button
      $('#'+command+'-spn').toggleClass('d-none');
    })
    .fail(function (data) {
        console.log(data);
    });
  });
});
$(document).ready(fillHiddenForm);
