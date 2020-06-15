<?php
    $userid = $_GET["userid"];
    $role = $_GET["role"];
    $result = null;
//    echo $userid . PHP_EOL . $role;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Console</title>
    <style type="text/css">
        .center {
            text-align: center;
            color: #de86dc;
        }
    </style>
    <script type="text/javascript">
        let role = "<?php echo $role; ?>";
        let userid = "<?php echo $userid; ?>";
        window.onload = function () {
            if (role == "Teacher") {
                document.getElementById("checkInBtn").innerHTML = "Generate Code"
                document.getElementById("codeForm").style.display = "none";
            } else {
                document.getElementById("showBtn").style.display = "none";
                document.getElementById("dismiss").style.display = "none";
            }
        }
        function checkIn() {
            if (role == "Teacher") {
                window.open("/php_proj/Console/GenerateCode.php?userid=" + userid + "&for=generate");
            } else {
                if (document.getElementById("code").value == "") {
                    alert("Code must not be empty!")
                    return;
                }
                let code = document.getElementById("code").value;
                let teacher = document.getElementById("teacher").value;
                window.open("/php_proj/Console/CheckInPage.php?userid=" + userid + "&code=" + code + "&teacher=" + teacher);
            }
        }
        function showHistory() {
            window.open("/php_proj/Console/ShowHistoryPage.php?userid=" + userid);
        }
        function dismiss() {
            window.open("/php_proj/Console/GenerateCode.php?userid=" + userid + "&for=dismiss");
        }
    </script>
</head>
<body>
<div style="text-align: center; line-height: 10px">
    <h1 class="center">Console</h1>
    <br>
    <a href="../Checkin/CheckInPage.html">Quit</a>
</div>
<hr>
<div style="text-align: center; line-height: 50px">
    <br>
    <form name="codeForm" action="" method="post" id="codeForm">
        <label for="teacher">Teacher: </label> <input type="text" id="teacher" name="teacher">
        <br>
        <label for="code">Code: </label> <input type="text" id="code" name="code">
    </form>
    <br>
    <button type="button" id="showBtn" onclick="showHistory()">Show CheckIn History</button>
    <br> <br>
    <button type="button" id="checkInBtn" onclick="checkIn()">CheckIn</button>
    <br> <br>
    <button type="button" id="dismiss" onclick="dismiss()">Dismiss Class</button>
</div>
</body>
</html>