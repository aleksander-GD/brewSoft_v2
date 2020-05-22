<!DOCTYPE html>
<html>

<head>
    <title> Manager Dashboard </title>
    <?php include_once '../app/views/partials/head.php'; ?>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/brewdashboard.css">
    <script type="text/javascript" src="<?php echo DOC_ROOT; ?>/js/managerDashboard.js"></script>
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
      <?php include '../app/views/partials/responseModal.php'; ?>
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <form name="viewForm" id="viewForm" action="" method="post" onsubmit="return false;">
              <div class="form-row">
                <div class="form-group col-auto">
                  <?php
                  if (!empty($viewbag["availableMachines"])) {
                    include '../app/views/partials/machines.php';
                  }
                  ?>
                </div>
                <div class="form-group col-auto">
                  <input type="hidden" value="view" name="command" id="command">
                  <div class="btn-group">
                    <button class='btn btn-secondary' type='submit' form='viewForm' onclick='changeCommand(this);' value='view'><span id='view-spn' class='spinner-border spinner-border-sm d-none'></span> View machine</button>
                    <button class='btn btn-secondary' type='submit' form='viewForm' onclick='changeCommand(this);' value='stop'><span id='stop-spn' class='spinner-border spinner-border-sm d-none'></span> Stop view</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>
    <?php endif; ?>
