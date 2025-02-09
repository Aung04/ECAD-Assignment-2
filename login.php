<!--Done by Vin Hee-->
<head>
    <script src="https://kit.fontawesome.com/624113c1c9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

<?php
include("navbar.php");
?>

<div class="container-fluid ps-md-0">
  <div class="row g-0 justify-content-center">
    <div class="col-md-8 col-lg-6 mx-auto">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4 text-center">Welcome back!</h3>

              <!-- Sign In Form -->
              <form name="login" action="checkLogin.php" method="post">
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="userEmail">
                  <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="userPassword">
                  <label for="floatingPassword">Password</label>
                </div>

                <div class="d-grid">
                  <button class="btn btn-lg btn-login fw-bold mb-2" style="background-color: #352F44; color: white;" type="submit">SIGN IN</button>
                  <div class="text-center">
                    <p class="small">Don't have an account? Sign up <a href="register.php"> here! </a></p>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>


<?php
include("footer.php");
?>

