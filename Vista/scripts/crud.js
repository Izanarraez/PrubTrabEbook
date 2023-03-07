const requestURL = "http://localhost/DAW02-EBOOK-STORE/";

//Así? Qué locura, no?
class Book {
  constructor(id, titulo, subtitulo, resumen, language, authors, genero, formato, file, photo, pages, isbn) {
    this.id = id;
    this.titulo = titulo;
    this.subtitulo = subtitulo;
    this.resumen = resumen;
    this.idioma = language;
    this.nombreAutor = authors;
    this.nombreGenero = genero;
    this.formato = formato;
    this.archivo = file;
    this.portada = photo;
    this.paginas = pages;
    this.isbn = isbn;
  }
}
class Genero {
  constructor(id, nombre, imagen) {
    this.id = id;
    this.nombre = nombre;
    this.imagen = imagen;
  }
}

function XMLHttp() { }
XMLHttp.prototype = {
  add: function (book) {
    const request = new XMLHttpRequest();
    request.open("POST", requestURL);
    request.setRequestHeader("Content-Type", "application/json");
    request.send(JSON.stringify(book));
  },
  remove: function (id) {
    const request = new XMLHttpRequest();
    request.open("DELETE", requestURL + id);
    request.send();
  },
  update: function (book) {
    const request = new XMLHttpRequest();
    request.open("PATCH", requestURL + book.id);
    request.setRequestHeader("Content-Type", "application/json");
    request.send(JSON.stringify(book));
  },
  search: function (predicate) {
    return new Promise((resolve, reject) => {
      const request = new XMLHttpRequest();
      request.open("GET", requestURL + predicate);
      request.send();
      request.onload = function () {
        if (this.status == 200) resolve(JSON.parse(this.response));
      }
      request.onerror = function () {
        reject("Error de conexión");
      }
    })
  }
}