<div class="container black">
    <nav class="navbar navbar-expand-sm navbar-dark">
      <a href="index.php" class="navbar-brand">Los Portales</a>
      <button
        class="navbar-toggler" 
        type="button"
        data-bs-toggle="collapse" 
        data-bs-target="#toggleMobileMenu" 
        aria-controls="toggleMobileMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="toggleMobileMenu">
        <ul id="navbar" class="navbar-nav ms-auto text-center">


          <?php if(isset($_SESSION["userid"])){ ?>
          <li><a class="nav-link" href="index.php">Home</a></li>
          <li><a class="nav-link" href="#">Tickets</a></li>
          <li><a class='nav-link' href='includes/included-logout.php'>Logout [<?php  echo $_SESSION["userEmail"]; ?>] </a></li>                   
          <?php 
          } 
          else{

            ?>
          <li><a class="nav-link" href="index.php">Home</a></li>
          <li><a class="nav-link" href="#">Tickets</a></li>
          <li><a class="nav-link" href="login.php">Login</a></li>
          <li><a class="nav-link" href="register.php">Register</a></li>
          <?php 
          } 
         ?>            
        </ul>
      </div>

    </nav>
  </div>
