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
                <input type="text" style="background: white;" class="form-control" placeholder="Search Student..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Button to Open Add Student Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
        Add New Student
    </button>
</div>




      <!-- Teachers Table -->
      <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">Roll#</th>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Email</th>
            <th scope="col">phone</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
  <tbody>
  <?php
  // Query to select all Student members
  $query = "SELECT * FROM students ORDER BY student_id ASC";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      // Output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<th scope='row'>" . htmlspecialchars($row['student_id']) . "</th>";
          echo "<td>" . htmlspecialchars($row['name']) ."</td>";
          echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
          echo "<td>" . htmlspecialchars($row['email']) . "</td>";
          echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
          echo "<td>";
          echo "<button class='btn btn-success btn-sm editBtn' 
          data-id='" . $row['id'] . "' 
          data-student_id='" . $row['student_id'] . "'
          data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "' 
          data-surname='" . htmlspecialchars($row['surname'], ENT_QUOTES) . "' 
          data-email='" . htmlspecialchars($row['email'], ENT_QUOTES) . "' 
          data-phone='" . htmlspecialchars($row['phone'], ENT_QUOTES) . "'
          data-toggle='modal' data-target='#editStudentModal'> <i class='material-icons'>edit</i></button> ";

          echo "<button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['id'] . "'> <i class='material-icons'>delete</i></button>";

          echo "</td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='6'>No Student found</td></tr>";
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


<!-- Edit Student Member Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Edit Student Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editStudentForm">
          <input type="hidden" id="editId" name="editId">
          <div class="form-group">
            <label for="editStudent_id">Roll #</label>
            <input type="text" class="form-control" id="editStudent_id" name="editStudent_id" required>
          </div>
          <div class="form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" id="editName" name="editName" required>
          </div>
          <div class="form-group">
            <label for="editSurname">Surname</label>
            <input type="email" class="form-control" id="editSurname" name="editSurname" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail" required>
          </div>
          <div class="form-group">
            <label for="editPhone">Phone</label>
            <input type="text" class="form-control" id="editPhone" name="editPhone" required>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateStudent()">Save changes</button>
      </div>
    </div>
  </div>
</div>



 <!-- Add Student Member Modal -->
 <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add New Student Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addStudentForm">
        <div class="form-group">
            <label for="Student_No">Roll #</label>
            <input type="text" class="form-control" id="Student_No" name="Student_No" required>
          </div>
          <div class="form-group">
            <label for="StudentName">Name</label>
            <input type="text" class="form-control" id="StudentName" name="StudentName" required>
          </div>
          <div class="form-group">
            <label for="StudentSurname">Surname</label>
            <input type="text" class="form-control" id="StudentSurname" name="StudentSurname" required>
          </div>
          <div class="form-group">
            <label for="StudentEmail">Email</label>
            <input type="email" class="form-control" id="StudentEmail" name="StudentEmail" required>
          </div>
          <div class="form-group">
            <label for="StudentPhone">Phone</label>
            <input type="text" class="form-control" id="StudentPhone" name="StudentPhone" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addStudent()">Add Student</button>
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
    var student_id = $(this).data('student_id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var surname = $(this).data('surname');
    var phone = $(this).data('phone');
    
    $('#editId').val(id);
    $('#editStudent_id').val(student_id);
    $('#editName').val(name);
    $('#editSurname').val(surname);
    $('#editEmail').val(email);
    $('#editPhone').val(phone);
   
  });
});
</script>


<script>
$(document).ready(function() {
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this Student member?')) {
            $.ajax({
                type: "POST",
                url: "scripts/delete_Student.php", // Path to your delete script
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
  function updateStudent() {
  $.ajax({
    type: "POST",
    url: "scripts/update_Student.php", // Path to your update script
    data: $("#editStudentForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#editStudentModal').modal('hide');
      location.reload(); // Reload the page to see the changes
    },
    error: function() {
      alert('Error updating Student member!');
    }
  });
}

</script>
<script>
function addStudent() {
  // Example function to handle adding a Student member
  // In practice, you would collect form data and send it to a server-side script (e.g., via AJAX)
  console.log('Adding Student member...');
  
  $.ajax({
    type: "POST",
    url: "scripts/add_Student.php",
    data: $("#addStudentForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#addStudentModal').modal('hide');
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