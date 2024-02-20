<?php
session_start();
require_once 'config.php'; // Adjust the path as needed

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



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Attendance</title>
  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>

<?php
// Include database connection
// Fetch classes from the database
$sql = "SELECT id, name FROM class"; // Adjust 'classes' and 'class_name' according to your actual table and column names
$result = $conn->query($sql);
?>

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
    
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Home</h5>
          <p class="mb-0">This is a sample page </p>
          <!-- Classes Cards -->
          <?php if ($result->num_rows > 0): ?>
            <div class="row">
              <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                  <div class="card mt-3" onclick="window.location.href='classdetail.php?name=<?= $row['id']; ?>'">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php else: ?>
            <p>No classes found.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>