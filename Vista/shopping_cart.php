<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito</title>

  <!-- BOOTSTRAP -->
  <?php require_once('Plantillas/bootstrap.html') ?>

  <!-- CSS -->
  <link rel="stylesheet" href="Vista/styles/style.css">
  <link rel="stylesheet" href="Vista/styles/landing.css">
</head>

<body class="h-100" id="shopping_cart">
  <!-- ACCESSIBILITY BUTTONS -->
  <?php require_once('Plantillas/botones_accesibilidad.html') ?>

  <!-- NAVBAR -->
  <?php require_once('Plantillas/navbar_main.php') ?>

  <!-- Traido de forma dinámica -->
        
        
  <div class="row m-5" id="cards">
    <h1 class="">Carrito</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="d-none d-md-table-cell">Portada</th>
          <th scope="col">Título</th>
          <!-- <th scope="col">Subtítulo</th>
          <th scope="col">Autor</th> -->
          <th scope="col">Formato</th>
          <th scope="col">Idioma</th>
          <th scope="col" class="d-none d-md-table-cell">precio</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Accion</th>
          <th scope="col" class="d-none d-md-table-cell">Total</th>
        </tr>
      </thead>
      <tbody id="items"></tbody>
      <tfoot>
        <tr id="footer">
            
        </tr>
      </tfoot>
    </table>
  </div>
  


    <template id="template-carrito">
      <tr scope="row">
        <td class="d-none d-md-table-cell"><img src=" " alt="Portada del libro" height="200px"></td>
        <td><a href=" " id="nombreLibro"></a></td><!--titulo-->
        <!-- <td></td> --><!--subtitulo-->
        <!-- <td></td>--><!--autor -->
        <td></td><!--formato-->
        <td></td><!--idioma-->
        <td class="d-none d-md-table-cell"></td><!--precio-->
        <td></td><!--cantidad-->
        <td>
            <button id="boton1" class="btn btn-info btn-sm">+</button>
            <button id="boton2" class="btn btn-danger btn-sm">-</button>
        </td>
        <td class="d-none d-md-table-cell"><span></span>€</td><!--total-->
      </tr>
    </template>

    <!-- <div class="row">
      <div class="col-8"> -->
        <template id="template-footer">
          <th scope="row" colspan="2">Total productos</th>
          <td class="d-none d-md-table-cell">10</td>
          <td>
              <button class="btn btn-secondary btn-sm" id="vaciar-carrito">
                  Vaciar todo
              </button>
          </td>
          <td class="font-weight-bold"><span>5000</span>€</td>
          <td class="d-none d-md-table-cell"></td>
          <td class="d-none d-md-table-cell"></td>
          <td>
            <button class="btn btn-primary btn-sm" id="btnComprar" data-bs-toggle="modal" data-bs-target="#compra">
              Comprar
            </button>
          </td>
        </template>
      <!-- </div>
      <div class="col-4">
        <button class="btn btn-primary btn-sm" id="comprar">
          Comprar
        </button>
      </div>
    </div> -->

<!-- Modal -->
<div class="modal fade" id="compra" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <!-- FOOTER -->
    <?php require_once('Plantillas/footer_main.php') ?>
    <!-- <script src="./Vista/scripts/shopCart.js"></script> -->


</body>

</html>