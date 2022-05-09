<?php
/*if (!isset($_SESSION['AdminLoginId'])) {
    header("location: index.php");
}*/
$output_dir =  "../client/public/assets/images";/* Path for file upload */
if (!file_exists($output_dir)) {
    @mkdir($output_dir, 0777);
}
$RandomNum   = time();
$ImageType = $_FILES['image']['type'];
$ImageName = $_FILES["image"]["name"];
if(isset($ImageName)){


    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
    $ImageExt       = str_replace('.', '', $ImageExt);
    if ($ImageName[0] != '')
        $NewImageName = $RandomNum . '.' . $ImageExt;
    else
        $NewImageName = '';
    $title = $NewImageName;
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $output_dir . "/" . $NewImageName))
    {
        echo "<script>console.log('added !')</script>";
    }
}else
    $NewImageName = '';