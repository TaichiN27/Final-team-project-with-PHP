<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//make teachers list
$teachers = '';
$select_cmd = "SELECT * FROM `users_tb` WHERE user_type = 'teacher'";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers .= "<option value='" . $row['user_id'] . "'>" . $row['fname'] . "</option>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $select_cmd = "SELECT * FROM `users_tb` WHERE user_id = '" . $_POST['teacher'] . "'";
    $result = $dbcon->query($select_cmd);
    $row = $result->fetch_assoc();
    $teachername = $row['fname'];
    $insert_cmd = "insert into course_tb values('', '" . $_POST['course_name'] . "', '" . $_POST['mincap'] . "', '" . $_POST['maxcap'] . "', '" . $_POST['teacher'] . "', '$teachername', '" . $_POST['fee'] . "')";
    if ($dbcon->query($insert_cmd) === true) {
        echo "<div class='title' style='color:blue;'>Registered</div>";
    } else {
        echo "<div class='title' style='color:red;'>Not registered</div>";
    }
    $dbcon->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BINARY BEAST</title>
</head>

<body>
    <div class="title">Add New Course</div>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addr=course_register'; ?>">
        Course name: <input type="text" name="course_name" required>
        Min capacity: <input type="number" name="mincap" required>
        Max capacity: <input type="number" name="maxcap" required>
        Teacher: <select name="teacher">
            <?php echo $teachers; ?>
        </select>
        Fee: <input type="text" name="fee" required>
        <div class="radioDiv">
            <button type="submit">Register</button>
        </div>
    </form>


</body>

</html>