<!DOCTYPE html>
<html lang="en">

<head>
  <title>Machine Control</title>
  <?php include_once '../app/views/partials/head.php'; ?>
  <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/brewdashboard.css">
  <script type="text/javascript" src="<?php echo DOC_ROOT; ?>/js/machineApi.js"></script>
</head>

<body>

  <?php include_once '../app/views/partials/menu.php'; ?>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <?php
//      if (!empty($viewbag["method"])) {
//        if ($viewbag["method"] === "abort" || $viewbag["method"] === "stop") {
          include '../app/views/partials/stopModal.php';
//        }
//      }
      include '../app/views/partials/responseModal.php';
      ?>
      <div class="col-md-6">
        <form name="controlForm" id="controlForm" action="" method="post" onsubmit="return false;">
          <div class="form-row">
            <div class="form-group col-auto">
              <?php
              if (!empty($viewbag["availableMachines"])) {
                include '../app/views/partials/machines.php';
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
                    echo "<button  class='btn btn-secondary' type='submit' form='controlForm' onclick='changeCommand(this);' value='$value'><span id='".$value."-spn' class='spinner-border spinner-border-sm d-none'></span> $value</button>";
                  }
                } else {
                  if (!empty($viewbag["Error"])) {
                    foreach ($viewbag["Error"] as $key => $value) {
                      echo "<p class='p-2 bg-warning'>".$value."</p>";
                    }
                  }

                }
                ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include '../app/views/partials/foot.php'; ?>
