
<?php
if (!empty($viewbag["error"])) {
  echo "Error: ";
  foreach ($viewbag["error"] as $key => $value) {
    echo "<span>" . $value . "</span>";
  }
} else {
?>
  <select class="form-control" name='machineSelect' id='machineSelect' onchange='fillHiddenForm();'>
    <?php
    $machine = 0;
    if (isset($_POST["machineID"])) {
      $machine = $_POST["machineID"] - 1;
    }
    $i = 1;
    $options = "";
    foreach ($viewbag["availableMachines"] as $key => $value) {
    ?>
      <option value='<?php echo json_encode($value) ?>' <?php if (isset($_POST["machineID"]) && $_POST["machineID"] == $i) {
                                                          echo "selected";
                                                        } ?>>machine <?php echo $value['brewerymachineid'] ?></option>
    <?php
      $i++;
    }
    //  echo "<select name='machineSelect' id='machineSelect' onchange='fillHiddenForm();'>{$options}</select>";
    ?>
  </select>
  <input type="hidden" name="hostname" id="hostname" value="<?php echo $viewbag["availableMachines"][$machine]['hostname']; ?>">
  <input type="hidden" name="port" id="port" value="<?php echo $viewbag["availableMachines"][$machine]['port']; ?>">
  <input type="hidden" name="machineID" id="machineID" value="<?php echo $viewbag["availableMachines"][$machine]['brewerymachineid']; ?>">
<?php
} ?>