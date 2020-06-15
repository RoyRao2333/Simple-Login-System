<?php
    require_once "../Database/Database.php";

    $db = Database::init();
    $userid = $_GET["userid"];
    $code = $_GET["code"];
    $teacher = $_GET["teacher"];
    $result = $db->checkIn($userid, $code, $teacher);
    if ($result) {
        echo "<script>alert(\"Check In Completed!\"); window.close();</script>";
    } else {
        echo "<script>alert(\"Code Is Invalid!\"); window.close();</script>";
    }
