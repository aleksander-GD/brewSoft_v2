function fillHiddenForm() {
  var select = document.querySelector("#machineSelect").value;
  console.log(select);
  var json = JSON.parse(select);
  document.querySelector("#hostname").value = json.hostname;
  document.querySelector("#port").value = json.port;
  document.querySelector("#machineID").value = json.brewerymachineid;
}

function changeCommand(button) {
  input = document.querySelector('#command');
  input.value = button.value;
}
$(function() {
  $("#controlForm").submit(function(e) {
    e.preventDefault();

    var command = document.querySelector('#command').value;

    var form = $(this);
    var url = "/brewsoft/mvc/public/machineapi/"+command;
    if(command == "Start") {
      startProduction();
    }
    if(command == "Stop") {
      stopProduction();
    }
    console.log(form.serialize());
    $.ajax({
      type: 'post',
      url: url,
      data: form.serialize()
    })
    .done(function (data) {
      console.log(data);
    })
    .fail(function (data) {
        console.log(data);
    });
  });
});
