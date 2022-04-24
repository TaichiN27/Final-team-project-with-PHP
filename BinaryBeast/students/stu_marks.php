<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//to make array(value:marks)
$courses = array();
//select information matching student id
$sql_cmd = "SELECT * FROM `marks_tb` WHERE student_id='" . $_SESSION['userid'] . "' ";
$result = $dbcon->query($sql_cmd);
//to make table
$trtd = '';
$sum=0;
$avg=0;
if($result->num_rows>0){
    while ($row = $result->fetch_assoc()) {
        $trtd .= "<tr><td>" . $row['course_name'] . "</td><td>" . $row['mark'] . "</td><td>" . $row['comment'] . "</td></tr>";
        array_push($courses, $row['mark']);
    }
    $sum = 0;
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
    <title>Document</title>
</head>

<body>
<div class="title">Your Marks & Comments</div>
    <div class="sub_title">Overall grade: <?php echo $avg; ?></div>
    <table>
        <tr>
            <th>Course Name</th>
            <th>Mark</th>
            <th>Comment</th>
        </tr>
        <?php echo $trtd; ?>
    </table>
</body>

</html>