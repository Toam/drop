<?php
$ds = DIRECTORY_SEPARATOR;
$uniqid = uniqid();
$storeFolder = '../up/'. $uniqid;

if (!empty($_FILES)) {
    mkdir($storeFolder, 0775);
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);
    echo $uniqid . $ds . $_FILES['file']['name'];
}
