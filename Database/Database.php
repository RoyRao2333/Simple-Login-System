<?php

class Database {
    private static $instance;

    var $servername = "127.0.0.1";
    var $username = "root";
    var $password = "11111111";
    var $dbname = "sign_in";
    var $port = "7777";
    var $connect;

    private function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connect = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        if ($this->connect->connect_error) {
            die("Database connection failed: " . $this->connect->connect_error);
        }
    }

    public function __destruct() {
        $this->connect->close();
    }

    public static function init() {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function __clone() {
        trigger_error("Clone is not allowed.", E_USER_NOTICE);
    }

    public function checkIn($name, $code, $teacher) {
        $sql = "SELECT * FROM teacher_info WHERE (UserID=\"{$teacher}\" AND Code=\"{$code}\")";
        $result = $this->connect->query($sql);
        if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
            $stmt = $this->connect->prepare("INSERT INTO checkIn_info (UserID, Teacher, Date) VALUES (?, ?, ?)");
            date_default_timezone_set("prc");
            $varDate = date("y-m-d h:i:s", time());
            $stmt->bind_param("sss", $name, $teacher, $varDate);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    public function login($table, $userid, $pw) {
        $sql = "SELECT * FROM " . $table . " WHERE (UserID=\"{$userid}\" AND Password=\"{$pw}\")";
        $result = $this->connect->query($sql);
        if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
            return true;
        } else {
            return false;
        }
    }

    public function append($table, $name, $pw) {
        $stmt = $this->connect->prepare("INSERT INTO " . $table . " (UserID, Password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $pw);
        $stmt->execute();
        $stmt->close();
    }

    public function delete($table, $name) {
        $sql = "DELETE FROM " . $table . " WHERE UserID=" . "\"" . $name . "\"";
        $result = $this->connect->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function query($table, $name) {
        $sql = "SELECT * FROM " . $table . " WHERE UserID=" . "\"" . $name . "\"";
        $result = $this->connect->query($sql);
        if ($result) {
            $array = $result->fetch_array(MYSQLI_ASSOC);
            if (empty($array)) {
                echo "0 result";
                return null;
            }
            return $array;
        }
        return false;
    }

    public function updateCode($userid, $code) {
        $sql = "UPDATE teacher_info SET Code= \"{$code}\" WHERE UserID=\"{$userid}\"";
        $result = $this->connect->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function createTable($tableName) {
        if (!$this->connect) {
            die("SQL Connection Failed: " . $this->connect->connect_error);
        }
        $sql = "CREATE TABLE " . $tableName . " (UserID varchar(255), Date varchar(255))";
        $result = $this->connect->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkTableIsExist($tableToFind) {
        $sql = "SHOW TABLES;";
        $result = $this->connect->query($sql);
        if ($result) {
            $tables = $result->fetch_array(MYSQLI_ASSOC);
            if (!$tables) {
                return false;
            }
            if (in_array($tableToFind, $tables)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function printAll($teacherName) {
        $result = $this->connect->query("SELECT * FROM checkIn_info WHERE Teacher=\"{$teacherName}\"");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "UserID: " . $row["UserID"] . ", " . "Date: " . $row["Date"] . "<br>";
            }
        } else {
            echo "0 results.";
        }
    }

}

class TableEnum {
    public static $student = "student_info";
    public static $teacher = "teacher_info";
    public static $chechIn = "checkIn_info";
}
