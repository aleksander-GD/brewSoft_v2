  <div class="container-fluid">
    <div class="row">
      <div class="barley col-sm col-lg-1" id="barley">
        <lable for="barley-update">Barley:</lable>
        <input type="text" id="barley-update" name="barley" class="form-control-plaintext" readonly>
        <div class="progress">
          <div id="barley-statusbar" class="progress-bar bg-success" style="width:50%"></div>
        </div>
      </div>
      <div class="hops col-sm col-lg-1" id="hops">
        <lable>Hops:</lable>

        <input type="text" id="hops-update" name="hops" class="form-control-plaintext" readonly>
        <div class="progress">
          <div id="hops-statusbar" class="progress-bar bg-success" style="width:50%"></div>
        </div>
      </div>
      <div class="malt col-sm col-lg-1" id="malt">
        <lable>Malt:</lable>

        <input type="text" id="malt-update" name="malt" class="form-control-plaintext" readonly>
        <div class="progress">
          <div id="malt-statusbar" class="progress-bar bg-success" style="width:50%"></div>
        </div>
      </div>
      <div class="wheat col-sm col-lg-1" id="wheat">
        <lable>Wheat:</lable>

        <input type="text" id="wheat-update" name="wheat" class="form-control-plaintext" readonly>
        <div class="progress">
          <div id="wheat-statusbar" class="progress-bar bg-success" style="width:50%"></div>
        </div>
      </div>
      <div class="yeast col-sm col-lg-1" id="yeast">
        <lable>Yeast:</lable>

        <input type="text" id="yeast-update" name="yeast" class="form-control-plaintext" readonly>
        <div class="progress">
          <div id="yeast-statusbar" class="progress-bar bg-success" style="width:50%"></div>
        </div>
      </div>
      <div class=" col-sm col-lg-7"></div>
    </div>
  </div>
<div class="container-fluid">
  <div class="row">
    <div class="batch_info col-sm col-md-3 col-lg-3 col-xl-2">
      <div class="batch-id">
        <label>Batch ID:</label>

        <input type="text" id="batch-id-update" name="batchID" class="form-control-plaintext" readonly>
      </div>
      <div class="product-type">
        <label>Product Type:</label>

        <input type="text" id="product-type-update" name="productType" class="form-control-plaintext" readonly>
      </div>
      <div class="products-per-minut">
        <lable>Products per minut:</lable>

        <input type="text" id="products-per-minut-update" name="productsPerMinut" class="form-control-plaintext" readonly>
      </div>
      <div class="to-be-produced">
        <label>To be produced:</label>

        <input type="text" id="to-be-produced-update" name="toBeProduced" class="form-control-plaintext" readonly>
      </div>
    </div>

    <div class="col-sm col-md-9 col-lg-9 col-xl-9">
      <div class="producing_info row">
        <div class="produced col col-md-3 col-lg-3 col-xl-3">
          <label for="produced-update">Produced:</label>
          <input type="text" id="produced-update" name="produced" class="form-control-plaintext" readonly>
        </div>
        <div class="acceptable-products col col-md-3 col-lg-3 col-xl-3">
          <label>Acceptable products:</label>

          <input type="text" id="acceptable-products-update" name="acceptableProducts" class="form-control-plaintext" readonly>
        </div>
        <div class="defect-products col col-md-3 col-lg-3 col-xl-3">
          <label>Defect products:</label>

          <input type="text" id="defect-products-update" name="defectProducts" class="form-control-plaintext" readonly>
        </div>
        <div class="defect-products col col-md-3 col-lg-3 col-xl-3"></div>
      </div>

      <div class="machine_sensor_info row">
        <div class="temperature col col-md-3 col-lg-3 col-xl-3">
          <label>Temperature:</label>

          <input type="text" id="temperature-update" name="temperature" class="form-control-plaintext" readonly>
        </div>
        <div class="humidity col col-md-3 col-lg-3 col-xl-3">
          <label>Humidity:</label>
          <input type="text" id="humidity-update" name="humidity" class="form-control-plaintext" readonly>
        </div>
        <div class="vibration col col-md-3 col-lg-3 col-xl-3">
          <label>Vibration:</label>
          <input type="text" id="vibration-update" name="vibration" class="form-control-plaintext" readonly>
        </div>
      </div>

      <div class="machine_info row">
        <div class="stop-reason col col-md-3 col-lg-3 col-xl-3">
          <label>Stop Reason:</label>

          <input type="text" id="stop-reason-update" name="stopReason" class="form-control-plaintext" readonly>
        </div>
        <div class="maintenance-status col col-md-3 col-lg-3 col-xl-3">
          <label>Maintenance status:</label>

          <input type="text" id="maintenance-status-update" name="maintenanceStatus" class="form-control-plaintext" readonly>
          <div class="progress">
            <div id="maintenance-statusbar" class="progress-bar bg-danger" style="width:50%"></div>
          </div>
        </div>
        <div class="state col col-md-3 col-lg-3 col-xl-3">
          <label>State:</label>

          <input type="text" id="state-update" name="state" class="form-control-plaintext" readonly>
        </div>
      </div>
    </div>

</div>

    <script type='text/javascript' src="<?php echo DOC_ROOT; ?>/js/brewdashboard.js"></script>
