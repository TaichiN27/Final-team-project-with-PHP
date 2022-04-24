<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//select all data from user_tb
$sql_cmd = "SELECT * FROM `users_tb` ";
$result = $dbcon->query($sql_cmd);
$trtd = '';
//show all information in a table. 
//when edit click, get userid=user_id
while ($row = $result->fetch_assoc()) {
    $trtd .= "<tr><td>" . $row['user_id'] . "</td><td>" . $row['email'] . "</td><td>" . $row['fname'] . "</td><td>" . $row['lname'] . "</td><td>" . $row['dob'] . "</td><td>" . $row['address'] . "</td><td>" . $row['position'] . "</td><td>" . $row['user_type'] . "</td><td><a href='" . $_SERVER['PHP_SELF'] . "?addr=edit_user&userid=" . $row['user_id'] . "'>Edit</a></td></tr>";
}
//edit form visibility
$disp = 'hidden';
//save user's info in a array
$info = array('id' => '', 'username' => '', 'fname' => '', 'lname' => '', 'dob' => '',  'addr' => '', 'position' => '', 'usertype' => '');
if (isset($_GET['userid'])) {
    $disp = 'visible';
    $sql_cmd = "SELECT * FROM users_tb WHERE user_id=" . $_GET['userid'] . "";
    $result = $dbcon->query($sql_cmd);
    $row = $result->fetch_assoc();
    $info['id'] = $row['user_id'];
    $info['username'] = $row['email'];
    $info['fname'] = $row['fname'];
    $info['lname'] = $row['lname'];
    $info['dob'] = $row['dob'];
    $info['addr'] = $row['address'];
    $info['position'] = $row['position'];
    $info['usertype'] = $row['user_type'];
}
//when user edit the information, update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_cmd = "UPDATE users_tb 
        SET user_id='" . $_POST['user_id'] . "',
        email='" . $_POST['email'] . "',
        fname='" . $_POST['fname'] . "',
        lname='" . $_POST['lname'] . "',
        dob='" . $_POST['birth'] . "',
        address='" . $_POST['addr'] . "',
        position='" . $_POST['position'] . "',
        user_type='" . $_POST['user_type'] . "' 
        WHERE user_id=" . $_POST['userid'] . " ";
    $result = $dbcon->query($sql_cmd);
    if ($result === false) {
        echo "<div class='title' style='color:red;'>Error happened</div>";
    } else {
        echo "<div class='title' style='color:blue;'>Edited</div>";
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
    <div class="title">Edit User</div>
    <!----------------------- user list ------------------------------>
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
            <th>Edit</th>
        </tr>
        <?php echo $trtd ?>
    </table>

    <!-------------------- edit form --------------------->
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?addr=edit_user' ?>" method="POST" style="visibility: <?php echo $disp ?>;">
        <h1>EDIT USER</h1>
        <input type="hidden" name="userid" value="<?= $_GET['userid'] ?>">
        User Id: <input type="text" name="user_id" value="<?= $info['id'] ?>">
        User name(email): <input type="email" name="email" value="<?= $info['username'] ?>">
        First name: <input type="text" name="fname" value="<?= $info['fname'] ?>">
        Last name: <input type="text" name="lname" value="<?= $info['lname'] ?>">
        Date of Birth: <input type="date" name="birth" value="<?= $info['dob'] ?>">
        Address: <input type="text" name="addr" value="<?= $info['addr'] ?>">
        Position: <input type="text" name="position" value="<?= $info['position'] ?>">
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