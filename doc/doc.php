<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $cams = $_POST['cams'];
        if(isset($cams)){
            include "DBAccess\pgApplicationSystemAccess.php";
            $conn = new pgApplicationSystemAccess;
            $conn -> connect();
            $query = "SELECT simple_address FROM application_system.yard_camcorders WHERE id IN (";
            for($i = 0; $i < count($cams) - 1; $i++)
                $query .= "?, ";
            $query .= "?) UNION SELECT simple_address FROM application_system.entrance_camcorders WHERE id IN (";
            for($i = 0; $i < count($cams) - 1; $i++)
                $query .= "?, ";
            $query .= "?);";
            $mcams = array_merge($cams, $cams);
            $conn -> issue_query($query, $mcams);
        }
        include "signature.php";
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="onexit.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <title>Документ</title>
</head>

<body>
    <header>Начальнику городской<br>системы видеонаблюдения<br>г. Москвы<br>от <?php
    if(isset($_POST['name']))
        $name = $_POST['name'];
    if(strlen($name) > 23){
        $nameParts = explode(' ', $name);
        $name = $nameParts[0];
        for($i = 1; $i < count($nameParts); $i++){
            if(strlen($name.$nameParts[$i]) <= 40)
                $name .= ' '.$nameParts[$i];
            else{
                while($i < count($nameParts)){
                    $secName .= $nameParts[$i].' ';
                    $i++;
                }
                break;
            }
        }
    }
    echo $name.'<br>'.$secName;
    ?></header>

    <h1>Заявление</h1>
    <main><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Прошу продлить хранение видеозаписей с камер городского видеонаблюдения, установленных по адресам 
        <?php
        if(isset($cams)){
            while($row = $conn -> fetch_array()){
                echo $row[0]."; ";
            }
        }?>
        <br>за период с <?php
        $dateTime = $_POST['dateFrom'];
        echo substr($dateTime, 11).' '.substr($dateTime, 8, 2).'.'.substr($dateTime, 5, 2).'.'.substr($dateTime, 0, 4).'г. '.' по ';
        $dateTime = $_POST['dateTo'];
        echo substr($dateTime, 11).' '.substr($dateTime, 8, 2).'.'.substr($dateTime, 5, 2).'.'.substr($dateTime, 0, 4).'г. ';?></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данная информация нужна в связи с тем, что 
            <?php echo $_POST['reason'];?>
        </p>

        <div class="signature"><span class="date">Дата <?=date('d.m.Y').' г.'?></span>
        <span class="img_name" name="<?=$target_file?>">Подпись <?php
        if($_FILES["signature"]['error'] != 4)
            echo '<img src="'.$target_file.'" data-src="'.$target_file.'">';
        if($fileError != '')
            echo $fileError;
        ?></span></div>
    </main><?php if(isset($cams)){$conn -> disconnect();}?>
</body>
</html>