<?php
function generaterandomcode()
{
    return rand();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'education';
    $dbcon = new mysqli($servername, $username, $password, $database);
    if ($dbcon->connect_error) {
        die("Connection Error: " . $dbcon->connect_errno);
    }
    $sql_cmd = "SELECT * FROM `users_tb` WHERE user_id='" . $_POST['user_id'] . "'";
    $result = $dbcon->query($sql_cmd);
    $cmd2 = "SELECT * FROM `users_tb` WHERE email='" . $_POST['email'] . "'";
    $result2 = $dbcon->query($cmd2);
    if ($result->num_rows > 0) {
        echo "<div class='title' style='color:red;'>The user id exists already</div>";
    } elseif ($result2->num_rows > 0) {
        echo "<div class='title' style='color:red;'>The user name(email) exists already</div>";
    } else {
        $salt = generaterandomcode();
        $insert = $dbcon->prepare("INSERT INTO users_tb VALUES(?,?,?,?,?,?,?,?,?,?)");
        $tmppass = md5($_POST['pass'] . $salt);
        $insert->bind_param('isssssssss', $_POST['user_id'], $_POST['email'], $tmppass, $_POST['fname'], $_POST['lname'], $_POST['birth'], $_POST['addr'],  $_POST['position'], $salt, $_POST['user_type']);
        $insert->execute();
        echo "<div class='title' style='color:blue;'>Registered</div>";
        $insert->close();
        $dbcon->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexStyles.css" />
    <title>BINARY BEAST</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .title {
            margin-top: 2em;
            font-size: 40px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="title">Add New User</div>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addr=user_register'; ?>">
        User Id: <input type="text" name="user_id" required>
        User name(email): <input type="email" name="email" required>
        password: <input type="password" name="pass" required>
        First name: <input type="text" name="fname" required>
        Last name: <input type="text" name="lname" required>
        Date of Birth: <input type="date" name="birth" required>
        Address: <input type="text" name="addr" required>
        Position: <input type="text" name="position" required>
        User type:<select name="user_type">
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
        <div class="radioDiv">
            <button type="submit">Register</button>
        </div>
    </form>


</body>

</html>