<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href=".">
      <img src="Vista/images/logo-claro.png" alt="E-book" width="auto" height="40">
    </a>

    <!-- V. MÓVILES -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- V. DESKTOP -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="galeria" id="galeria">Géneros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin">Admin</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="nuevo-genero">Añadir Genero</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="contacto" tabindex="-1">Contacto</a>
        </li>
      </ul>

      <!-- BUSCAR -->
      <form class="input-group w-25 mx-3" role="search">
        <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscador de libros" aria-describedby="buscador">
        <button type="submit" class="btn btn-secondary" name="buscador" id="buscador" role="button" aria-label="Buscar">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
          </svg>
        </button>
      </form>

      <!-- LOG Y CUENTA -->
      <li class="nav-item dropdown d-flex justify-content-center align-items-center mx-3" id="usuario">
        <a href="#" role="button" class="nav-link dropdown-toggle mx-2" data-bs-toggle="dropdown">
          <img src="Vista/images/default_avatars/1.png" alt="" width="auto" height="25" id="fotoUsurio">
        </a>
        <ul class="dropdown-menu">
          <!-- pintar en función del usuario -->
          <!-- <a href="#" class="dropdown-item">Comedia</a>
            <a href="#" class="dropdown-item">Policíaca</a> -->
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li><a href="user/logout" class="dropdown-item" id="logOut">Log Out</a></li>
        </ul>
      </li>

      <!-- CARRITO -->
      <button id="cart_icon" class="btn btn-shopCart btn-light mx-3" aria-label="Botón Carrito">

        <a href="carrito" class="text-decoration-none text-black" id="cartIcon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />

          </svg>
          <span class="badge rounded-pill text-bg-primary" id="numeroCarrito">0
          </span>
        </a>

      </button>
      <a href="acceso" class="btn btn-primary mr-4" id="acceder">Acceder</a>
    </div>
  </div>
</nav>