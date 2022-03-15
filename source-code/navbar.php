<div class="container black">
    <nav class="navbar navbar-expand-sm navbar-dark">
      <a href="#" class="navbar-brand">Los Portales</a>
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
          <li><a class="nav-link" href="index.php">Home</a></li>
          <li><a class="nav-link" href="#">Tickets</a></li>
          <script>
            //construct other options dynamically, probably to later to integrate with login system
            var liElement = [{name:"Sign-in", url:"login.php"},{name:"Register", url:"register.php"}]
            navBar = document.getElementById("navbar");
            navConstructor(liElement,navBar);
          </script>

        </ul>
      </div>

    </nav>
  </div>
