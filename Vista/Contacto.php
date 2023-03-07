<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pagina de contacto Ebook Store</title>
        <!-- BOOTSTRAP -->
        <?php require_once('Plantillas/bootstrap.html') ?>

        <!-- CSS -->
        <link rel="stylesheet" href="Vista/styles/style.css">
        <link rel="stylesheet" href="Vista/styles/landing.css">
    </head>

    <body class="bg-ownDark h-100" id="contacto">
        <!-- ACCESSIBILITY BUTTONS -->
        <?php require_once('Plantillas/botones_accesibilidad.html') ?>

        <!-- NAVBAR -->
        <?php require_once('Plantillas/navbar_main.php') ?>

        <h1 class="d-none text-white">Contacto eBook</h1>
        <!--Cuerpo central de contacto-->
        <main  class="container-fluid p-5"><!--Contenedor de contacto principal-->
            <div class="row m-md-5">
                <div class="col-12 col-md-4 bg-white p-4"><!--Informacion de tienda-->
                    <div class="row">
                        <h2 class="fs-3 text-center m-4">Informacion</h2>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-3 text-end"> <!--Svg de telefono-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                        </div>
                        <div class="col-9">
                            <h3 class="fs-5">Numero telefono:</h3>
                            <p>666 666 666</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-3 text-end"> <!--Svg de correo-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg>
                        </div>
                        <div class="col-9">
                            <h3 class="fs-5">Correo:</h3>
                            <p>ebook.soporte@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 bg-secondary p-4"><!--Formulario de contacto-->
                    <div class="row">
                        <h2 class="fs-3 text-center text-white m-3">Contacta con nosotros</h2>
                    </div>
                    <div class="row px-4">
                        <form action="#" method="POST" class="col text-end mx-5"> <!--action-->
                            <div class="input-group">
                                <!--  Nombre del contacto -->
                                <input type="text" class="form-control m-2 rounded-0" aria-label="Nombre contacto" id="nombre_contacto" placeholder="Nombre">
                                
                                <!-- Apellidos de contacto -->
                                <input type="text" class="form-control m-2 rounded-0" aria-label="Apellidos contacto" id="apellidos_contacto" placeholder="Apellidos" >
                            </div>
                            <div class="input-group">
                                <!-- Correo para contacto -->
                                <input type="text" class="form-control m-2 rounded-0" aria-label="Correo contacto" id="email_contacto" placeholder="Correo"> 
                            </div>
                            <div class="input-group">
                                <!-- Decripcion de contacto -->
                                <textarea class="form-control m-2 rounded-0" aria-label="Descripcion contacto" id="descripcion_contacto" placeholder="Descripcion"></textarea>
                            </div>
                            <button type="submit" aria-label="Enviar formulario" class="btn btn-primary m-2">Enviar</button><!--Boton de contacto-->
                        </form>
                    </div>
                </div>
            </div>
        </main>
            <!-- FOOTER -->
            <?php require_once('Plantillas/footer_main.php') ?>
<!--         
        <script src="./Vista/scripts/app.js"></script>
        <script src="./Vista/scripts/crud.js"></script> -->
    </body>

</html>