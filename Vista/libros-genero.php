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

<body class="h-100" id="libros-genero">

<!-- ACCESSIBILITY BUTTONS -->
<?php require_once('Plantillas/botones_accesibilidad.html') ?>

<!-- NAVBAR -->
<?php require_once('Plantillas/navbar_main.php') ?>

<!-- <script>
    var request = new XMLHttpRequest();
    request.open("GET", `Control/Interfaz.php`);
    request.onerror = (e) => console.error(request.statusText);
  </script> -->

  <!-- TODO Traer de forma dinámica -->
  <main>
    <div class="container-fluid p-5">
      <div class="row">
        <h1 class="m-3">Género</h1>
      </div>
      <div class="row d-flex justify-content-around" id="libros">
          
      </div>
    </div>
  </main>
    <!-- FOOTER -->
    <?php require_once('Plantillas/footer_main.php') ?>
    <!-- <script src="./Vista/scripts/app.js"></script>
    <script src="./Vista/scripts/crud.js"></script> -->
  
</body>

</html>