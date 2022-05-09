<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <?php include 'dependencies.php';
    if(isset($_SESSION["userid"])) 
      header("location: index.php");
  ?>
  
</head>
<body>

<?php include 'navbar.php';?>
<div class="topImg" style="background-image:url('images/registration.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle">Join Los Portales Theatre!</h1>
    </div>
</div>

  <div class="container">
  <form action="login.php" method="post">
          <h3 class="league display-4 text-center my-4">Already a member?</h3>
            <div class="d-grid gap-2">
              <button type="submit" name="register"  class="btn btn-secondary">Login!</button>
            </div>
        </form>
        <form action="includes/included-register.php" method="post">
            <h1 class="league display-3 text-center my-4">Registration Form:</h1>
              <h5>Please fill in this form to create an account.</h3>
              <hr>
          <div class="mb-3">
            <label for="email" class="form-label">Email address:</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" >
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="psw" class="form-label">Password:</label>
            <input type="password" placeholder="Enter Password"  class="form-control"  name="psw" id="psw" >
          </div>
          <div class="mb-3">
            <label for="psw-repeat" class="form-label">Confirm Password:</label>
            <input type="password" placeholder="Enter again your password"  class="form-control"  name="psw-repeat" id="psw-repeat" >
          </div>

          <div class="mb-3">
            <label for="fname" class="form-label">First name:</label>
            <input type="text" placeholder="Enter your first name"  class="form-control"  name="fname" id="fname" >
          </div>
          <div class="mb-3">
            <label for="lname" class="form-label">Last name:</label>
            <input type="text" placeholder="Enter your last name"  class="form-control"  name="lname" id="lname" >
          </div>
          <div class="mb-3">
            <label for="birthday" class="form-label">Date of Birth:</label>
            <input type="date" placeholder="Enter your date of birth"  class="form-control"  name="birthday" id="date" >
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number:</label>
            <input type="tel" placeholder="Enter your phone number"  class="form-control"  name="phone" id="phone" >
          </div>
          <div class="d-grid gap-2">
              <button type="submit" name="register"  class="btn btn-secondary btn-lg">Join</button>
            </div>
      
        </form>

  </div>
<br>
<?php include "notification.php"?>
<?php include 'footer.php';?>

</body>
</html>
