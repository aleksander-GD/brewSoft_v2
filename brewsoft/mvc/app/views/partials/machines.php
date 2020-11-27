
<?php

if(empty($viewbag["error"]["databaseconnection"])) {
?>
  <select class="form-control" name='machineSelect' id='machineSelect' onchange='fillHiddenForm();' data-toggle="tooltip" data-container="body" data-html="true" data-title="Yellow background:<br>Machine is running.<br>Blue background:<br>Machine is idle." data-trigger="hover" data-placement="top">
    <?php
    $machine = 0;
    if (isset($_POST["machineID"])) {
      $machine = $_POST["machineID"] - 1;
    }
    $i = 1;
    $options = "";
    foreach ($viewbag["availableMachines"] as $key => $value) {
      $class = "bg-primary";
      if($value['running']) {
        $class = "bg-warning";
      }
    ?>
      <option class="<?php echo $class; ?>" value='<?php echo json_encode($value) ?>' <?php if (isset($_POST["machineID"]) && $_POST["machineID"] == $i) {
                                                          echo "selected";
                                                        } ?>>machine <?php echo $value['brewerymachineid'] ?></option>
    <?php
      $i++;
    }
    ?>
  </select>
  <input type="hidden" name="hostname" id="hostname" value="<?php echo $viewbag["availableMachines"][$machine]['hostname']; ?>">
  <input type="hidden" name="port" id="port" value="<?php echo $viewbag["availableMachines"][$machine]['port']; ?>">
  <input type="hidden" name="machineID" id="machineID" value="<?php echo $viewbag["availableMachines"][$machine]['brewerymachineid']; ?>">
<?php
} ?>
