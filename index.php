<!DOCTYPE html>
<html>
    <head></head>
    <body><?php
        include "pgAccess.php";
        $conn = new pgAccess;
        $conn -> host_name = "localhost";
        $conn -> user_name = "postgres";
        $conn -> password = "postgres";
        $conn -> dn_name = "applicationSystem";
        echo $conn -> connect()."\n";
        // $conn -> issue_query();
        // while($row = $conn -> fetch_row())
        //     echo $row[0]."\n";
        $conn -> disconnect();
    ?></body>
</html>