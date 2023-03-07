<?php

// CREDENCIALES BASE DE DATOS
define('DB_HOSTNAME', 'localhost'  );
define('DB_USERNAME', 'ebook-admin');
define('DB_PASSWORD', 'ebook'      );
define('DB_DATABASE', 'ebook'      );


// TABLAS BASE DE DATOS
define('TABLE_USERS'      , 'usuarios' );
define('TABLE_USER_DATA'  , 'datos'    );
define('TABLE_PASSWORDS'  , 'passwords');
define('TABLE_TYPES'      , 'tipos'    );

define('TABLE_BOOKS'      , 'libros'    );


// COLUMNAS TABLA USUARIOS
define('USER_ID'      , 'id'     );
define('USER_NICK'    , 'usuario');
define('USER_EMAIL'   , 'correo' );
define('USER_TYPE'    , 'tipo'   );
define('USER_AVATAR'  , 'foto'   );

// COLUMNAS TABLA DATOS
define('DATA_ID'          , 'id_usuario'      );
define('DATA_NAME'        , 'nombre'          );
define('DATA_SURNAMES'    , 'apellidos'       );
define('DATA_GENDER'      , 'genero'          );
define('DATA_BIRTHDAY'    , 'fecha_nacimiento');
define('DATA_ADDRESS'     , 'direccion'       );
define('DATA_COUNTRY'     , 'pais'            );
define('DATA_CREDIT_CARD' , 'tarjeta'         );

// COLUMNAS TABA TIPOS
define('TYPE_ID'    , 'codigo');
define('TYPE_NAME', 'nombre');

// COLUMNAS TABLA CONTRASEÑAS
define('PASSWORD_ID'    , 'id_usuario');
define('PASSWORD_VALUE' , 'password'  );

