<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}

//receive courseid from select_course page
$course = $_POST['courseid'];
$coursename ='';
//select coursename with course_id
$select_cmd = "SELECT * FROM `enroll_tb` WHERE course_id = '" . $course . "'";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coursename = $row['course_name'];
    }
}
//make students list(option value=student_id)
$student_option = '';
$select_cmd = "SELECT * FROM `enroll_tb` WHERE course_id = '" . $course . "' AND teacher_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_option .= "<option value='" . $row['student_id'] . "'>" . $row['student_fname'] . "</option>";
    }
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
    <div class="title">Add Mark & Comment</div>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addr=add_mark'; ?>">
        <input type="hidden" name="course_id" value="<?php echo $course; ?>">
        Course name: <input type="text" name="coursename" value="<?php echo $coursename; ?>">
        Student name: <select name="studentid">
            <?php echo $student_option; ?>
        </select>
        Mark: <input type="text" name="mark" required>
        Comment: <textarea name="comment"></textarea>
        <div class="radioDiv">
            <button type="submit">Register</button>
        </div>
    </form>

    <?php
    //when click the register button
    if (isset($_POST['course_id'])) {
        //check if the mark is already registered
        $sql_cmd = "SELECT * FROM `marks_tb` WHERE student_id='" . $_POST['studentid'] . "' AND teacher_id='" . $_SESSION['userid'] . "' AND course_id = '" . $_POST['course_id'] . "' ";
        $result = $dbcon->query($sql_cmd);
        if($result->num_rows>0){
            //if already registered, go back to select_course page and send get[already]=1
            header("Location: teacher_index.php?addr=select_course&already=1");
                exit();
        }else{
            $insert_cmd = "insert into marks_tb values('" . $_POST['studentid'] . "', '" . $_SESSION['userid'] . "', '" . $_POST['course_id'] . "', '" . $_POST['mark'] . "', '" . $_POST['comment'] . "', '" . $_POST['coursename'] . "')";
            if ($dbcon->query($insert_cmd) === true) {
                //if registered succesfully, go back to select_course page and send get[register]=1
                header("Location: teacher_index.php?addr=select_course&register=1");
                exit();
            } else {
                echo "Not registered" . $dbcon->error;
            }
        }
        $dbcon->close();
    }
    ?>
</body>

</html>