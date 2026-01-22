<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        include "doc\DBAccess\pgApplicationSystemAccess.php";
        $conn = new pgApplicationSystemAccess;
        $conn -> connect();
        $conn -> issue_query("SELECT id, simple_address FROM application_system.yard_camcorders WHERE simple_address LIKE ? UNION SELECT id, simple_address FROM application_system.entrance_camcorders WHERE simple_address LIKE ?", ["%".$_GET["address"]."%", "%".$_GET["address"]."%"]);
    ?>
    <title>Система формирования заявлений на продление хранения данных с камер</title>
    <link rel="stylesheet" href="indexStyle.css">
    <script src="onclick.js" defer></script>
</head>
<body>
    <header><h1>Система формирования заявлений на продление хранения данных с камер</h1></header>

    <main>
        <form enctype="application/x-www-form-urlencoded" method="get" action="index.php" class="searchForm">
            <input class="searchField" name="address" type="text" placeholder="Поиск камер" <?php
                if(isset($_GET['address']))
                    echo 'value="'.$_GET['address'].'"';
            ?>>
            <input type="submit" value="Найти" class="searchButton">
        </form>

        <form enctype="multipart/form-data" method="post" action="doc\doc.php" class="view">
            <p>Для сохранения документа откройте его и нажмите Ctrl+S или шёлкните по нему правой кнопкой мыши и выберите нужный вариант.</p>
            <input type="text" name="name" placeholder="ФИО" class="name"><br>
            <span>За период </span><label for="dateFrom"> c </label><input type="datetime-local" name="dateFrom" id="dateFrom">
            <label for="dateTo">по </label><input type="datetime-local" name="dateTo" id="dateTo"><br>
            <input type="textarea" name="reason" placeholder="Причина запроса информации" class="reason"><br>
            <label for="signature">Вы можете загрузить подпись:</label>
            <input type="file" name="signature" accept="image/*" value="Загрузить подпись" id="signature">
            <input type="submit" value="Посмотреть документ">
        </form>

        <table data-href="doc.php">
            <tr><th>Адреса камер</th><th></th><th></th></tr>
            <?php
            while($row = $conn -> fetch_array()){
                echo '<tr><td>'.$row[1].'</td><td><button class="add" data-value="'.$row[0];
                echo '">Добавить</button></td><td><button class="remove" data-value="'.$row[0].'">Убрать</button></td></tr>';
            }?>
        </table>
    </main>

    <footer>Приложение разработано на основе 
        <a href="https://data.mos.ru/opendata/1498?pageSize=10&pageIndex=0&version=3&release=84">набора</a> и 
    <a href="https://data.mos.ru/opendata/1500/passport?version=3&release=38">набора</a> открытых данных.
</footer>
</body>
</html>