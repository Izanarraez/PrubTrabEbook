<?php

class User {
  public $mail;
  public $data;

  public function __construct($mail) {
    $this->setMail($mail);
    $this->loadData();
  }

  public function getMail() {
    return $this->mail;
  }

  public function getID() {
    return (new Modelo())->select(
      TABLE_USERS,
      'correo=?',
      array($this->mail)
    )[0][USER_ID];
  }

  public function getData() {
    if ($this->data == null) $this->loadData();
    return $this->data;
  }

  public function setMail($mail) {
    $this->mail = $mail;
  }

  public function loadData() {
    try {
      $this->data = (new Modelo())->getUser($this->mail);
    } catch (\Throwable $th) {
      $this->data = null;
    }
  }


  /**
   * Generates a new authentication token. 
   * @return string Auth token. 
   * */
  public function auth() {
    return base64_encode(json_encode(get_object_vars($this)) . time());
  }
}
