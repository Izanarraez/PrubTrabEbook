<h1 class="text-center" id="title">Acceso a Cuenta</h1>

<form action="" method="POST" id="formulario_login" name="formulario_login" aria-label="Formulario para darse de alta en la tienda.">
  <!-- <form action="index.php" method="POST" id="formulario_login" name="formulario_login" aria-label="Formulario para darse de alta en la tienda."> -->
  <!-- EMAIL -->
  <fieldset>
    <legend class="d-none">E-mail</legend>
    <div class=" input-group">
      <label for="email" class="d-none"> E-mail (Obligatorio)</label>
      <input type="email" name="email" id="email" placeholder="E-mail" class="form-control" required>
    </div>

    <!-- NAME & SURNAME ALERT -->
    <p id="email_alert" class="text-danger">
  </fieldset>

  <!-- PASSWORD -->
  <fieldset>
    <legend class="d-none">Contraseña</legend>
    <div class=" input-group">
      <label for="password_1" class="d-none"> Contraseña (Obligatorio)</label>
      <input type="password" name="password_1" id="password_1" placeholder="Contraseña" class="form-control" required>
    </div>

    <!-- PASSWORD ALERTS -->
    <div id="password_alerts" class="my-3 text-danger"></div>
    <div id="password_alert_match" class="my-3 text-danger"></div>
  </fieldset>

  <!-- SUBMIT -->
  <section class="d-flex justify-content-between">
    <button type="submit" aria-label="Enviar formulario" class="btn btn-primary" id="registro">
      Enviar formulario</button>
    <input type="reset" value="Resetear valores" aria-label="Resetear los valores del formulario" class="btn btn-secondary">
  </section>

  <section class="my-3">
    <p id="submit_alert" class="text-success"></p>
  </section>
</form>