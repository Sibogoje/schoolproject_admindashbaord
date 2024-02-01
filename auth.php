<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
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
               
                <form id="loginForm">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp">
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                      Remember this Device
                    </label>
                  </div>
                  <a class="text-primary fw-bold" href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-warning w-100 py-2 fs-4 mb-4 rounded-2">Sign In</button>
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
          url: "scripts/login.php", // The PHP file that processes the login logic.
          data: $(this).serialize(), // Serializes the form's elements.
          success: function(response) {
            if(response.status == 'success') {
              // Redirect to a logged-in page or update UI accordingly.
              window.location.href = 'index.php';
            } else {
              // Show an error message
              alert(response.message);
            }
          }
        });
      });
    });
</script>


</body>

</html>