<?php 
    ob_start(); // Start the output buffer for the all the loaded files
?>
<?php
    $loader = ob_get_clean(); // Get the content of the output buffer
    $title = 'Homepage';

    ob_start(); // Start the output buffer for the content of the page
?>
<?php
    $content = ob_get_clean(); // Get the content of the output buffer

    ob_start(); // Start the output buffer for the scripts
?>
<?php
    $script = ob_get_clean(); // Get the content of the output buffer

    require_once('panel_layout.php');