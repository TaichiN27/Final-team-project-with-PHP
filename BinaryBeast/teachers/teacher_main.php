<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//call teacher's first name
$sql_cmd = "SELECT fname FROM `users_tb` WHERE user_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($sql_cmd);
while ($row = $result->fetch_assoc()) {
    $teachername = $row['fname'];
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
    <div class="title">Teacher(<?php echo $teachername ?>)'s dashboard</div>
    <!------------------ course list ------------------------>
    <div class="sub_title">< My Courses ></div>
    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Minimum capacity</th>
            <th>Maximum capacity</th>
        </tr>
        <?php
        $sql_cmd = "SELECT * FROM `course_tb` WHERE teacher_id='" . $_SESSION['userid'] . "'";
        $result = $dbcon->query($sql_cmd);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['min_cap'] . "</td><td>" . $row['max_cap'] . "</td></tr>";
        }
        ?>
    </table>

    <!------------------ students list ------------------------>
    <div class="sub_title">< My Students ></div>
    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Student Id</th>
            <th>Student name</th>
        </tr>
        <?php
        $sql_cmd = "SELECT * FROM `enroll_tb` WHERE teacher_id='" . $_SESSION['userid'] . "'";
        $result = $dbcon->query($sql_cmd);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['student_id'] . "</td><td>" . $row['student_fname'] . "</td></tr>";
        }
        ?>
    </table>

    <!------------------ mark,comment list ------------------------>
    <div class="sub_title">< Marks & Comments ></div>
    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Student Id</th>
            <th>Mark</th>
            <th>Comment</th>
        </tr>
        <?php
        $sql_cmd = "SELECT * FROM `marks_tb` WHERE teacher_id='" . $_SESSION['userid'] . "'";
        $result = $dbcon->query($sql_cmd);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['student_id'] . "</td><td>" . $row['mark'] . "</td><td>" . $row['comment'] . "</td></tr>";
        }
        $dbcon->close();
        ?>
    </table>

</body>
</html>