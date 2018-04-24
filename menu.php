    <div class="menu">
      <img id="logoCabecalho" src="img/logo.png">

      <button class="dropdown-btn">Satélites
        <i class="fa fa-caret-down"><span>+</span></i>
      </button>
      <div class="dropdown-container">
        <a href="#">GEO</a>
        <a href="#">MEO</a>
        <a href="#">LEO</a>
      </div>
      <a href="#">O meu Perfil</a>
      <a href="#">Contactos</a>
      <a href="logout.php">Logout</a>
     
     
    </div>
  <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
  </script>

