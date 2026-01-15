<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $cams = $_GET['cams'];
        if(isset($cams)){
            include "pgApplicationSystemAccess.php";
            $conn = new pgApplicationSystemAccess;
            $conn -> connect();
            $query = "SELECT simple_address FROM application_system.camcorders WHERE id IN (";
            for($i = 0; $i < count($cams) - 1; $i++)
                $query .= "?, ";
            $query .= "?);";
            $conn -> issue_query($query, $cams);
        }
    ?>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header>Начальнику городской<br>системы видеонаблюдения<br>г. Москвы</header>
    <h1>Заявление</h1>
    <main><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Прошу продлить хранение видеозаписей с камер городского видеонаблюдения, установленных по адресам 
        <?php
        if(isset($cams)){
            while($row = $conn -> fetch_array()){
                echo $row[0]."; ";
            }
        }?>
        <br>за период<br></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Данная информация нужна в связи с<br><br><br></p>
    </main><?php if(isset($cams)){$conn -> disconnect();} ?>
</body>
</html>