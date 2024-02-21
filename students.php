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
                <input type="text" style="background: white;" class="form-control" placeholder="Search student..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Button to Open Add Staff Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
        Add New Student
    </button>
</div>




      <!-- Teachers Table -->
      <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">Roll #</th>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Email</th>
            <th scope="col">phone</th>
            <th scope="col">Course</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
  <tbody>
  <?php
// Adjust your query to join the students table with the courses table
$query = "SELECT 
            students.student_id, 
            students.name, 
            students.surname, 
            students.email, 
            students.phone, 
            courses.name as course_name,
            students.id,
            course
          FROM 
            students
          INNER JOIN courses ON students.course = courses.id
          ORDER BY 
            students.name ASC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . htmlspecialchars($row['student_id']) . "</th>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['course_name']) . "</td>"; // Display the course name
        echo "<td>";

        echo "<button class='btn btn-success btn-sm editBtn' data-id='" . $row['id'] . "' 
        data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "' 
        data-surname='" . htmlspecialchars($row['surname'], ENT_QUOTES) . "'
        data-email='" . htmlspecialchars($row['email'], ENT_QUOTES) . "' 
        data-phone='" . htmlspecialchars($row['phone'], ENT_QUOTES) . "' 
        data-course='" . htmlspecialchars($row['course'], ENT_QUOTES) . "'
        data-toggle='modal' data-target='#editStudentModal'> <i class='material-icons'>edit</i></button> ";
        echo "<button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['id'] . "'> <i class='material-icons'>delete</i></button>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No Students found</td></tr>";
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


<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStaffModalLabel">Edit Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editStudentForm">
          <input type="hidden" id="editId" name="editId">
          <div class="form-group">
            <label for="editStudent_id">Roll #</label>
            <input type="number" class="form-control" id="editStudent_id" name="editStudent_id" required>
          </div>
          <div class="form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" id="editName" name="editName" required>
          </div>
          <div class="form-group">
            <label for="editSurname">Surname</label>
            <input type="text" class="form-control" id="editSurname" name="editSurname" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail" required>
          </div>
          <div class="form-group">
            <label for="editPhone">Phone</label>
            <input type="text" class="form-control" id="editPhone" name="editPhone" required>
          </div>

          <!-- add select for courses -->
          <div class="form-group">
            <label for="editCourse">Course</label>
            <select class="form-control" id="editCourse" name="editCourse" required>
              <option value="">Select Course</option>
              <?php
              // Fetch courses from the database
              $sql = "SELECT * FROM courses"; // Adjust 'courses' according to your actual table name
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                  }
              } else {
                  echo "<option value=''>No courses found</option>";
              }
              ?>
            </select>
          </div>
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
 <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStaffModalLabel">Add New Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="addStudentForm">
          <div class="form-group">
            <label for="studentNo">Roll #</label>
            <input type="text" class="form-control" id="studentNo" name="studentNo" required>
          <div class="form-group">
            <label for="studentName">Name</label>
            <input type="text" class="form-control" id="studentName" name="studentName" required>
          </div>
          <div class="form-group">
            <label for="studentSurname">Surname</label>
            <input type="text" class="form-control" id="studentSurname" name="studentSurname" required>
          </div>
          <div class="form-group">
            <label for="studentEmail">Email</label>
            <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
          </div>
          <div class="form-group">
            <label for="studentPhone">Phone</label>
            <input type="text" class="form-control" id="studentPhone" name="studentPhone" required>
          </div>

          <!-- add select for courses -->
          <div class="form-group">
            <label for="course">Course</label>
            <select class="form-control" id="course" name="course" required>
              <option value="">Select Course</option>
              <?php
              // Fetch courses from the database
              $sql = "SELECT * FROM courses"; // Adjust 'courses' according to your actual table name
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                  }
              } else {
                  echo "<option value=''>No courses found</option>";
              }
              ?>
            </select>
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
    var name = $(this).data('name');
    var surname = $(this).data('surname');
    var email = $(this).data('email');
    var student_id = $(this).data('student_id');
    var phone = $(this).data('phone');
    var course = $(this).data('course');
    
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editSurname').val(surname);
    $('#editEmail').val(email);
    $('#editPhone').val(phone);
    $('#editStudent_id').val(student_id);
    $('#editCourse').val(course);
  });
});
</script>


<script>
$(document).ready(function() {
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this Student?')) {
            $.ajax({
                type: "POST",
                url: "scripts/delete_student.php", // Path to your delete script
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
      $('#editStaffModal').modal('hide');
      alert(response.message);
      location.reload(); // Reload the page to see the changes
    },
    error: function() {
      alert(response.message);
      //alert('Error updating staff member!');
    }
  });
}

</script>
<script>
function addStudent() {
  // Example function to handle adding a staff member
  // In practice, you would collect form data and send it to a server-side script (e.g., via AJAX)
  console.log('Adding student member...');
  
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