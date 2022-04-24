<?php
session_start();
//default page
if (!isset($_GET['addr'])) {
  $_GET['addr'] = 'admin_main';
}
if(isset($_GET['signout'])){
  session_unset();
  session_destroy();
  header("Location: ../login.php?err=loggedout");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../indexStyles.css" />
  <title>BINARY BEAST</title>
</head>

<!------------------------------START---------------------------------------------- -->

<body>
  <!-- LEFT SIDE FIXED MENU (LEFT SIDE DASHBOARD) -->
  <div id="leftSideMenu">
    <nav class="leftSideNav">
    <button type="button" class="navLink" id="logo">BINARY BEAST</button>
      <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=admin_main' ?>" class="navLink" role="tab" aria-selected="true" id="showDashboard">
        <img src="../icons/dashboard.png" class="menuIcon" />
        ADMIN DASHBOARD
      </a>
      <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=user_register' ?>" class="navLink" role="tab" aria-selected="true" id="showDashboard">
        <img src="../icons/uiElements.png" class="menuIcon" />
        ADD NEW USER
      </a>
      <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=edit_user' ?>" class="navLink" role="tab" aria-selected="false" id="showUiElements">
        <img src="../icons/uiElements.png" class="menuIcon" />EDIT USER </a>
      <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=course_register' ?>" class="navLink" role="tab" aria-selected="false" id="showTabsPanel">
        <img src="../icons/uiElements.png" class="menuIcon" />ADD NEW COURSE </a>

    </nav>
  </div>
  <!-- MAIN CONTENT (RIGHT SIDE DASHBOARD) -->

  <div id="mainContainer" class="tabs">
    <!-- TOP NAVIGATION -->
    <nav class="topNav">
      <button type="button" class="hideShowLeftMenu" id="hideShowBtn">
        <img src="../icons/hamburger.png" id="burger" />
        <p id="showOrHide">HIDE MENU</p>
      </button>
      <button type="button" class="activeUser" id="username">
        <img src="../icons/user.png" id="userIcon" />
        Admin
        <a class="link" href="<?php echo $_SERVER['PHP_SELF'].'?signout=1' ?>">Sign out</a>
      </button>
    </nav>
    <!-- TABS FOR THE MAIN CONTENT -->
    <section class="dashboardMain">
      <div class="insideWrapper">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
          include('./' . $_GET['addr'] . '.php');
        }
        ?>
      </div>
    </section>
  </div>

  <!------------------------------FINISH-------------------------------------------------->

  <script>
    const leftNav = document.querySelector("#leftSideMenu");
    const hideShowBtn = document.querySelector("#hideShowBtn");
    let hideShowImg = document.querySelector("#burger");
    const showHideText = document.querySelector("#showOrHide");
    //   GLOBAL VARIABLES----------------------------------------------

    function showHideNav() {
      //   this function hide and shows the left nav, change the burger to color blue and change the text next to the hamburger menu (SHOW MENU or HIDE MENU).
      if (leftNav.style.display === "") {
        leftNav.style.display = "none";
        leftNav.style.transition = "all 2s ease-in";
        hideShowImg.src = "../icons/hamburgerActive.png";
        showHideText.textContent = "SHOW MENU";
      } else if (leftNav.style.display === "none") {
        leftNav.style.display = "block";
        hideShowImg.src = "../icons/hamburger.png";
        showHideText.textContent = "HIDE MENU";
      } else {
        leftNav.style.display = "none";
        hideShowImg.src = "../icons/hamburgerActive.png";
        showHideText.textContent = "SHOW MENU";
      }
    }

    hideShowBtn.addEventListener("click", showHideNav);
  </script>
</body>

</html>