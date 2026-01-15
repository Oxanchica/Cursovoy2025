<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "pgApplicationSystemAccess.php";
        $conn = new pgApplicationSystemAccess;
        $conn -> connect();
        $conn -> issue_query("SELECT id, simple_address FROM application_system.camcorders WHERE simple_address LIKE ?", ["%".$_GET["address"]."%"]);
    ?>
    <title>Система формирования заявлений на продление хранения данных с камер</title>
    <link rel="stylesheet" href="indexStyle.css">
    <script src="onclick.js" defer></script>
</head>
<body>
    <header><h1>Система формирования заявлений на продление хранения данных с камер</h1></header>

    <main>
        <form enctype="application/x-www-form-urlencoded" method="get" action="index.php">
            <input name="address" type="text" placeholder="Поиск" <?php
                if(isset($_GET['address']))
                    echo 'value="'.$_GET['address'].'"';
            ?>>
            <input type="submit" value="Найти">
        </form>

        <form enctype="application/x-www-form-urlencoded" method="get" action="doc.php" class="view">
            <input type="submit" value="Посмотреть документ">
        </form>

        <table data-href="doc.php">
            <tr><th>Адрес камеры</th><th></th></tr>
            <?php
            while($row = $conn -> fetch_array()){
                echo '<tr><td>'.$row[1].'</td><td><button data-value="'.$row[0];
                echo '">Добавить</button>';
                echo '</td></tr>';
            }?>
        </table>
    </main>

    <footer>Приложение разработано на основе 
        <a href=https://data.mos.ru/opendata/1498?pageSize=10&pageIndex=0&version=3&release=84>набора открытых данных</a></footer>
</body>
</html>