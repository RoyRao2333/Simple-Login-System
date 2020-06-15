<?php
    require_once "../Database/Database.php";

    $db = Database::init();
    $userid = $_GET["userid"];
    $for = $_GET["for"];
    switch ($for) {
        case "generate":
            $nums = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $length = 6;
            $keys = array_rand($nums, $length);
            $code = "";
            for ($i = 0; $i < $length; $i++) {
                $code .= $nums[$keys[$i]];
            }
            $result = $db->updateCode($userid, $code);
            if ($result) {
                echo "<script>alert(\"Code is {$code}\"); window.close()</script>";
            } else {
                echo "<script>alert(\"Error\"); window.close()</script>";
            }
            break;
        case "dismiss":
            $result = $db->updateCode($userid, "");
            if ($result) {
                echo "<script>alert(\"Class is over!\"); window.close()</script>";
            } else {
                echo "<script>alert(\"Error\"); window.close()</script>";
            }
            break;
        default:
            break;
    }
