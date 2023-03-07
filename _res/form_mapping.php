<?php

/**
 * Mapeo de los nombres de los campos del formulario a los
 * nombres de las columnas de la base de datos.
 * 
 * nombre_campo_formulario => nombre_columna_tabla
 */

$user_map = [
  TABLE_USERS     => [
    'usuario'           => USER_NICK,
    'email'             => USER_EMAIL
  ],
  TABLE_USER_DATA        => [
    'nombre'            => DATA_NAME,
    'apellidos'         => DATA_SURNAMES,
    'genero'            => DATA_GENDER,
    'fecha_nacimiento'  => DATA_BIRTHDAY,
    'direccion'         => DATA_ADDRESS,
    'pais'              => DATA_COUNTRY
  ],
  TABLE_PASSWORDS  => [
    'password'          => PASSWORD_VALUE,
    'password_1'        => PASSWORD_VALUE
  ]
];

$genre_map = [
  'generos' => [
    'nombre'      => 'nombre',
    'imagen'      => 'imagen',
    'descripcion' => 'descripcion'
  ]
];
