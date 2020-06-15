<?php
    require_once "../Database/Database.php";

    $db = Database::init();
    $userid = $_GET["userid"];
    $db->printAll($userid);