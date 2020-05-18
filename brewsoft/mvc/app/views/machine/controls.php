<!DOCTYPE html>
<html lang="en">

<head>
  <title>Machine Control</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/brewdashboard.css">
  <script type="text/javascript" src="<?php echo DOC_ROOT; ?>/js/machineApi.js"></script>
</head>

<body>

  <?php include_once '../app/views/partials/menu.php'; ?>
  <pre>
<?php //var_dump($viewbag);
?>
</pre>
  <div class="container-fluid">
    <div class="col-xl-12 col-sm-12 response">
      <?php
      if (!empty($viewbag["error"])) {
        echo "Error: ";
        foreach ($viewbag["error"] as $key => $value) {
          echo "<div>" . $value . "</div>";
        }
      }
      ?>
      <?php
      if (!empty($viewbag["success"])) {
        echo "Success: ";
        foreach ($viewbag["success"] as $key => $value) {
          echo "<span>" . $value . "</span>";
        }
      }
      ?>
    </div>
    <?php
    if (!empty($viewbag["method"])) {
      if ($viewbag["method"] === "abort" || $viewbag["method"] === "stop") {
        include '../app/views/partials/stopModal.php';
      }
    }
    ?>
    <div class="col-xl-12 col-sm-12">
      <!-- Overvej AJAX til knapperne, især hvis dashboard skal sættes ind som partial eller omvendt -->
      <form name="controlForm" id="controlForm" action="" method="post" onsubmit="return false;">
        <div class="form-row">
          <div class="form-group col-auto">
            <?php
            if (!empty($viewbag["availableMachines"])) {
              include '../app/views/machine/machines.php';
            }
            ?>
          </div>
          <div class="form-group col-auto">
            <input type="hidden" value="Reset" name="command" id="command">
            <div class="btn-group">
              <?php
              $commands = "";
              if (!empty($viewbag["controls"])) {
                foreach ($viewbag["controls"]->commands as $key => $value) {
                  echo "<button  class='btn btn-secondary' type='submit' form='controlForm' onclick='changeCommand(this);' value='$value'>$value</button>";
                }
              }

              ?>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php include '../app/views/partials/foot.php'; ?>
