<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
               
                <form action="register.php" method="post" id="registrationForm">
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
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
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
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function(){
      $("#loginForm").submit(function(event){
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