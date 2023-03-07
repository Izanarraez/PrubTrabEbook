
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- BOOTSTRAP -->
  <?php require_once('Plantillas/bootstrap.html') ?>

  <!-- CSS -->
  <link rel="stylesheet" href="Vista/styles/style.css">
  <link rel="stylesheet" href="Vista/styles/landing.css">
</head>

<body id="logado">

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <main class="container">
    <div class="row">

      <article class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <section id="botones" class="text-center d-flex justify-content-between">
          <button class="btn btn-outline-primary" style="width:45%" id="form_login">
            Acceder
          </button>
          <button class="btn btn-outline-primary" style="width:45%" id="form_registro">
            Registrarse
          </button>
        </section>

        <!-- FORM -->
        <div id="formulario" class="px-5 py-4 my-3 shadow-sm card"></div>
      </article>
    </div>
  </main>

  <script src="Vista/scripts/page_acceso.js"></script>
  <script src="Vista/scripts/app.js"></script>
  <script src="Vista/scripts/funciones.js"></script>
  <script src="Vista/scripts/crud.js"></script>
</body>

</html>