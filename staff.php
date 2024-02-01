<?php
session_start();
require_once 'config.php';
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
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php include 'sidebar.php';?>

    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include 'header.php';?>

      <!--  Header End -->
      <div class="container-fluid">
  <div class="card">
    <div class="card-body w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="card-title fw-semibold">Staff</h5>
    <!-- Button to Open Add Staff Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">
        Add New Staff
    </button>
    </div>


      <!-- Teachers Table -->
      <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Last_Login</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
  <tbody>
  <?php
  // Query to select all staff members
  $query = "SELECT id, name, email, role, last_login FROM staff ORDER BY name ASC";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<th scope='row'>" . htmlspecialchars($row['id']) . "</th>";
          echo "<td>" . htmlspecialchars($row['name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
          echo "<td>" . htmlspecialchars($row['role']) . "</td>";
          echo "<td>" . htmlspecialchars($row['last_login']) . "</td>";
          echo "<td>";
          echo "<button class='btn btn-success btn-sm' onclick='editStaff(" . $row['id'] . ")'> <i class='material-icons'>edit</i></button> ";
          echo "<button class='btn btn-danger btn-sm' onclick='deleteStaff(" . $row['id'] . ")'> <i class='material-icons'>delete</i></button>";
          echo "</td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='6'>No staff found</td></tr>";
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


 <!-- Add Staff Member Modal -->
 <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStaffModalLabel">Add New Staff Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addStaffForm">
          <div class="form-group">
            <label for="staffName">Name</label>
            <input type="text" class="form-control" id="staffName" name="staffName" required>
          </div>
          <div class="form-group">
            <label for="staffEmail">Email</label>
            <input type="email" class="form-control" id="staffEmail" name="staffEmail" required>
          </div>
          <div class="form-group">
            <label for="staffSubject">Role</label>

            <!-- Select Role -->
            <select class="form-control" id="staffRole" name="staffRole" required>
              <option value="" selected disabled>Select Role</option>
              <option value="Mathematics">Admin</option>
              <option value="English">Faculty</option>
              <option value="Science">Other</option>
            </select>
            
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addStaffMember()">Add Staff</button>
      </div>
    </div>
  </div>
</div>



  <script>
function addStaffMember() {
  // Example function to handle adding a staff member
  // In practice, you would collect form data and send it to a server-side script (e.g., via AJAX)
  console.log('Adding staff member...');
  
  $.ajax({
    type: "POST",
    url: "scripts/add_staff.php",
    data: $("#addStaffForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#addStaffModal').modal('hide');
      alert(response.message);
      //reload the page
      location.reload();

    },
    error: function() {
      alert(response.message);
    }
  });
}
</script>



  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>





 

</body>

</html>