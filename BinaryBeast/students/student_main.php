<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//call student's first name
$sql_cmd = "SELECT fname FROM `users_tb` WHERE user_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($sql_cmd);
while ($row = $result->fetch_assoc()) {
    $studentname = $row['fname'];
}

$sql_cmd = "SELECT * FROM `enroll_tb` WHERE student_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($sql_cmd);
$trtd = "";
$totalfee = 0;
$sum = 0;
$avg=0;
while ($row = $result->fetch_assoc()) {
    $trtd .= "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['teacher_id'] . "</td><td>" . $row['teacher_fname'] . "</td><td>$" . $row['course_fee'] . "</td></tr>";
    $totalfee += $row['course_fee'];
}

$courses = array();
//select information matching student id
$sql_cmd = "SELECT * FROM `marks_tb` WHERE student_id='" . $_SESSION['userid'] . "' ";
$result = $dbcon->query($sql_cmd);
$trtd2 = "";
if($result->num_rows>0){
    while ($row = $result->fetch_assoc()) {
        $trtd2 .= "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['mark'] . "</td><td>" . $row['comment'] . "</td></tr>";
        array_push($courses, $row['mark']);
    }
    //sum all marks values
    foreach ($courses as $marks) {
        $sum += $marks;
    }
    //divide by count(the number of courses) = average mark
    $avg = number_format($sum / count($courses), 2);
}

$dbcon->close();
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
    <div class="title">Student(<?php echo $studentname ?>)'s dashboard</div>

    <!------------------ user list ------------------------>
    <div class="sub_title">
        < Your Courses>
    </div>
    <div class="sub_title" style="font-style:italic; color: blue;">Your overall fee: $<?php echo $totalfee ?></div>
    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Teacher Id</th>
            <th>Teacher name</th>
            <th>Course fee</th>
        </tr>
        <?php
        echo $trtd;
        ?>
    </table>

    <!------------------ students list ------------------------>
    <div class="sub_title">
        < My Marks>
    </div>
    <div class="sub_title" style="font-style:italic; color: blue;">Your average mark: <?php if(isset($avg)){echo $avg;} ?></div>

    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Mark</th>
            <th>Comment</th>
        </tr>
        <?php
        echo $trtd2;
        ?>
    </table>
</body>

</html>