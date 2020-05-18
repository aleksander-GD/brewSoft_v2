<?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Worker' OR $_SESSION['usertype'] == 'Admin' ) ) : ?>
<!DOCTYPE html>
<html>

<head>
  <title>Brewery Worker Dashboard</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/brewsoft/mvc/public/css/brewdashboard.css">

</head>

<body>
  <?php include_once '../app/views/partials/menu.php'; ?>
  <!-- <div class="control-buttons">
    <button onclick="startProduction()">Start</button>
    <button>Reset</button>
    <button>Clear</button>
    <button onclick="stopProduction()">Stop</button>
    <button>Abort</button>
  </div> -->

  <br>
  <div class="production-materials">
    <div class="barley" id="barley">
      <lable>Barley:</lable>
      <br>
      <input type="text" id="barley-update" name="barley" readonly>
    </div>
    <div class="hops" id="hops">
      <lable>Hops:</lable>
      <br>
      <input type="text" id="hops-update" name="hops" readonly>
    </div>
    <div class="malt" id="malt">
      <lable>Malt:</lable>
      <br>
      <input type="text" id="malt-update" name="malt" readonly>
    </div>
    <div class="wheat" id="wheat">
      <lable>Wheat:</lable>
      <br>
      <input type="text" id="wheat-update" name="wheat" readonly>
    </div>
    <div class="yeast" id="yeast">
      <lable>Yeast:</lable>
      <br>
      <input type="text" id="yeast-update" name="yeast" readonly>
    </div>
  </div>

  <br>
  <div>
    <div class="">
      <div class="product-type">
        <label>Product Type:</label>
        <br>
        <input type="text" id="product-type-update" name="productType" readonly>
      </div>
      <div class="batch-id">
        <label>Batch ID:</label>
        <br>
        <input type="text" id="batch-id-update" name="batchID" readonly>
      </div>
      <div class="to-be-produced">
        <label>To be produced:</label>
        <br>
        <input type="text" id="to-be-produced-update" name="toBeProduced" readonly>
      </div>
      <div class="produced">
        <label>Produced:</label>
        <br>
        <input type="text" id="produced-update" name="produced" readonly>
      </div>
      <div class="acceptable-products">
        <label>Acceptable products:</label>
        <br>
        <input type="text" id="acceptable-products-update" name="acceptableProducts" readonly>
      </div>
      <div class="defect-products">
        <label>Defect products:</label>
        <br>
        <input type="text" id="defect-products-update" name="defectProducts" readonly>
      </div>
    </div>

    <br>
    <div class="">
      <div class="products-per-minut">
        <lable>Products per minut:</lable>
        <br>
        <input type="text" id="products-per-minut-update" name="productsPerMinut" readonly>
      </div>
      <div class="temperature">
        <label>Temperature:</label>
        <br>
        <input type="text" id="temperature-update" name="temperature" readonly>
      </div>
      <div class="humidity">
        <label>Humidity:</label>
        <br>
        <input type="text" id="humidity-update" name="humidity" readonly>
      </div>
      <div class="vibration">
        <label>Vibration:</label>
        <br>
        <input type="text" id="vibration-update" name="vibration" readonly>
      </div>
    </div>

    <br>
    <div>
      <div class="stop-reason">
        <label>Stop Reason:</label>
        <br>
        <input type="text" id="stop-reason-update" name="stopReason" readonly>
      </div>
      <div class="maintenance-status">
        <label>Maintenance status:</label>
        <br>
        <input type="text" id="maintenance-status-update" name="maintenanceStatus" readonly>
      </div>
      <div class="state">
        <label>State:</label>
        <br>
        <input type="text" id="state-update" name="state" readonly>
      </div>
    </div>
  </div>

  <script type='text/javascript' src="/brewsoft/mvc/public/js/brewdashboard.js"></script>

  <?php else : ?>
    <?php header('Location: /brewsoft/mvc/public/manager/planbatch'); ?>
<?php endif; ?>
  <?php include '../app/views/partials/foot.php'; ?>