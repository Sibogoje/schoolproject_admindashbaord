<?php
session_start();
require_once 'encryption.php';
require_once 'config.php';
$course_id = isset($_GET['id']) ? decrypt($_GET['id']) : null;
// Check if the user is logged in, using a session variable (e.g., $_SESSION['loggedin'])
// This assumes you set this session variable at login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Clear any existing session data
    $_SESSION = array();
    session_destroy();
    
    // Redirect to login page
    header("Location: logout.php"); // Assume 'logout.php' handles redirection to the login page and clearing sessions
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Attendance</title>
  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <!-- Correct order -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">
  <!-- Sidebar Start -->
  <?php include 'sidebar.php'; ?>
  <!--  Sidebar End -->
  
  <!--  Main wrapper -->
  <div class="body-wrapper">
    <!--  Header Start -->
    <?php include 'header.php'; ?>
    <!--  Header End -->
    
     <!--  Header End -->
     <div class="container-fluid">
  <div class="card" style="background: #f5f5f5;">
      <div class="card-body w-100">

      <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="row"> <!-- Wrap the input group in a row for proper alignment -->
        <div class="col-lg-12"> <!-- Adjust the column size as needed -->
            <div class="input-group">
                <input type="text" style="background: white;" class="form-control" placeholder="Search Subject..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Button to Open Add Staff Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">
        Add New Fence
    </button>
</div>


   

    <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Subject</th>
            <th scope="col">T. Students</th>
            <th scope="col">T. Classes</th>
            <th scope="col">% Attendance</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
  <tbody>


  <?php
// Assuming $conn is your database connection

// Adjust the SQL query to join with the classes table to get the class name
$sql = "SELECT 
            c.name, 
            COUNT(DISTINCT a.student_id) AS total_students,
            COUNT(DISTINCT CONCAT(a.class_id, '_', a.date)) AS total_classes_occurred, 
            (COUNT(CASE WHEN a.status = 'Present' THEN 1 END) / (COUNT(DISTINCT a.student_id) * COUNT(DISTINCT CONCAT(a.class_id, '_', a.date)))) * 100 AS attendance_percentage
        FROM 
            Attendance a
        JOIN 
            courses c ON a.course = c.id
        WHERE 
            a.course = '$course_id'
        GROUP BY 
            a.course;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . htmlspecialchars($row['course_name']) . "</th>";
        echo "<td>" . htmlspecialchars($row['total_students']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_classes_occurred']) . "</td>";
        echo "<td>" . htmlspecialchars(number_format($row['attendance_percentage'], 2)) . "%</td>";
        echo "</tr>";
        // Ensure data attributes are correct for the edit button
        echo "<button class='btn btn-success btn-sm editBtn' 
       
        data-toggle='modal' data-target='#editClassModal'> <i class='material-icons'>edit</i></button> ";
        echo "<button class='btn btn-danger btn-sm deleteBtn' > <i class='material-icons'>delete</i></button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No Geo Fence Found</td></tr>";
}
?>


</tbody>

      </table>
      </div>

    </div>
  </div>
</div>

  </div>
</div>

<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>