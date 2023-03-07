function mostrarGaleria(listaGeneros, limite = 20) {
    const generos = document.getElementById("generos");
  
    listaGeneros.forEach((genero, index) => {
      if (index <= limite) {
        let div = document.createElement("div");
        let card = document.createElement("a");
        let cardImg = document.createElement("img");
        let cardDiv = document.createElement("div");
        let cardNombre = document.createElement("h2");
  
        // console.log(cardNombre.nodeValue)
        generos.insertBefore(div, verMas);
        div.appendChild(card);
        card.appendChild(cardDiv);
        card.insertBefore(cardImg, cardDiv);
        cardDiv.appendChild(cardNombre);
  
        div.className = "col-12 col-sm-6 col-md-4 col-lg-3 p-4";
        card.className = "card bg-dark text-dark";
        cardImg.className = "card-img";
        cardDiv.className = "card-img-overlay d-flex align-items-center justify-content-center p-0";
        cardNombre.className = "card-title bg-light bg-opacity-75 fs-3 px-5";
        
        // Si existe imagen de genero, la pinta.
        if (genero.imagen) cardImg.src = "data:image/png;base64," + genero.imagen;
        // Si no, coge una por defecto.
        else cardImg.src = "Vista/images/Modelo/ModeloLibro.jpg";
        cardImg.alt = "Imagen de " + genero.nombre;
  
        card.href = "libros-genero?genero=" + genero.nombre;
        cardNombre.textContent = genero.nombre;
      }
    });
  }
  
function mostrarLibros(listaLibros, indice = 20) {
    // console.log("listaLibros.length")
    // console.log(listaLibros.length)
    const libros = document.getElementById("libros");
    listaLibros.forEach((libro, index) => {
      if (index <= indice) {
        let div = document.createElement("div");
        let a = document.createElement("a");
        let img = document.createElement("img");
        let divDatos = document.createElement("div");
        let nombre = document.createElement("h2");
        let autor = document.createElement("p");
        let divDerecha = document.createElement("div");
        let precio = document.createElement("p");
  
        libros.appendChild(div);
        div.appendChild(a);
        a.appendChild(img);
        a.appendChild(divDatos);
        divDatos.appendChild(nombre);
        divDatos.appendChild(autor);
        divDatos.appendChild(divDerecha);
        divDerecha.appendChild(precio);
  
        div.className = "col-10 col-sm-5 col-lg-2 d-flex justify-content-around p-2";
        a.className = "card text-dark text-decoration-none w-100";
        img.className = "card-img-top";
        divDatos.className = "card-body";
        nombre.className = "card-title m-0 fs-4";
        autor.className = "m-0";
        divDerecha.className = "d-flex justify-content-end";
        precio.className = "m-0";
  
        a.href = "libro?id=" + libro.id;
        // Si existe imagen de genero, la pinta.
        if (libro.archivos[0].portada) img.src = "data:image/png;base64," + libro.archivos[0].portada;
        // Si no, coge una por defecto.
        else img.src = "Vista/images/Modelo/ModeloLibro.jpg";
        img.alt = "Libro " + libro.titulo;
  
        nombre.textContent = libro.titulo;
        autor.textContent = libro.autores[0].nombre;
  
        let precioBBDD = libro.archivos.map(archivo => archivo.precio)
        precioBBDD = precioBBDD.filter((archivo, index) => {
          return precioBBDD.indexOf(archivo) === index;
        });
        precioBBDD.sort();
        precio.textContent = "Desde " + precioBBDD[0] + "€";
      }
    });
  }
  
function mostrarLibro(elementosLibro) {
    const espacio = document.getElementById("mostrarLibro");
    let formatos = elementosLibro.book.archivos.map(archivo => archivo.formato)
    formatos = formatos.filter((archivo, index) => {
      return formatos.indexOf(archivo) === index;
    });
  
    for (let i = 0; i < formatos.length; i++) {
      let label = document.createElement("label");
      let input = document.createElement("input");
      espacio.children[3].children[4].firstElementChild.appendChild(label);
      label.textContent = formatos[i];
      espacio.children[3].children[4].firstElementChild.appendChild(label);
      label.textContent = formatos[i];
      label.appendChild(input);
      input.type = "radio";
      input.name = "formato";
      input.type = "radio";
      input.name = "formato";
    }
    espacio.children[3].children[4].firstElementChild.children[1].firstElementChild.checked = true;
    crearIdiomas(elementosLibro, espacio);
  
    espacio.children[1].textContent = elementosLibro.book.subtitulo;
  
    if (elementosLibro.book.archivos[0].portada) espacio.children[2].firstElementChild.src = "data:image/png;base64," + elementosLibro.book.archivos[0].portada;
    else espacio.children[2].firstElementChild.src = "Vista/images/Modelo/ModeloLibro.jpg";
    // if (elementosLibro.book.archivos.portada) espacio.children[2].firstElementChild.src = "data:image/png;base64," + elementosLibro.book.archivos.portada;
    // else espacio.children[2].firstElementChild.src = "Vista/images/Modelo/ModeloLibro.jpg";
    espacio.children[2].firstElementChild.alt = "Imagen de portada de " + elementosLibro.book.titulo;
    espacio.children[3].children[1].textContent = elementosLibro.book.autores[0].nombre;
    espacio.children[3].children[3].textContent = elementosLibro.book.resumen;
  
    // console.log("Viendo el formato")
  
    espacio.children[3].children[4].firstElementChild.addEventListener("change", () => {
      crearIdiomas(elementosLibro, espacio);
    });
  
    espacio.children[3].children[4].lastElementChild.lastElementChild.addEventListener("change", () => {
      elegirIdiomas(espacio, elementosLibro);
    });
  
    espacio.id = elementosLibro.book.id;
  }
  
function crearIdiomas(elementosLibro, espacio) {
    let idiomas = [];
    let valorActivo = document.querySelector("input[name='formato']:checked").parentElement.textContent;
    eliminarHijos(espacio.children[3].children[4].lastElementChild.lastElementChild);
  
    for (let i = 0; i < elementosLibro.book.archivos.length; i++) {
      if (elementosLibro.book.archivos[i].formato === valorActivo) {
        idiomas.push(elementosLibro.book.archivos[i].idioma);
      }
    }
  
    idiomas = idiomas.filter((archivo, index) => {
      return idiomas.indexOf(archivo) === index;
    });
  
    for (let i = 0; i < idiomas.length; i++) {
      let option = document.createElement("option");
      espacio.children[3].children[4].lastElementChild.lastElementChild.appendChild(option);
      option.name = "opcionIdioma";
      option.value = idiomas[i];
      option.textContent = idiomas[i];
    }
  
    elegirIdiomas(espacio, elementosLibro);
  }
  
function elegirIdiomas(espacio, elementosLibro) {
    let valorActivo = document.querySelector("input[name='formato']:checked").parentElement.textContent;
    let idiomaActual = espacio.lastElementChild.children[4].lastElementChild.lastElementChild.selectedOptions[0].textContent;
    for (let i = 0; i < elementosLibro.book.archivos.length; i++) {
      if (elementosLibro.book.archivos[i].idioma === idiomaActual && elementosLibro.book.archivos[i].formato === valorActivo) {
        espacio.firstElementChild.textContent = elementosLibro.book.archivos[i].titulo;
        espacio.children[3].children[6].textContent = elementosLibro.book.archivos[i].precio + "€";
      }
    }
  }
  
function eliminarHijos(parent) {
    while (parent.firstChild) {
      parent.removeChild(parent.firstChild);
    }
  }

