<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ebook Store</title>

  <!-- BOOTSTRAP -->
  <?php require_once('Plantillas/bootstrap.html') ?>

  <!-- CSS -->
  <link rel="stylesheet" href="Vista/styles/style.css">
  <link rel="stylesheet" href="Vista/styles/landing.css">
</head>

<body class="h-100" id="libro">

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <!-- NAVBAR -->
  <?php require_once('Plantillas/navbar_main.php') ?>

  <!-- Traido de forma dinámica -->
  <main class="container d-flex justify-content-center mt-4">
    <div class="row" id="mostrarLibro">
      <h1 class="col-12">Titulo del libro</h1>
      <h2 class="col-12">Subtítulo del libro</h2>
      <div class="col-12 col-md-5">
        <img class="w-75 p-4" src="Vista/images/Modelo/ModeloLibro.jpg" alt="Imagen del libro">
      </div>
      <div class="col-12 col-md-6">
        <h3 class="fs-4">Autor</h3>
        <p>Pepe del Rio</p>
        <h3 class="fs-4">Sinopsis</h3>
        <p class="mb-2">Descripción del libro</p>
        <form action="" method="POST" class="d-flex justify-content-around mb-3">
          <fieldset class="row">
            <legend class="fs-4">Formato</legend>

          </fieldset>
          <fieldset class="row">
            <legend class="fs-4">Idioma</legend>
            <select name="idioma" id="idioma" class="form-select" aria-label="idioma" required>

            </select>
          </fieldset>
        </form>
        <h3 class="fs-4">Precio</h3>
        <p id="precioLibro">12,4€</p>
        <button id="addCart" class="btn btn-primary">Añadir al carrito</button>
      </div>
    </div>
    <script src="Vista/scripts/animacion.js"></script>
  </main>

  <!-- FOOTER -->
  <?php require_once('Plantillas/footer_main.php') ?>
  <!-- <script src="./Vista/scripts/app.js"></script>
    <script src="./Vista/scripts/crud.js"></script>
    <script src="./Vista/scripts/shopCart.js"></script> -->
</body>

</html>