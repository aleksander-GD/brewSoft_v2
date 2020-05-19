<?php

if(!empty($viewbag["error"])) {
    echo '<script>alert("Error: '.implode("\\n", $viewbag["error"]).'");</script>';
} else {
    //echo "viewbag empty";
}
?>