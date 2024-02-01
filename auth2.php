<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="auth.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="login logo.png" width="380" alt="">
                </a>
               
                <form action="" method="post" id="registrationForm">
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                 </div>
                 
                 <div class="form-row">

                <div class="form-group  col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group  col-md-6">
                    <label for="email">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                </div>
                </div>

                <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<script>
    $(document).ready(function(){
      $("#registrationForm").submit(function(event){
        event.preventDefault(); // Prevent the form from submitting via the browser.

        $.ajax({
          type: "POST",
          url: "scripts/register.php", // The PHP file that processes the login logic.
          data: $(this).serialize(), // Serializes the form's elements.
          success: function(data) {
            if(data.status == 'success') {
              // Redirect to a logged-in page or update UI accordingly.
              window.location.href = '../auth.php';
            } else {
              // Show an error message
              alert(data.message);
            }
          }
        });
      });
    });
</script>


</body>

</html>