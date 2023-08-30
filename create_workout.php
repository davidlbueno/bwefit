<?php
$pageTitle = "Create Workout";
include_once 'php/session.php';
require_once 'php/db_connect.php';
require_once 'php/db_query.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
require_once 'php/header.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

<body class="dark">
<?php include 'html/nav.html'; ?>
  <main class="container">
  <div class="row">
    <div class="row">
      <div class="input-field col s12">
        <input type="text" name="workout-name" id="workout-name" placeholder="Workout Name" style="width:100%;">
        </div>
        <div class="row">
          <div class="col s12">
          <h8>Workout Length</h8>
          <div id="workout-length" style="display: inline-block;">0:00</div>
        </div>
    </div>
    <div class="col s12">
      <ol id="workout-list" class="sortable"></ol>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s2">
      <select name="type" id="type-select">
        <option value="" disabled selected>Item</option>
        <option value="Push">Push</option>
        <option value="Pull">Pull</option>
        <option value="Legs">Legs</option>
        <option value="Core">Core</option>
        <option value="Rest">Rest</option>
      </select>
    </div>
  <div class="input-field col s4">
    <select name="exercise" id="exercise-select" disabled>
      <option value="" disabled selected>Exercise</option>
    </select>
  </div>
  <div class="input-field col s2">
    <input type="number" name="seconds" min="0" max="300" step="5" placeholder="Seconds" style="width:100%;">
  </div>
  <div class="input-field col s2">
  <input type="number" name="sets" id="sets-select" min="0" max="10" step="1" placeholder="Sets" style="width:100%;">
  </div>
  <div class="row">
  <div class="input-field col s2" style="display: flex; align-items: center;">
    <label>
      <input type="checkbox" name="warmup" id="warmup" style="width:100%;">
      <span>Warmup</span>
    </label>
  </div>
</div>
  <div class="row">
    <div class="col s12">
      <button id="add-type-btn" class="btn">Add Item</button>
      <button id="clear-list-btn" class="btn">Clear List</button>
      <button id="save-workout-btn" class="btn">Save Workout</button>
      <button id="cancel-workout-btn" class="btn">Cancel</button>
    </div> 
  </div>
  </main>
  <script src="js/nav.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var script = document.createElement('script');
      script.src = 'js/create_workout.js';
      document.head.appendChild(script);
    });
  </script>
  <script src="js/save_workout.js"></script>
  <?php include 'html/footer.html'; ?>
</body>
</html>
