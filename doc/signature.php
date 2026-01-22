<?php
$target_file = "userdata/".basename($_FILES["signature"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$fileError = '';

if($_FILES["signature"]['error'] != 4){
    $check = @getimagesize($_FILES["signature"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $fileError = "Файл не является изображением.";
        $uploadOk = 0;
    }


    if ($uploadOk != 0) {
        if (!move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
            $fileError = 'Ошибка загрузки файла';
            $uploadOk = 0;
        }
    }
}?>