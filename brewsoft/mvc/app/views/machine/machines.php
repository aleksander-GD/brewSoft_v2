<select name='machineSelect' id='machineSelect' onchange='fillHiddenForm();'>
<?php
  $machine = 0;
  if (isset($_POST["machineID"])) {
    $machine = $_POST["machineID"]-1  ;
  }
  $i=1;
  $options = "";
  foreach ($viewbag["availableMachines"] as $key => $value) {
?>
  <option value='<?php echo json_encode($value) ?>' <?php if (isset($_POST["machineID"]) && $_POST["machineID"] == $i) {echo "selected";} ?>>machine <?php echo $value['brewerymachineid'] ?></option>
<?php
    $i++;
  }
//  echo "<select name='machineSelect' id='machineSelect' onchange='fillHiddenForm();'>{$options}</select>";
?>
</select>
  <input type="hidden" name="hostname" id="hostname" value="<?php echo $viewbag["availableMachines"][$machine]['hostname']; ?>">
  <input type="hidden" name="port" id="port" value="<?php echo $viewbag["availableMachines"][$machine]['port']; ?>">
  <input type="hidden" name="machineID" id="machineID" value="<?php echo $viewbag["availableMachines"][$machine]['brewerymachineid']; ?>">
<!--

<p>Available machines:</p>

<form id="machineform">
    <select id="machines" name="machinelist" form="machineform">
        <?php
        if (count($viewbag["availableMachines"]) != 0) {
            for ($i = 0; $i < count($viewbag["availableMachines"]); $i++) {
                ?>
                <option value="<?php echo $i ?>"<?php if (isset($_GET["machinelist"]) && $_GET["machinelist"] == $i) {echo "selected";} ?>>Machine <?php echo $i+1 ?></option>
                <?php
            }
        } else {
            ?>
            <option value="error">No available machines</option>
            <?php
        }
        ?>
    </select>
    <input type="submit" class="item" value="Choose">
</form>
    <br><br>
    <?php
    if (isset($_GET["machinelist"])) {
        ?>
        <form action="/brewsoft/mvc/public/machineapi/chooseMachine" method="POST">
            <label for="machineID">Machine ID:</label>
            <input type="text" id="machineID" name="machineID" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["brewerymachineid"];
            } ?>" readonly><br><br>
            <label for="hostname">Hostname:</label>
            <input type="text" id="hostname" name="hostname" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["hostname"];
            } ?>" readonly><br><br>
            <label for="port">Port:</label>
            <input type="text" id="port" name="port" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["port"];
            } ?>" readonly><br><br>

            <input type="submit" class="item" value="Confirm">
        </form>
        <?php
    }
    ?>
-->
