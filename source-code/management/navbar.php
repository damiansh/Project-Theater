<!-- Navbar -->
<div class="container-fluid">
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top black nav-padding">
      <a href="index.php" class="navbar-brand">Los Portales Management Area</a>
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
      <div class="collapse navbar-collapse justify-content-center order" id="toggleMobileMenu">
        <ul class="navbar-nav ms-auto text-center">
          <!-- Navigation bar content if user is logged -->
          <?php if(isset($_SESSION["adminid"])){ ?>
            <li><a  id ="index.php" class="nav-link" href="index.php">Play Management</a></li>
            <li><a  id ="index.php" class="nav-link" href="index.php">Generate Report</a></li>
            <li><a class="nav-link" href='includes/included-logout.php'>Logout</a></li>
   
          <?php 
          } 
          else{

            ?>
           <!-- Navigation bar content if user is not logged -->
          <li><a  id ="login.php" class="nav-link" href="login.php">Login</a></li>
          <?php 
          } 
         ?>            
        </ul>
      </div>

    </nav>
  </div>

<!-- Javascript for Navbar -->
<script>
  //Highlight active page in the navbar
  var path = window.location.pathname;
  var page = path.split("/").pop();
  currentPage = document.getElementById(page);
  if(page ==""){
    currentPage = document.getElementById("index.php");
  }
  currentPage.classList.add("active"); //we add the class active  
</script>
