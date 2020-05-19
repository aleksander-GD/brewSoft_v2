<div class="container-fluid">
  <div class="row">
    <div class="col-md-10">

      <div class="row justify-content-center">
        <div class="barley col-2 col-sm-2 col-lg-1 inventory" id="barley">
          <span for="barley-update">Barley:</span>
          <input type="text" id="barley-update" name="barley" class="form-control-plaintext" readonly>
          <div class="progress progress-bar-vertical">
            <div id="barley-statusbar" class="progress-bar bg-success" style="height: 100%"></div>
          </div>
        </div>
        <div class="hops col-2 col-sm-2 col-lg-1 inventory" id="hops">
          <span>Hops:</span>
          <input type="text" id="hops-update" name="hops" class="form-control-plaintext" readonly>
          <div class="progress progress-bar-vertical">
            <div id="hops-statusbar" class="progress-bar bg-success" style="height: 100%"></div>
          </div>
        </div>
        <div class="malt col-2 col-sm-2 col-lg-1 inventory" id="malt">
          <span>Malt:</span>
          <input type="text" id="malt-update" name="malt" class="form-control-plaintext" readonly>
          <div class="progress progress-bar-vertical">
            <div id="malt-statusbar" class="progress-bar bg-success" style="height: 100%"></div>
          </div>
        </div>
        <div class="wheat col-2 col-sm-2 col-lg-1 inventory" id="wheat">
          <span>Wheat:</span>
          <input type="text" id="wheat-update" name="wheat" class="form-control-plaintext" readonly>
          <div class="progress progress-bar-vertical">
            <div id="wheat-statusbar" class="progress-bar bg-success" style="height: 100%"></div>
          </div>
        </div>
        <div class="yeast col-2 col-sm-2 col-lg-1 inventory" id="yeast">
          <span>Yeast:</span>
          <input type="text" id="yeast-update" name="yeast" class="form-control-plaintext" readonly>
          <div class="progress progress-bar-vertical">
            <div id="yeast-statusbar" class="progress-bar bg-success" style="height: 100%"></div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">

        <div class="batch_info col-sm col-md-3 col-lg-3 col-xl-2">
          <div class="batch-id">
            <span>Batch ID:</span>
            <input type="text" id="batch-id-update" name="batchID" class="form-control-plaintext" readonly>
          </div>
          <div class="product-type">
            <span>Product Type:</span>
            <input type="text" id="product-type-update" name="productType" class="form-control-plaintext" readonly>
          </div>
          <div class="products-per-minut">
            <span>Products per minut:</span>
            <input type="text" id="products-per-minut-update" name="productsPerMinut" class="form-control-plaintext" readonly>
          </div>
          <div class="to-be-produced">
            <span>To be produced:</span>
            <input type="text" id="to-be-produced-update" name="toBeProduced" class="form-control-plaintext" readonly>
          </div>
        </div>

        <div class="col-sm col-md-7 col-lg-7 col-xl-6">
          <div class="producing_info row">
            <div class="produced col col-md-4">
              <label for="produced-update">Produced:</label>
              <input type="text" id="produced-update" name="produced" class="form-control-plaintext" readonly>
            </div>
            <div class="acceptable-products col col-md-4">
              <span>Acceptable products:</span>
              <input type="text" id="acceptable-products-update" name="acceptableProducts" class="form-control-plaintext" readonly>
            </div>
            <div class="defect-products col col-md-4">
              <span>Defect products:</span>
              <input type="text" id="defect-products-update" name="defectProducts" class="form-control-plaintext" readonly>
            </div>
          </div>

          <div class="machine_sensor_info row">
            <div class="temperature col col-md-4">
              <span>Temperature:</span>
              <input type="text" id="temperature-update" name="temperature" class="form-control-plaintext" readonly>
            </div>
            <div class="humidity col col-md-4">
              <span>Humidity:</span>
              <input type="text" id="humidity-update" name="humidity" class="form-control-plaintext" readonly>
            </div>
            <div class="vibration col col-md-4">
              <span>Vibration:</span>
              <input type="text" id="vibration-update" name="vibration" class="form-control-plaintext" readonly>
            </div>
          </div>

          <div class="machine_info row">
            <div class="stop-reason col col-md-4">
              <span>Stop Reason:</span>
              <input type="text" id="stop-reason-update" name="stopReason" class="form-control-plaintext" readonly>
            </div>
            <div class="state col col-md-4">
              <span>State:</span>
              <input type="text" id="state-update" name="state" class="form-control-plaintext" readonly>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="maintenance-status col col-md-2 ">
      <span>Maintenance status:</span>
      <input type="text" id="maintenance-status-update" name="maintenanceStatus" class="form-control-plaintext" readonly>
      <div class="progress progress-bar-vertical">
        <div id="maintenance-statusbar" class="progress-bar bg-danger" style="height: 0%"></div>
      </div>
    </div>
  </div>
</div>

    <script type='text/javascript' src="<?php echo DOC_ROOT; ?>/js/brewdashboard.js"></script>
