<?php
    require_once "../Database/Database.php";

    $db = Database::init();
    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    switch ($role) {
        case "Student":
            $result = $db->query(TableEnum::$student, $userid);
            if ($result) {
                echo "<script>alert(\"User Already Exists. Proceed To Login.\"); window.location.href = \"/php_proj/Checkin/CheckInPage.html\"</script>>";
            } else {
                $db->append(TableEnum::$student, $userid, $password);
                echo "<script>alert(\"Success! Now Login.\"); window.location.href = \"/php_proj/Checkin/CheckInPage.html\"</script>>";
            }
            break;
        case "Teacher":
            $result = $db->query(TableEnum::$teacher, $userid);
            if ($result) {
                echo "<script>alert(\"User Already Exists. Proceed To Login.\"); window.location.href = \"/php_proj/Checkin/CheckInPage.html\"</script>>";
            } else {
                $db->append(TableEnum::$teacher, $userid, $password);
                echo "<script>alert(\"Success! Now Login.\"); window.location.href = \"/php_proj/Checkin/CheckInPage.html\"</script>>";
            }
            break;
        default:
            break;
    }