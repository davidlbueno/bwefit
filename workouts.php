<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <?php include 'php/header.php'; ?>
  <title>ExerHub - Workouts</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <style>
    [type="checkbox"]+span:not(.lever):before, [type="checkbox"]:not(.filled-in)+span:not(.lever):after {
      border: 1px solid #808080;
    }
    </style>
  <?php require_once 'php/db.php'; ?>
</head>
<body class="dark">
<nav>
<div class="nav-wrapper">
  <span class="brand-logo" style="margin-left: 60px"><a href="index.html"><i class="material-icons">home</i>/</a><span class="sub-page-name">Workouts</span></span>
    <a href="index.html" data-target="side-nav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
    <ul class="right" id="top-nav"></ul>
</div>
</nav>
  <ul class="sidenav" id="side-nav"></ul>
  <main class="container">
  <div class="row">
  <div class="col s12" style="text-align: center; margin: 5px; display: flex; justify-content: center; flex-wrap: wrap;">
    <a href="create_workout.php"><button class="btn" id="selectWorkoutBtn" style="margin: 5px; line-height: 1;">Select Workout</button></a>
    <a href="create_workout.php"><button class="btn" id="createWorkoutBtn" style="margin: 5px; line-height: 1;">Create Workout</button></a>
    <a href="create_workout.php"><button class="btn" id="workoutHistoryBtn" style="margin: 5px; line-height: 1;">Workout History</button></a>
  </div>
  <div class="row">
    <div class="col s12">
      <h6>My Workouts:</h6>
    <div class="col s12">
    <?php
        // Fetch and display the workouts for the current user
        session_start();
        $userId = $_SESSION['user_id'];
        $workouts = fetchWorkouts($userId);
        $isAdmin = $_SESSION['is_admin'];
        displayWorkouts($workouts, $isAdmin);
        // Function to fetch workouts for the current user from the database
        function fetchWorkouts($userId) {
          global $conn;
          $query = "SELECT * FROM workouts WHERE user_id = $userId";
          $result = query($query);
          $workouts = array();
          while ($row = mysqli_fetch_assoc($result)) {
            $workouts[] = $row;
          } 
          return $workouts;
        }
        // Function to display the fetched workouts
        function displayWorkouts($workouts, $isAdmin) {
          if (empty($workouts)) {
            echo "<p>No workouts found.</p>";
          } else {
            echo "<ul>";
            foreach ($workouts as $workout) {
              echo "<li>";
              echo "<a href='workout.php?workout_id=" . $workout['id'] . "&workout_name=" . urlencode($workout['name']) . "' style='display: block; line-height: 1;'>";
              echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
              // Align workout name to the left
              echo "<div style='flex: 1;'>" . $workout['name'] . "</div>";
              // Align checkbox to the left
              if ($isAdmin) {
                echo "<div>";
                echo "<label style='display: flex; align-items: center;'>"; // Align the label and checkbox contents vertically
                echo "<span style='margin-right: 5px;'>Public: </span>"; // Add some space between the label text and the checkbox
                echo "<input type='checkbox' name='Public' id='isPublic'/>";
                echo "<span ></span>"; // Empty span for checkbox styling (optional)
                echo "</label>";
                echo "</div>";
              }
              echo "</div>";
              echo "</a>";
              echo "</li>";
            }
            echo "</ul>";
          }
        }        
      ?>
    </div>
  </main>
  <script src="js/nav.js"></script>
</body>
</html>
