<?php

require_once('Control/Validation.php');
require_once('Modelo/Modelo.php');
require_once('Modelo/User.php');

class UserAPI {

  private Modelo $model;

  function __construct() {
    $this->model = new Modelo();
  }

  /** 
   * Registers a new user into the database.
   * Tries to register a new user into the application.
   * Should the registration be successful, the user will be automatically
   * logged in.
   * @param array $raw_data Data from the form.
   * @return JSON containing the registration info.
   */
  public function register(array $raw_data) {
    $data     = parse('user', $raw_data);
    $errors   = (new DataValidator($this->model))->validarRegistro($data);
    $success  = sizeof($errors) == 0;

    // INSERCIÓN EN BASE DE DATOS
    if ($success) :
      // Re-parse data for insertion & create user
      $data = parse('user', $raw_data, true);
      $user = new User($data[TABLE_USERS][USER_EMAIL]);

      // Insert data into database
      // TODO error failsafe
      $this->model->insert(TABLE_USERS,     $data[TABLE_USERS]);
      $this->model->insert(TABLE_PASSWORDS, array_merge([PASSWORD_ID  => $user->getId()], $data[TABLE_PASSWORDS]));
      $this->model->insert(TABLE_USER_DATA, array_merge([DATA_ID      => $user->getId()], $data[TABLE_USER_DATA]));

      // Login user
      $_SESSION['user'] = $user;
      $_SESSION['auth'] = $_SESSION['user']->auth();
      $login = array('auth' => $_SESSION['auth'], 'user' => $_SESSION['user']->getData());
    endif;

    // Message construction
    $message = array('success' => $success);
    if (isset($login))  $message = array_merge($message, array('login'  => $login));
    if (!$success)      $message = array_merge($message, array('errors' => parse('user', $errors, false, true)));

    return json_encode($message);
  }

  // TODO
  /** Deletes a user from the database. */
  public function delete(string $id) {
  }

  // TODO
  /** Updates the info of the current user. */
  public function update(array $raw_data) {
  }


  /** 
   * Tries to log an user.
   * @return JSON containing the log info.
   */
  public function login(array $raw_data) {
    $data     = parse('user', $raw_data);
    $errors   = (new DataValidator($this->model))->validate_login($data);
    $success  = sizeof($errors) == 0;

    if ($success) :
      $_SESSION['user'] = new User($data[USER_EMAIL]);
      $_SESSION['auth'] = $_SESSION['user']->auth();
      $login = array('auth' => $_SESSION['auth'], 'user' => $_SESSION['user']->getData());
    endif;

    // Message construction
    $message = array('success' => $success);
    if (isset($login))  $message = array_merge($message, array('login'  => $login));
    if (!$success)      $message = array_merge($message, array('errors' => $errors));

    return json_encode($message);
  }

  /** Logs out the user. */
  public function logout() {
    if (isset($_SESSION['user'])) unset($_SESSION['user']);
    if (isset($_SESSION['auth'])) unset($_SESSION['auth']);
  }

  public function search() {
    return json_encode((new Modelo())->select(TABLE_USERS));
  }


  /**
   * Checks if the authentication token matches the one in the server.
   */
  public static function checkLog(array $raw_data) {
    $auth = isset($raw_data['auth']) ? $raw_data['auth'] : '';
    return json_encode(array('isLogged' => $_SESSION['auth'] == $auth));
  }



  // /**
  //  * Parses an associative array to the user database column names.
  //  * The old keys of the array are changed while the stored values
  //  * remain the same.
  //  * 
  //  * @param array $raw_data The associative array to parse.
  //  * @param array $separate_by_map Separates the values parsed by each map into different arrays.
  //  * @param array $reverse Parses database names to form names.
  //  * @return array Parsed array compliant with the database.
  //  */
  // public function parse(array $raw_data, bool $separate_by_map = false, bool $reverse = false) {
  //   // ? Is this line really needed...?
  //   if ($raw_data == null) return null;

  //   require('_res/form_mapping.php');
  //   $mapped_data = [];

  //   foreach ($user_map as $map_name => $map) :
  //     foreach ($raw_data as $key => $value) :

  //       // Maps the keys of the map to the values.
  //       if (!$reverse && isset($map[$key])) :
  //         if ($separate_by_map) // Values are separated by map.
  //           $mapped_data[$map_name][$map[$key]] = $value;
  //         else                  // Values are stored at 'root' level
  //           $mapped_data[$map[$key]]            = $value;

  //       // Maps the values of the map to the keys.
  //       elseif ($reverse && $form_key = array_search($key, $map)) :
  //         $mapped_data[$form_key]  = $value;
  //       endif;

  //     endforeach;
  //   endforeach;

  //   return $mapped_data;
  // }
}
