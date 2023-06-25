<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BWE - Workout Logs</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <?php require_once 'php/db.php'; ?>
</head>
<body class="dark">
  <main class="container">
    <?php
    // Get the passed workout ID and user ID from the URI
    $workoutId = $_GET['workout_id'];
    $userId = $_GET['user_id'];

    // Retrieve the workout name from the database
    $workoutQuery = "SELECT name FROM workouts WHERE id = $workoutId";
    $workoutResult = query($workoutQuery);
    $workoutRow = mysqli_fetch_assoc($workoutResult);
    $workoutName = $workoutRow['name'];

    // Display the workout name
    echo "<h4>Workout: $workoutName</h4>";

    // Retrieve the workout logs from the database
    $logsQuery = "SELECT id, start_time, end_time FROM workout_logs WHERE workout_id = $workoutId AND user_id = $userId";
    $logsResult = query($logsQuery);

    // Display the table of workout logs
    echo "<table>";
    echo "<thead><tr><th>Date</th><th>Length</th><th></th></tr></thead>";
    echo "<tbody>";
    while ($logRow = mysqli_fetch_assoc($logsResult)) {
      $logId = $logRow['id'];
      $startTime = $logRow['start_time'];
      $endTime = $logRow['end_time'];
    
      // Calculate the duration of the workout
      $duration = strtotime($endTime) - strtotime($startTime);
      $length = gmdate("H:i:s", $duration);
    
      echo "<tr>";
      echo "<td><a href='workout_log.php?log_id=$logId'>$startTime</a></td>";
      echo "<td>$length</td>";
      echo "<td><a href='#' class='delete-btn' data-log-id='$logId'><i class='material-icons'>delete</i></a></td>";
      echo "</tr>";
    }    
    echo "</tbody>";
    echo "</table>";
    ?>
    <a href="#" id="closeBtn" class="close-btn">
      <i class="material-icons">close</i>
    </a>
  </main>
  <script>
    const userId = <?php echo json_encode($userId); ?>;
    const workoutId = <?php echo json_encode($workoutId); ?>;
    document.getElementById('closeBtn').href = "workout.php?user_id=" + userId + "&workout_id=" + workoutId;
    // Add event listener for delete buttons
    const deleteButtons = document.getElementsByClassName('delete-btn');
    for (let i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].addEventListener('click', function(event) {
        event.preventDefault();
        const logId = this.getAttribute('data-log-id');
        deleteWorkoutLog(logId);
      });
    }

    function deleteWorkoutLog(logId) {
      console.log(logId);
      if (confirm(`Are you sure you want to delete this workout log?`)) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "php/delete_workout_log.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = () => {
          if (xhr.status === 200) {
            location.reload();
            console.log(xhr.responseText);
          } else {
            console.error(xhr.responseText);
          }
        };

        console.log(logId);
        const payload = {
          log_Id: logId,
        };

        xhr.send(JSON.stringify(payload));
      }
    }
  </script>
</body>
</html>
