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

<body>

  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <!-- NAVBAR -->
  <?php require_once('Plantillas/navbar_main.php') ?>


  <main class="container py-5">

    <section class="row">
      <div class="d-flex justify-content-between align-items-baseline">
        <h1>Panel de Control</h1>
        <div class="btn-group" role="group" aria-label="Admin panel selector">
          <input type="radio" class="btn-check" name="panel_selector" id="books" checked>
          <label class="btn btn-outline-primary" for="books">Libros</label>

          <input type="radio" class="btn-check" name="panel_selector" id="genres">
          <label class="btn btn-outline-primary" for="genres">Géneros</label>

          <input type="radio" class="btn-check" name="panel_selector" id="users">
          <label class="btn btn-outline-primary" for="users">Usuarios</label>
        </div>
      </div>
    </section>

    <section class="row" id="table">
      <table class="table ">
        <thead>

        </thead>
        <tbody>

        </tbody>
      </table>
    </section>


    <table hidden>
      <tr id="header_template_book">
        <th scope="col">ID</th>
        <th scope="col">Título</th>
        <th scope="col">Autor</th>
        <th scope="col"></th>
      </tr>
      <tr id="header_template_category">
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Descripción</th>
        <th scope="col"></th>
      </tr>
      <tr id="header_template_user">
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">E-Mail</th>
        <th scope="col"></th>
      </tr>
      <tr id="row_template">
        <th scope="row" data-id></th>
        <td data-1></td>
        <td data-2></td>
        <td class="d-flex justify-content-end">
          <div>
            <!-- <button class="btn btn-secondary">button</button> -->
            <button class="btn btn-primary">Eliminar</button>
          </div>
        </td>
      </tr>
    </table>
  </main>


  <!-- FOOTER -->
  <?php require_once('Plantillas/footer_main.php') ?>

  <!-- <script src="./Vista/scripts/app.js"></script> -->
  <script src="./Vista/scripts/administracion.js"></script>
</body>

</html>