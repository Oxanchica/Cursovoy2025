<!DOCTYPE html>
<html>
    <head>
    <?php
        include "pgApplicationSystemAccess.php";
        $conn = new pgApplicationSystemAccess;
        echo $conn -> connect()."\n";
        // $conn -> issue_query();
        // while($row = $conn -> fetch_array())
        //     echo $row[0]."\n";
    ?></head>
    <body></body>
</html>