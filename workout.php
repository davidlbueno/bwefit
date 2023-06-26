<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BWE - Workout</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <?php require_once 'php/db.php'; ?>
</head>
<body class="dark">
  <nav>
    <div class="nav-wrapper">
      <span class="brand-logo" style="margin-left: 60px"><a href="index.html">BWE/</a><a href="workouts.php">Workouts/</a><span class="sub-page-name">Workout</span></span>
      <a href="index.html" data-target="side-nav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right" id="top-nav"></ul>
    </div>
  </nav>
  <ul class="sidenav" id="side-nav"></ul>
  <main class="container">
    <?php
    $workoutId = $_GET['workout_id'] ?? null;
    if ($workoutId) {
      $query = "SELECT name FROM workouts WHERE id = $workoutId";
      $result = query($query);
      $row = mysqli_fetch_assoc($result);
      $workoutName = $row['name'];
      echo "<h1>$workoutName</h1>";

      $query = "SELECT ws.type, e.id AS exercise_id, e.name AS exercise_name, ws.seconds, ws.warmup
                FROM workout_sequences ws
                LEFT JOIN exercises e ON e.id = ws.exercise_id
                WHERE ws.workout_id = $workoutId";
      $result = query($query);

      echo "<ol>";
      // Create the list items based on the retrieved data
      while ($row = mysqli_fetch_assoc($result)) {
        $type = $row['type'];
        $exerciseName = $row['exercise_name'];
        $seconds = $row['seconds'];
        $warmup = $row['warmup'];

        if ($type === "Rest") {
          echo "<li class='rest'><strong>Rest</strong> - ({$seconds}s)</li>";
        } else {
          if ($warmup === '1') {
            echo "<li class='warmup'><strong>Warmup</strong> - $exerciseName ({$seconds}s)</li>";
          } else {
            $exerciseType = $exercises[$exerciseName]['type'];
            echo "<li ><strong>$exerciseType</strong> - $exerciseName ({$seconds}s)</li>";
          }
        }
      }
      echo "</ol>";

      echo '
      <button class="btn" id="startWorkoutBtn">Start Workout</button>
      <button class="btn" id="editBtn">Edit Workout</button>
      <button class="btn" id="viewLogBtn">View Log</button>';
    } else {
      echo "<p>No Workout ID provided.</p>";
    }
    ?>
  </main>
  <script src="js/nav.js"></script>
  <script>
    window.onload = function() {
      const workoutId = <?php echo json_encode($workoutId); ?>;
      const workoutName = <?php echo json_encode($workoutName); ?>;
      const userId = sessionVars.userId;

      startWorkoutBtn.addEventListener('click', function () {
        const workoutPlayerUrl = `workout_player.php?user_id=${userId}&workout_id=${workoutId}`;
        window.location.href = workoutPlayerUrl;
      });

      editBtn.addEventListener('click', function () {
        const editUrl = `edit_workout.php?workout_id=${workoutId}&workout_name=${encodeURIComponent(workoutName)}`;
        window.location.href = editUrl;
      });

      viewLogBtn.addEventListener('click', function () {
        window.location.href = 'workout_logs.php?workout_id=' + workoutId + '&user_id=' + userId;
      });
    };
  </script>
</body>
</html>
