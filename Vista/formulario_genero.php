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

<body>

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <main class="container">
    <div class="row">
      <form action="category/add" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend>Añadir género</legend>

          <div class="col">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre </label>
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
              <label for="imagen" class="form-label">Imagen </label>
              <input type="file" accept="image/jpeg, .jpg, .png" class="form-control" name="imagen" id="imagen" placeholder="Imagen" required>
            </div>
          </div>

          <div class="col">
            <div class="col mb-3">
              <label for="descripcion" class="form-label">Descripción/a</label>
              <textarea rows="5" class="form-control" cols="" name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
            </div>
          </div>

        </fieldset>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
    </fieldset>
    </form>
    </div>
  </main>

  <!-- FOOTER -->
    <?php require_once('Plantillas/footer_main.php') ?>

  <!-- <script src="./Vista/scripts/app.js"></script>
  <script src="./Vista/scripts/crud.js"></script> -->
</body>

</html>