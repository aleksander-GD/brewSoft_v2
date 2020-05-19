function fillHiddenForm() {
  var select = $("#machineSelect").val();//.value;
  console.log(select);
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
    console.log(command)

    // Shows the spinner on button
    $('#'+command+'-spn').toggleClass('d-none');

    var form = $(this);
    var url = "/brewsoft/mvc/public/machineapi/"+command;

    console.log(form.serialize());
    console.log(url);
    $.ajax({
      type: 'post',
      url: url,
      data: form.serialize()
    })
    .done(function (data) {
      console.log(data);
      json = JSON.parse(data);
      if(json.hasOwnProperty("success")){
        console.log(json.success.API)
        txt = document.createTextNode(json.success.API);
        if(command == "Start") {
          startProduction(json.machineID, json.productionListID);
        }
        if(command == "Stop") {
          stopProduction();
        }
      }
      if(json.hasOwnProperty("error")) {
        console.log(json.error.API)
        txt = document.createTextNode(json.error.API);
      }
      $("#output-response").empty();
      $("#output-response").append(txt);
      $("#responseModal").modal("show");
      // Hides the spinner on button
      $('#'+command+'-spn').toggleClass('d-none');
    })
    .fail(function (data) {
        console.log(data);
    });
  });
});
