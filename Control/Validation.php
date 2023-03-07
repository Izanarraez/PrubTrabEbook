<?php

class DataValidator {
  private Modelo $modelo;

  // TODO:
  private $regex = [
    USER_NICK      => '/^[\p{L}\d_-]{3,20}$/u',
    DATA_NAME      => '/^(?=.{2,60}$)\p{L}*(\s\p{L}*)?$/u',
    DATA_SURNAMES   => '/^(?=.{2,60}$)\p{L}*(\s\p{L}*)?$/u',
    USER_EMAIL      => '/.{1,}/',
    PASSWORD_VALUE  => '/.{1,}/',
  ];

  // TODO:
  private $mensajes_registro = [
    USER_NICK       => 'El nombre de usuario tiene que tener entre 3 y 20 caracteres.',
    DATA_NAME       => 'El nombre solo puede contener letras, un máximo de dos palabras y 60 caracteres.',
    DATA_SURNAMES   => 'Los apellidos solo puede contener letras, un máximo de dos palabras y 60 caracteres.',
    USER_EMAIL      => 'Email no valido.',
    PASSWORD_VALUE  => 'Contraseña no válida',
    PASSWORD_VALUE  => 'Contraseña no válida',
  ];

  public function __construct(Modelo $modelo) {
    $this->modelo = $modelo;
  }

  public function validarRegistro($data) {
    $errors = [];
    foreach ($data as $key => $value) :
      // Si no existe regex para esto, pasamos al siguiente dato.
      if (!isset($this->regex[$key]))
        continue;

      // Si el regex da bien, pasamos al siguiente dato.
      if (preg_match($this->regex[$key], $value) == 1)
        continue;

      // El regex ha dado negativo o error, añadimos el mensaje de error al array.
      if (isset($this->mensajes_registro[$key]))
        $errors = array_merge($errors, array($key => $this->mensajes_registro[$key]));

      else
        array_push($errors, "Ha ocurrido un error en el campo '$key'.");
    endforeach;

    // Validar el email.
    if (isset($data[USER_EMAIL])) :
      if (!$this->validate_email($data[USER_EMAIL])) :
        $errors = array_merge($errors, array(USER_EMAIL => "Mail ya existente."));
      endif;
    endif;

    return $errors;
  }

  private function validate_email($email) {
    return sizeof($this->modelo->select(TABLE_USERS, USER_EMAIL . "=?", array($email))) == 0;
  }

  /**
   * Checks if the login information is correct.
   * @return array Errors. Will be empty if all goes well.
   */
  public function validate_login($data) {
    if (!isset($data[USER_EMAIL]) && !isset($data[PASSWORD_VALUE]))
      return ['Error traduciendo los datos del formulario.'];

    else if ($this->modelo->checkLogin($data[USER_EMAIL], $data[PASSWORD_VALUE]))
      return [];

    else
      return ["Credenciales incorrectas"];
  }

  public function validate_genre($data) {
    if (!isset($data['nombre']))
      return ['El nombre es obligatorio.'];

    // ! ?
    else if (!$this->modelo->select('generos', 'nombre=?', array($data['nombre'])))
      return [];

    else
      return ["Género ya existente."];
  }
}

/**
 * Parses an associative array to the user database column names.
 * The old keys of the array are changed while the stored values
 * remain the same.
 * 
 * @param array $raw_data The associative array to parse.
 * @param array $separate_by_map Separates the values parsed by each map into different arrays.
 * @param array $reverse Parses database names to form names.
 * @return array Parsed array compliant with the database.
 */
function parse(string $map, array $raw_data, bool $separate_by_map = false, bool $reverse = false) {
  // ? Is this line really needed...?
  if ($raw_data == null) return null;

  require('_res/form_mapping.php');
  $mapped_data = [];
  $map .= '_map';

  foreach ($$map as $map_name => $map) :
    foreach ($raw_data as $key => $value) :

      // Maps the keys of the map to the values.
      if (!$reverse && isset($map[$key])) :
        if ($separate_by_map) // Values are separated by map.
          $mapped_data[$map_name][$map[$key]] = $value;
        else                  // Values are stored at 'root' level
          $mapped_data[$map[$key]]            = $value;

      // Maps the values of the map to the keys.
      elseif ($reverse && $form_key = array_search($key, $map)) :
        $mapped_data[$form_key]  = $value;
      endif;

    endforeach;
  endforeach;

  return $mapped_data;
}
