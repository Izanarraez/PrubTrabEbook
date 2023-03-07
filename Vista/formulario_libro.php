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

  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="Vista/multiselect-master/css/style.css">
  <script src="Vista/multiselect-master/js/index.js"></script> -->
  <script src="./Vista/scripts/formulario_libro.js"></script>

</head>

<body>

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <main class="container">
    <div class="row">
      <form id="traer_libro">
        <legend class="col fs-2 m-4">Cargar datos de un libro</legend>
        <div class="row">
          <span class="col">Traer un libro de la base de datos.</span>
          <div class="col input-group mb-3">
            <label for="titulo" class="input-group-text">ID</label>
            <input type="text" class="form-control" name="id_libro" id="id_libro">
            <button type="submit" class="btn btn-outline-secondary">Cargar</button>
          </div>
        </div>
      </form>

      <form id="book_form" data-form-book method="POST" enctype="multipart/form-data">
        <input type="text" name="id" id="id" hidden>
        <!-- BOOK BASIC INFO -->
        <fieldset class="mb-3" data-book>
          <legend class="col fs-2 m-4">Añadir libro</legend>

          <div class="input-group mb-3">
            <label for="titulo" class="input-group-text">Título </label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" required>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="subtitulo" id="subtitulo" placeholder="Subtítulo">
            <label for="subtitulo" class="input-group-text">Subtítulo </label>
          </div>

          <div class="row mb-3">
            <div class="input-group col">
              <label for="autor" class="input-group-text">Autor/a</label>
              <input type="text" class="form-control" name="autor" id="autor" placeholder="" required>
            </div>
            <div class="input-group col">
              <label for="genero" class="input-group-text">Género</label>
              <select name="genero" id="genero" class="form-select" required> </select>
            </div>
          </div>

          <label for="resumen" class="form-label d-none">Resumen </label>
          <textarea rows="5" class="form-control" cols="" name="resumen" id="resumen" placeholder="Resumen" required></textarea>

          <button type="submit" hidden></button>
        </fieldset>

      </form>

      <section id="files"></section>

      <section class="d-flex justify-content-between">
        <button id="add_file_button" class="btn btn-secondary">Añadir Archivo</button>
        <div>
          <button id="reset_button" class="btn btn-secondary">Reset</button>
          <button id="submit_button" class="btn btn-primary">Enviar</button>
        </div>
      </section>

    </div>
  </main>

  <option id="option_template" value="" hidden></option>

  <form id="file_template" data-form-file data-file="0" hidden>
    <hr class="mb-3">
    <div class="row">
      <div class="col-9">

        <input type="text" name="id" id="id" hidden>
        <div class="input-group mb-3">
          <label for="titulo" class="input-group-text">Título </label>
          <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" required>
        </div>

        <div class="col input-group mb-3">
          <label for="archivo" class="input-group-text">Libro </label>
          <input type="file" accept=".epub, .pdf, .movi, .mp3" class="form-control" name="archivo" id="archivo" onchange="updateFormat(event)" required>
          <input type=" text" name="formato" value="" readonly class="input-group-text">
        </div>
        <div class="col input-group mb-3">
          <label for="portada" class="input-group-text">Portada </label>
          <input type="file" accept="image/jpeg, .jpg, .png" class="form-control" name="portada" id="portada" onchange="showImage(event)">
        </div>

        <div class="row mb-3">
          <div class="col input-group">
            <label for="idioma" class="input-group-text">Idioma</label>
            <select name="idioma" id="idioma" class="form-select"> </select>
          </div>

          <div class="col input-group">
            <label for="precio" class="input-group-text">Precio</label>
            <input type="number" step="any" class="form-control" name="precio" id="precio" placeholder="Precio">
            <span class="input-group-text">€</span>
          </div>

          <div class="col input-group">
            <label for="isbn" class="input-group-text">ISBN </label>
            <input type="number" class="form-control" minlength="0" name="isbn" id="isbn" placeholder="ISBN">
          </div>
        </div>
        <button type="submit" hidden></button>
      </div>

      <div class="col">
        <img id="show_image" src="#" alt="no image" class="img-fluid book-cover" />
      </div>
    </div>
  </form>


  <!-- FOOTER -->
  <?php require_once('Plantillas/footer_main.php') ?>

  <!-- <script src="./Vista/scripts/app.js"></script>
  <script src="./Vista/scripts/crud.js"></script> -->
</body>

</html>