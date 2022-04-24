<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="loginStyles.css" />
    <title>BINARY BEAST</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <p>Welcome to Binary Beast!</p>
        <div class="inputRow">
            <label for="user"> Username: </label>
            <input type="text" name="username" id="user" placeholder="Enter your username" required/>
        </div>
        <div class="inputRow">
            <label for="pass"> Password: </label>
            <input type="password" name="pass" id="pass" placeholder="Enter your password" required/>
        </div>
        <button type="submit">Enter</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'education';
        $loginuser = $_POST['username'];
        $loginpassword = $_POST['pass'];
        $dbcon = new mysqli($servername, $username, $password, $database);
        if ($dbcon->connect_error) {
            die("Connection Error: " . $dbcon->connect_errno);
        }
        //check the email(username)
        $select_cmd = "SELECT salt FROM `users_tb` WHERE email='" . $loginuser . "'";
        $result = $dbcon->query($select_cmd);
        //check the password
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $salt = $row['salt'];
            }
            $tmppass = md5($loginpassword . $salt);
            $select_cmd = "SELECT * FROM `users_tb` WHERE email='" . $loginuser . "' AND password='" . $tmppass . "'";
            $result = $dbcon->query($select_cmd);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //check the user type -> go to user's index page, save user_id into session
                    if ($row['user_type'] == 'admin') {
                        $_SESSION['userid'] = $row['user_id'];
                        header("Location: ./admin/admin_index.php");
                        exit();
                    } elseif ($row['user_type'] == 'student') {
                        $_SESSION['userid'] = $row['user_id'];
                        header("Location: ./students/student_index.php");
                        exit();
                    } elseif ($row['user_type'] == 'teacher') {
                        $_SESSION['userid'] = $row['user_id'];
                        header("Location: ./teachers/teacher_index.php");
                        exit();
                    }
                }
            } else {
                echo "<h1>Wrong username / password</h1>";
            }
        }else{
            echo "<h1>Wrong username / password</h1>";
        }
        $dbcon->close();
    }
    ?>
</body>

</html>