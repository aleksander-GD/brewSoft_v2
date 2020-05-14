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
