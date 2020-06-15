<?php
    require_once "../Database/Database.php";

    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $db = Database::init();
    switch ($role) {
        case "Student":
            if ($db->login(TableEnum::$student, $userid, $password)) {
                echo "<script>alert(\" Welcome, {$userid}!\"); window.location.href = \"/php_proj/Console/ConsolePage.php?userid={$userid}&role={$role}\"</script>";
            } else {
                echo "<script>alert(\"Incorrect UserID or Password. \"); window.location.href = \"/php_proj/CheckIn/CheckInPage.html\"</script>";
            }
            break;
        case "Teacher":
            if ($db->login(TableEnum::$teacher, $userid, $password)) {
                echo "<script>alert(\" Welcome, {$userid}!\"); window.location.href = \"/php_proj/Console/ConsolePage.php?userid={$userid}&role={$role}\"</script>";
            } else {
                echo "<script>alert(\"User not found. Proceed to SignUp.\"); window.location.href = \"/php_proj/CheckIn/CheckInPage.html\"</script>>";
            }
            break;
        default:
            break;
    }