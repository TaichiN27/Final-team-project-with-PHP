<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//to use student's first name
$select_cmd = "SELECT fname FROM `users_tb` WHERE user_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $studentname = $row['fname'];
    }
}
//to make course option list
$course_option = '';
$select_cmd = "SELECT * FROM `course_tb`";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_option .= "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . " (teahcer : " . $row['teacher_fname'] . ")</option>";
    }
}

//when register button click
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //check if the student already registered that course
    $cmd = " SELECT * FROM `enroll_tb` WHERE student_id= '" . $_SESSION['userid'] . "' AND course_id='" . $_POST['courseid'] . "'";
    $result2 = $dbcon->query($cmd);
    if ($result2->num_rows > 0) {
        echo "<div class='title' style='color:red;'>You already enrolled the course</div>";
    } else {
        //from course table, get teacher and course information
        $select_cmd = "SELECT * FROM `course_tb` WHERE course_id='" . $_POST['courseid'] . "'";
        $result = $dbcon->query($select_cmd);
        while ($row = $result->fetch_assoc()) {
            $teacherid = $row['teacher_id'];
            $teachername = $row['teacher_fname'];
            $coursename = $row['course_name'];
            $coursefee = $row['course_fee'];
        }
        //insert new information
        $insert_cmd = "insert into enroll_tb values('" . $_SESSION['userid'] . "', '" . $teacherid . "', '" . $_POST['courseid'] . "', '$teachername', '$studentname', '$coursename', '$coursefee')";
        if ($dbcon->query($insert_cmd) === true) {
            echo "<div class='title' style='color:blue;'>Registered</div>";
        } else {
            echo "<div class='title' style='color:red;'>Error happened</div>";
        }
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
    <title>User Register</title>
</head>

<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addr=enrollment'; ?>">
        Course name: <select name="courseid">
            <?php echo $course_option; ?>
        </select>
        <div class="radioDiv">
            <button type="submit">Register</button>
        </div>
    </form>

    
</body>

</html>