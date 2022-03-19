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

  <div class="container">
    <form action="includes/included-register.php" method="post">
    <h1 class="eTitle display-3 text-center my-4">Register</h1>
      <p>Please fill in this form to create an account.</p>
      <?php
        if(isset($_SESSION["message"])){
          echo "<p class='nMessage'>{$_SESSION["message"]}</p>";
          session_unset();
          session_destroy();
        }
      ?>
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
  <button type="submit" name ="register" class="btn btn-secondary">Submit</button>
  <div class="container signin">
      <p>Already have an account? <a href="login.php">Sign in</a>.</p>
    </div>
</form>

  
  </div>

</body>
</html>
