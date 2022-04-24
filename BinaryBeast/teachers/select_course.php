<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'education';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
//to make teachers' course list(option value=course_id)
$course_option = '';
$select_cmd = "SELECT * FROM `course_tb` WHERE teacher_id = '" . $_SESSION['userid'] . "'";
$result = $dbcon->query($select_cmd);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_option .= "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
    }
}

//when the teacher register add mark, comment
if (isset($_GET['register'])) {
    echo "<div class='title' style='color:blue;'>Mark & Comment Registered</div>";
}
//when the mark already exists
if (isset($_GET['already'])) {
    echo "<div class='title' style='color:red;'>The mark is already added</div>";
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
    <div class="title">Select Course</div>
    <!-------- when select the course, move to add_mark.php file -------->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?addr=add_mark'; ?>">
        Course name: <select name="courseid">
            <?php echo $course_option; ?>
        </select>
        <div class="radioDiv">
            <button type="submit">Select</button>
        </div>
    </form>

</body>

</html>