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

<body class="h-100" id="pagina-de-galeria">

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <!-- NAVBAR -->
  <?php require_once('Plantillas/navbar_main.php') ?>

  <!-- <script>
    var request = new XMLHttpRequest();
    request.open("GET", `Control/Interfaz.php`);
    request.onerror = (e) => console.error(request.statusText);
  </script> -->

  <!-- Trae los elementos de forma dinámica -->
  <main class="m-0">
    <div class="container-fluid px-5">
      <div class="row">
        <h1 class="m-3">Géneros</h1>
      </div>
      <div class="row d-flex justify-content-center" id="generos">
        
        
        <button class="btn" id="verMasGaleria">Ver más</button>
      </div>
    </div>
  </main>
    <!-- FOOTER -->
    <?php require_once('Plantillas/footer_main.php') ?>
  <!-- <script src="./Vista/scripts/app.js"></script>
  <script src="./Vista/scripts/crud.js"></script> -->
  <!-- <script src="./Vista/scripts/mostrarGaleria.js"></script> -->
</body>

</html>