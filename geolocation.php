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
                <input type="text" style="background: white;" class="form-control" placeholder="Search Class..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Button to Open Add Staff Member Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClassModal">
        Add New Fence
    </button>
</div>




      <!-- Teachers Table -->
      <div class="table-responsive">
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Class</th>
            <th scope="col">A</th>
            <th scope="col">B</th>
            <th scope="col">C</th>
            <th scope="col">D</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
  <tbody>


  <?php
// Assuming $conn is your database connection

// Adjust the SQL query to join with the classes table to get the class name
$sql = "SELECT geo_fence.id, geo_fence.class, class.name, geo_fence.A, geo_fence.B, geo_fence.C, geo_fence.D 
FROM `u747325399_project`.`geo_fence`
JOIN `u747325399_project`.`class` ON geo_fence.class = class.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th scope='row'>" . htmlspecialchars($row['id']) . "</th>";
        // Display the class name instead of class ID
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['A']) . "</td>";
        echo "<td>" . htmlspecialchars($row['B']) . "</td>";
        echo "<td>" . htmlspecialchars($row['C']) . "</td>";
        echo "<td>" . htmlspecialchars($row['D']) . "</td>";
        echo "<td>";
        // Ensure data attributes are correct for the edit button
        echo "<button class='btn btn-success btn-sm editBtn' 
        data-id='" . $row['id'] . "' 
        data-classid='" . htmlspecialchars($row['class'], ENT_QUOTES) . "'
        data-a='" . htmlspecialchars($row['A'], ENT_QUOTES) . "'
        data-b='" . htmlspecialchars($row['B'], ENT_QUOTES) . "'
        data-c='" . htmlspecialchars($row['C'], ENT_QUOTES) . "'
        data-d='" . htmlspecialchars($row['D'], ENT_QUOTES) . "'
        data-toggle='modal' data-target='#editClassModal'> <i class='material-icons'>edit</i></button> ";
        echo "<button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['id'] . "'> <i class='material-icons'>delete</i></button>";
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


<!-- Edit Staff Member Modal -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStaffModalLabel">Edit Fence</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editClassForm">
          <input type="hidden" id="editId" name="editId">

          <?php
          // Query to fetch department data
          $query = "SELECT id, name FROM class ORDER BY name ASC";
          $result = $conn->query($query);
          ?>

          <div class="form-group">
          <label for="editClass">Class</label>
          <select class="form-control" id="editClass" name="editClass" required>
            <option value="" selected disabled>Select Class</option>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
          </select>
          </div>

          <div class="form-group">
            <label for="editA">Point A</label>
            <input type="text" class="form-control" id="editA" name="editA" required>
          </div>

          <div class="form-group">
            <label for="editB">Point B</label>
            <input type="text" class="form-control" id="editB" name="editB" required>
          </div>

          <div class="form-group">
            <label for="editC">Point C</label>
            <input type="text" class="form-control" id="editC" name="editC" required>
          </div>

          <div class="form-group">
            <label for="editD">Point D</label>
            <input type="text" class="form-control" id="editD" name="editD" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateFence()">Save changes</button>
      </div>
    </div>
  </div>
</div>



 <!-- Add Staff Member Modal -->
 <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStaffModalLabel">Add New Fence</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addClassForm">


          <?php
          // Query to fetch department data
          $query = "SELECT id, name FROM class ORDER BY name ASC";
          $result = $conn->query($query);
          ?>

          <div class="form-group">
          <label for="class">Department</label>
          <select class="form-control" id="class" name="class" required>
            <option value="" selected disabled>Select Class</option>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
          </select>
          </div>

          <div class="form-group">
            <label for="A">Point A</label>
            <input type="text" class="form-control" id="A" name="A" required>
          </div>

          <div class="form-group">
            <label for="B">Point B</label>
            <input type="text" class="form-control" id="B" name="B" required>
          </div>

          <div class="form-group">
            <label for="C">Point C</label>
            <input type="text" class="form-control" id="C" name="C" required>
          </div>

          <div class="form-group">
            <label for="D">Point D</label>
            <input type="text" class="form-control" id="D" name="D" required>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addFence()">Add Fence</button>
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
    var A = $(this).data('a');
    var B = $(this).data('b');
    var C = $(this).data('c');
    var D = $(this).data('d');
    var classid = $(this).data('classid');

    $('#editId').val(id);
    $('#editA').val(A);
    $('#editB').val(B);
    $('#editC').val(C);
    $('#editD').val(D);
    $('#editClass').val(classid);
  });
});
</script>


<script>
$(document).ready(function() {
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this class?')) {
            $.ajax({
                type: "POST",
                url: "scripts/delete_class.php", // Path to your delete script
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
  function updateFence() {
  $.ajax({
    type: "POST",
    url: "scripts/update_fence.php", // Path to your update script
    data: $("#editClassForm").serialize(),
    dataType: "json",
    success: function(response) {
      // Handle success (e.g., close modal, refresh table)
      $('#editClassModal').modal('hide');
      location.reload(); // Reload the page to see the changes
    },
    error: function() {
      alert('Error updating Class!');
    }
  });
}

</script>
<script>
function addFence() {
  // Example function to handle adding a staff member
  // In practice, you would collect form data and send it to a server-side script (e.g., via AJAX)
  console.log('Adding Class...');
  
  $.ajax({
    type: "POST",
    url: "scripts/add_fence.php",
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