<?php

class Book {
  private $id;
  private $book_data;
  private $authors;
  private $genres;
  private $file_data;

  public function __construct($id = null) {
    if ($id != null) :
      $this->setID($id);
      $this->loadData(false);
    endif;
  }

  public function getID() {
    return $this->id;
  }

  public function getData() {
    // if ($this->book_data == null || $this->file_data == null) $this->loadData();
    return array_merge(
      $this->book_data,
      array("autores"   => $this->authors),
      array("generos"   => $this->genres),
      array("archivos"  => $this->file_data)
    );
  }

  public function setID($id) {
    $this->id = $id;
  }

  public function insert(array $book, array $raw_files) {
    $crud = new Modelo();
    $this->book_data  = array("titulo" => $book['titulo'], "subtitulo" => $book['subtitulo'], "resumen" => $book['resumen']);
    $this->authors    = $crud->select('autores', 'nombre=?', array($book['autor'])) ?: array($book['autor']);
    $this->genres     = $crud->select('generos', 'nombre=?', array($book['genero']));

    $this->file_data  = null;
    $files            = [];
    $i                = 0;

    while (isset($book["file"][$i])) :
      $book_file   = isset($raw_files["archivo_$i"]) ? $raw_files["archivo_$i"]['tmp_name'] : "";
      $cover_file  = isset($raw_files["portada_$i"]) ? $raw_files["portada_$i"]['tmp_name'] : "";

      $book_file   = $book_file != "" ? file_get_contents($book_file) : null;
      $cover_file  = $cover_file != "" ? file_get_contents($cover_file) : null;

      $file = array_merge($book["file"][$i++], array("archivo" => $book_file), array("portada" => $cover_file));
      array_push($files, $file);
    endwhile;

    // Datos libro
    $crud->insert('libros', $this->book_data);

    $this->id = $crud->select(
      'libros',
      'titulo=? AND subtitulo=? AND resumen=?',
      array($book['titulo'], $book['subtitulo'], $book['resumen'])
    )[0]['id'];

    echo 'id = ' . $this->id;

    // Autores
    if (isset($this->authors[0]['id'])) :
      $crud->insert('libros_autores', array('id_libro' => $this->id, 'id_autor' => $this->authors[0]['id']));
    else :
      $crud->insert('autores', array('nombre' => $this->authors[0]));
      $id_autor = $crud->select('autores', 'nombre=?', array($this->authors[0]))[0]['id'];
      $crud->insert('libros_autores', array('id_libro' => $this->id, 'id_autor' => $id_autor));
    endif;

    // Géneros
    $crud->insert('libros_generos', array(
      'id_libro' => $this->id,
      'id_genero' => $this->genres[0]['id']
    ));

    // Archivos
    foreach ($files as $file) :
      $crud->insert('libros_formatos_idiomas', array(
        'id_libro'    => $this->id,
        'id_formato'  => $file['formato'] != "" ? $file['formato'] : null,
        'id_idioma'   => 'EN',
        'titulo'      => $file['titulo'],
        'archivo'     => $file['archivo'],
        'portada'     => $file['portada'],
        'isbn'        => $file['isbn'],
        'precio'      => $file['precio']
      ));
    endforeach;
  }

  public function update(array $new_book, array $raw_files) {
    $crud = new Modelo();
    $this->book_data  = array(
      "id"        => $this->id,
      "titulo"    => $new_book['titulo'],
      "subtitulo" => $new_book['subtitulo'],
      "resumen"   => $new_book['resumen']
    );
    $this->authors    = $crud->select('autores', 'nombre=?', array($new_book['autor'])) ?: array($new_book['autor']);
    $this->genres     = $crud->select('generos', 'nombre=?', array($new_book['genero']));

    $this->file_data  = null;
    $files            = [];
    $i                = 0;

    while (isset($new_book["file"][$i])) :
      $book   = isset($raw_files["archivo_$i"]) ? $raw_files["archivo_$i"]['tmp_name'] : "";
      $cover  = isset($raw_files["portada_$i"]) ? $raw_files["portada_$i"]['tmp_name'] : "";

      // var_dump($files["archivo_$i"]['tmp_name']);

      $book   = $book != "" ? file_get_contents($book) : null;
      $cover  = $cover != "" ? file_get_contents($cover) : null;

      $file = array_merge(
        $new_book["file"][$i],
        array("archivo" => $book),
        array("portada" => $cover)
      );

      array_push($files, $file);
      $i++;
    endwhile;


    // Datos libro
    $crud->update('libros', $this->book_data, 'id');

    // Autores
    if (isset($this->authors[0]['id'])) :
      $crud->update('libros_autores', array('id_libro' => $this->id, 'id_autor' => $this->authors[0]['id']), 'id_libro');
    else :
      $crud->insert('autores', array('nombre' => $this->authors[0]));
      $id_autor = $crud->select('autores', 'nombre=?', array($this->authors[0]))[0]['id'];
      $crud->update('libros_autores', array('id_libro' => $this->id, 'id_autor' => $id_autor), 'id_libro');
    endif;

    // Géneros
    $crud->update('libros_generos', array('id_libro' => $this->id, 'id_genero' => $this->genres[0]['id']), 'id_libro');

    // Archivos
    foreach ($files as $file) :
      // echo ($file['portada'] == null);
      // echo '---------------------------------------';
      $data = array(
        'id_libro'    => $this->id,
        'id_formato'  => $file['formato'] != "" ? $file['formato'] : null,
        'id_idioma'   => 'EN',
        'titulo'      => $file['titulo'],
        'archivo'     => $file['archivo'],
        'portada'     => $file['portada'],
        'isbn'        => $file['isbn'],
        'precio'      => $file['precio']
      );

      if ($file['id'] != "") :
        $crud->update('libros_formatos_idiomas', array_merge(['id' => $file['id']], $data), 'id');
      else :
        $crud->insert('libros_formatos_idiomas', $data);
      endif;
    endforeach;
  }

  public function loadData(bool $loadFiles = true) {
    $this->book_data  = (new Modelo())->getBook($this->id);
    $this->authors    = (new Modelo())->getBookAuthors($this->id);
    $this->genres     = (new Modelo())->getBookGenres($this->id);

    if ($loadFiles) :
      $this->file_data  = (new Modelo())->getBookFile($this->id);
      $this->file_data = array_map(
        function ($file) {
          if ($file['portada'] != null) :
            $portada = base64_encode($file['portada']);
            $file['portada'] = $portada;
          endif;
          if ($file['archivo'] != null) :
            $archivo = base64_encode($file['archivo']);
            $file['archivo'] = $archivo;
          endif;
          return $file;
        },
        $this->file_data
      );
    endif;
  }

}
