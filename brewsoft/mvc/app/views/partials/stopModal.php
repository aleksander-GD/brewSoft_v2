<!-- The Modal -->
  <div class="modal" id="manualStopReason">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Manual $("#machineID").val()</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form id="formStopReason" action="/brewsoft/mvc/public/machineApi/saveStopReason" method="post">
            <div><label for="stopReason">Enter reason for stopping production:</label></div>
            <div><textarea name="stopReason" id="stopReason" placeholder="Stop reason"></textarea></div>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="saveStopReason();">Close</button>
        </div>

      </div>
    </div>
  </div>
  <script>
    //$(document).ready(function(){$('#manualStopReason').modal('show')})
    
    function saveStopReason() {
      url = $("#formStopReason").attr('action');
      var posting = $.post(url, {stopReason: $('#stopReason').val(), machineID: $("#machineID").val()});
      posting.done(function(data) { console.log(data); });
    }
  </script>
