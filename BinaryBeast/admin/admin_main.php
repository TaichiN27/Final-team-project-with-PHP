<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//call admin's first name
$sql_cmd = "SELECT fname FROM `users_tb` WHERE user_id='" . $_SESSION['userid'] . "'";
$result = $dbcon->query($sql_cmd);
while ($row = $result->fetch_assoc()) {
    $adminname = $row['fname'];
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
<div class="title">Admin(<?php echo $adminname ?>)'s dashboard</div>

<!------------------ user list ------------------------>
<div class="sub_title">< Users ></div>
    <table>
        <tr>
            <th>User Id</th>
            <th>User name</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Date of birth</th>
            <th>address</th>
            <th>position</th>
            <th>user type</th>
        </tr>
        <?php
        $sql_cmd = "SELECT * FROM `users_tb` ";
        $result = $dbcon->query($sql_cmd);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['user_id'] . "</td><td>" . $row['email'] . "</td><td>" . $row['fname'] . "</td><td>" . $row['lname'] . "</td><td>" . $row['dob'] . "</td><td>" . $row['address'] . "</td><td>" . $row['position'] . "</td><td>" . $row['user_type'] . "</td></tr>";
        }
        ?>
    </table>

    <!------------------ course list ------------------------>
    <div class="sub_title">< Courses ></div>
    <table>
        <tr>
            <th>Course Id</th>
            <th>Course name</th>
            <th>Min cap</th>
            <th>Max cap</th>
            <th>Course fee</th>
        </tr>
        <?php
        $sql_cmd = "SELECT * FROM `course_tb` ";
        $result = $dbcon->query($sql_cmd);
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['course_id'] . "</td><td>" . $row['course_name'] . "</td><td>" . $row['min_cap'] . "</td><td>" . $row['max_cap'] . "</td><td>$" . $row['course_fee'] . "</td></tr>";
        }
        $dbcon->close();
        ?>
    </table>
</body>

</html>