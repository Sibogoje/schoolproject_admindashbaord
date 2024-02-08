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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
  <div class="card" style="background: #f5f5f5;">
      <div class="card-body w-100">

      <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="row"> <!-- Wrap the input group in a row for proper alignment -->
        <div class="col-lg-12"> <!-- Adjust the column size as needed -->
            <div class="input-group">
                <input type="text" style="background: white;" class="form-control" placeholder="Search staff..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Button to Open Add Staff Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">
        Add New Class
    </button>
</div>




      <!-- Teachers Table -->
      <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Faculty</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
  <tbody>
  <?php
  // Query to select all staff members
  $query = "SELECT c.id, c.name, d.name AS department_name, f.name AS faculty_name FROM class c
  LEFT JOIN department d ON c.department_id = d.id
  LEFT JOIN staff f ON c.faculty_id = f.id
  ORDER BY c.name ASC";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
  echo "<tr>";
  echo "<th scope='row'>" . htmlspecialchars($row['id']) . "</th>";
  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
  echo "<td>" . htmlspecialchars($row['department_name']) . "</td>"; // Updated
  echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>"; // Updated
  echo "<td>";
  // Assuming you have a way to fetch 'email' and 'role', which are not mentioned in the SELECT
  echo "<button class='btn btn-success btn-sm editBtn' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editStaffModal'> <i class='material-icons'>edit</i></button> ";
  echo "<button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['id'] . "'> <i class='material-icons'>delete</i></button>";
  echo "</td>";
  echo "</tr>";
  }
  } else {
  echo "<tr><td colspan='6'>No class found</td></tr>";
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


<!-- Edit Staff Member Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStaffModalLabel">Edit Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editStaffForm">
          <input type="hidden" id="editId" name="editId">
          <div class="form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" id="editName" name="editName" required>
          </div>

          <?php
          // Query to fetch department data
          $query = "SELECT id, name FROM department ORDER BY name ASC";
          $result = $conn->query($query);
          ?>

          <div class="form-group">
          <label for="editdepartment">Department</label>
          <select class="form-control" id="editdepartment" name="editdepartment" required>
            <option value="" selected disabled>Select Department</option>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
          </select>
          </div>

          <div class="form-group">
            <label for="editFaculty">Faculty</label>
            <select class="form-control" id="editFaculty" name="editFaculty" required>
              <option value="" selected disabled>Select Faculty</option>
              <option value="Admin">Admin</option>
              <option value="Faculty">Faculty</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateStaffMember()">Save changes</button>
      </div>
    </div>
  </div>
</div>



 <!-- Add Staff Member Modal -->
 <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStaffModalLabel">Add New Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addClassForm">
          <div class="form-group">
            <label for="className">Class Name</label>
            <input type="text" class="form-control" id="className" name="className" required>
          </div>

          <?php
          // Query to fetch department data
          $query = "SELECT id, name FROM department ORDER BY name ASC";
          $result = $conn->query($query);
          ?>

          <div class="form-group">
          <label for="department">Department</label>
          <select class="form-control" id="department" name="department" required>
            <option value="" selected disabled>Select Department</option>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
          </select>
          </div>

          <?php
          // Query to fetch department data
          $query = "SELECT id, name FROM staff where role = 'Faculty' ORDER BY name ASC";
          $result = $conn->query($query);
          ?>

          <div class="form-group">
          <label for="faculty">Faculty</label>
          <select class="form-control" id="faculty" name="faculty" required>
            <option value="" selected disabled>Select Faculty</option>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
          </select>
          </div>



        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addClass()">Add CLass</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
    $("#searchButton").click(function(){
        var value = $("#searchInput").val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Optional: Trigger search on input field "Enter" key press
    $("#searchInput").on("keyup", function(event) {
        if (event.keyCode === 13) { // 13 is the Enter key
            $("#searchButton").click();
        }
    });
});
</script>

<script>
$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>


<script>
$(document).ready(function(){
  $('.editBtn').click(function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var role = $(this).data('role');
    
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editEmail').val(email);
    $('#editRole').val(role);
  });
});
</script>


<script>
$(document).ready(function() {
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this staff member?')) {
            $.ajax({
                type: "POST",
                url: "scripts/delete_staff.php", // Path to your delete script
                data: { id: id },
                dataType: "json",
                success: function(response) {
                  alert(response.message);
                  location.reload(); // Reload the page to see the changes

                },
                error: function() {
                  alert(response.message);
                }
            });
        }
    });
});
</script>


<script>
  function updateStaffMember() {
  $.ajax({
    type: "POST",
    url: "scripts/update_staff.php", // Path to your update script
    data: $("#editStaffForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#editStaffModal').modal('hide');
      location.reload(); // Reload the page to see the changes
    },
    error: function() {
      alert('Error updating staff member!');
    }
  });
}

</script>
<script>
function addClass() {
  // Example function to handle adding a staff member
  // In practice, you would collect form data and send it to a server-side script (e.g., via AJAX)
  console.log('Adding staff member...');
  
  $.ajax({
    type: "POST",
    url: "scripts/add_class.php",
    data: $("#addClassForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#addClassModal').modal('hide');
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




  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>





 

</body>

</html>