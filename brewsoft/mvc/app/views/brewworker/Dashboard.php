<!DOCTYPE html>
<html>
  <head>
    <title>Brewery Worker Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/brewsoft/mvc/public/css/brewdashboard.css">
    <script type='text/javascript' src="#"></script>
    <html lang="en">
  </head>

  <body>
    
    <div class="control-buttons">
      <button>Start</button>
      <button>Reset</button>
      <button>Clear</button>
      <button>Stop</button>
      <button>Abort</button>
    </div>
    
    <br>
    <div class="production-materials">
      <div class="barley" id="barley">
        <lable>Barley:</lable>
        <br>
        <input type="text" id="barley" name="barley" readonly>
      </div>
      <div class="hops" id="hops">
        <lable>Hops:</lable>
        <br>
        <input type="text" id="hops" name="hops" readonly>
      </div>
      <div class="malt" id="malt">
        <lable>Malt:</lable>
        <br>
        <input type="text" id="malt" name="malt" readonly>
      </div>
      <div class="wheat" id="wheat">
        <lable>Wheat:</lable>
        <br>
        <input type="text" id="wheat" name="wheat" readonly>
      </div>
      <div class="yeast" id="yeast">
        <lable>Yeast:</lable>
        <br>
        <input type="text" id="yeast" name="yeast" readonly>
      </div>
    </div>
    
    <br>
    <div>
      <div class="">
        <div class="product-type">
          <label>Product Type:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="batch-id">
          <label>Batch ID:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="to-be-produced">
          <label>To be produced:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="produced">
          <label>Produced:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="acceptable-products">
          <label>Acceptable products:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="defect-products">
          <label>Defect products:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
      </div>
      
      <br>
      <div class="">
        <div class="products-per-minut">
          <lable>Products per minut:</lable>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="temperature">
          <label>Temperature:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="humidity">
          <label>Humidity:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="vibration">
          <label>Vibration:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
      </div>
      
      <br>
      <div>
        <div class="stop-reason">
          <label>Stop Reason:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="maintenance-status">
          <label>Maintenance status:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
        <div class="state">
          <label>State:</label>
          <br>
          <input type="text" id="barley" name="barley" readonly>
        </div>
      </div>
    </div>
  </body>
</html>