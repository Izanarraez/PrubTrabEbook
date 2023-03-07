const btnGaleria = document.getElementById("galeria");
const verMas = document.getElementById("verMasGaleria");
const verGenero = document.getElementsByClassName("verLibros");
const buscador = document.getElementById("buscador");
const navbar = document.getElementsByClassName("navbar")[0];
const logOut = document.getElementById("logOut");

//Peticiones en la página home
if (document.body.id === "home") {
  document.addEventListener('DOMContentLoaded', async () => {
    let nav = document.createElement("nav");
    let ol = document.createElement("ol");
    let li = document.createElement("li");


    navbar.parentNode.insertBefore(nav, document.querySelector("main"));
    nav.appendChild(ol);
    ol.appendChild(li);

    nav.className = "my-1 mx-5"
    ol.className = "breadcrumb m-0";
    li.className = "breadcrumb-item active";
    li.textContent = "Home";

    try {
      let listaLibros = await new XMLHttp().search("search");

      mostrarLibros(listaLibros, 4);
    } catch (error) {
      console.log(error)
      let errorWarning = document.createElement("h2");
      errorWarning.textContent = error;
      libros.appendChild(errorWarning);
    }
  });
} else if (document.body.id === "libros-genero") { //Sacar los libros de cada género
  document.addEventListener('DOMContentLoaded', async (e) => {
    var url = decodeURI(window.location.href);
    let nombreGenero = url.substring(url.lastIndexOf("=") + 1, url.length);

    let nav = document.createElement("nav");
    let ol = document.createElement("ol");
    let li1 = document.createElement("li");
    let li2 = document.createElement("li");
    let li3 = document.createElement("li");
    let a1 = document.createElement("a");
    let a2 = document.createElement("a");

    navbar.parentNode.insertBefore(nav, document.querySelector("main"));
    nav.appendChild(ol);
    ol.appendChild(li1);
    ol.appendChild(li2);
    ol.appendChild(li3);
    li1.appendChild(a1);
    li2.appendChild(a2);

    nav.className = "my-1 mx-5"
    ol.className = "breadcrumb m-0";
    li1.className = "breadcrumb-item";
    a1.textContent = "Home";
    a1.href = "home";
    li2.className = "breadcrumb-item";
    a2.textContent = "Géneros";
    a2.href = "galeria";
    li3.className = "breadcrumb-item active";
    li3.textContent = nombreGenero;

    document.getElementById("libros").previousElementSibling.firstElementChild.textContent = nombreGenero;
    try {
      let listaLibros = await new XMLHttp().search("category/" + nombreGenero + "?get");
      mostrarLibros(listaLibros);
    } catch (error) {
      console.log(error)
      let errorWarning = document.createElement("h2");
      errorWarning.textContent = error;
      // libros.appendChild(errorWarning);
    }
  });
} else if (document.body.id === "libro") { //Mostrar cada libro concreto
  document.addEventListener('DOMContentLoaded', async (e) => {
    var url = decodeURI(window.location.href);
    let idLibro = url.substring(url.lastIndexOf("=") + 1, url.length);


    try {
      let elementosLibro = await new XMLHttp().search("book/id/" + idLibro + "/");

      let nav = document.createElement("nav");
      let ol = document.createElement("ol");
      let li1 = document.createElement("li");
      let li2 = document.createElement("li");
      let li3 = document.createElement("li");
      let li4 = document.createElement("li");
      let a1 = document.createElement("a");
      let a2 = document.createElement("a");
      let a3 = document.createElement("a");

      navbar.parentNode.insertBefore(nav, document.querySelector("main"));
      nav.appendChild(ol);
      ol.appendChild(li1);
      ol.appendChild(li2);
      ol.appendChild(li3);
      ol.appendChild(li4);
      li1.appendChild(a1);
      li2.appendChild(a2);
      li3.appendChild(a3);

      nav.className = "my-1 mx-5"
      ol.className = "breadcrumb m-0";
      li1.className = "breadcrumb-item";
      a1.textContent = "Home";
      a1.href = "home";
      li2.className = "breadcrumb-item";
      a2.textContent = "Géneros";
      a2.href = "galeria";
      li3.className = "breadcrumb-item";
      a3.textContent = elementosLibro.book.generos[0].nombre;
      a3.href = "libros-genero?genero=" + elementosLibro.book.generos[0].nombre;
      li4.className = "breadcrumb-item active";
      li4.textContent = elementosLibro.book.titulo;

      mostrarLibro(elementosLibro);
    } catch (error) {
      console.log(error)
      let errorWarning = document.createElement("h2");
      errorWarning.textContent = error;
      // elemento.appendChild(errorWarning);
    }
  });
} else if (document.body.id === "buscando") { //Sacar los libros de busqueda
  document.addEventListener('DOMContentLoaded', async (e) => {
    let titulo = JSON.parse(localStorage.getItem("titulo"));

    try {
      if (titulo === "") {
        document.getElementById("libros").previousElementSibling.firstElementChild.textContent = "Todos";
        console.log
      } else {
        titulo = titulo.substring(0, 1).toUpperCase() + titulo.substring(1, titulo.length).toLowerCase();
        document.getElementById("libros").previousElementSibling.firstElementChild.textContent = titulo;
      }

      let listaLibros = await new XMLHttp().search("search?titulo=" + titulo);
      console.log(listaLibros)

      if(listaLibros.length > 0){
        mostrarLibros(listaLibros);
      } else{
        const error = document.createElement("p");
        document.getElementById("libros").appendChild(error);
        error.className = "fs-2 text-danger";
        error.textContent = "No se ha encontrado ningún libro con ese título";
      }
      window.localStorage.removeItem('titulo');
    } catch (error) {
      console.log(error)
      let errorWarning = document.createElement("h2");
      errorWarning.textContent = error;
      // libros.appendChild(errorWarning);
    }
  });
} else if (document.body.id === "contacto") {
  let nav = document.createElement("nav");
  let ol = document.createElement("ol");
  let li1 = document.createElement("li");
  let li2 = document.createElement("li");
  let a1 = document.createElement("a");

  navbar.parentNode.insertBefore(nav, document.querySelector("main"));
  nav.appendChild(ol);
  ol.appendChild(li1);
  ol.appendChild(li2);
  li1.appendChild(a1);

  nav.className = "py-1 px-5 bg-white"
  ol.className = "breadcrumb m-0";
  li1.className = "breadcrumb-item";
  a1.textContent = "Home";
  a1.href = "home";
  li2.className = "breadcrumb-item active";
  li2.textContent = "Contacto";
}

//Listado de géneros en el footer
document.addEventListener('DOMContentLoaded', async () => {
  const footer = document.getElementById("footer_genero");
  if(footer){
  try { 
    let listaGeneros = await new XMLHttp().search("category");

    listaGeneros.forEach(genero => {
      let indice = listaGeneros.indexOf(genero);
      if (indice <= 6) {
        let li = document.createElement("li");
        let a = document.createElement("a");

        li.appendChild(a);
        footer.appendChild(li);

        a.href = "libros-genero?genero=" + genero.nombre;
        a.textContent = genero.nombre;
        a.className = "text-decoration-none text-light";
      } else {
        let li = document.createElement("li");
        let a = document.createElement("a");

        li.appendChild(a);
        footer.nextElementSibling.appendChild(li);

        a.href = "libros-genero?genero=" + genero.nombre;
        a.textContent = genero.nombre;
        a.className = "text-decoration-none text-light";
      }
    });
    //Mostrar galería en su lugar
    if (document.body.id === "pagina-de-galeria") {
      let nav = document.createElement("nav");
      let ol = document.createElement("ol");
      let li1 = document.createElement("li");
      let li2 = document.createElement("li");
      let a1 = document.createElement("a");

      navbar.parentNode.insertBefore(nav, document.querySelector("main"));
      nav.appendChild(ol);
      ol.appendChild(li1);
      ol.appendChild(li2);
      li1.appendChild(a1);

      nav.className = "my-1 mx-5"
      ol.className = "breadcrumb m-0";
      li1.className = "breadcrumb-item";
      a1.textContent = "Home";
      a1.href = "home";
      li2.className = "breadcrumb-item active";
      li2.textContent = "Géneros";

      mostrarGaleria(listaGeneros);
      /*verMas.addEventListener("click", ()=>{
        contador+=12;
        if(contador !== listaGeneros.length){
          mostrarGaleria();
        } else {
          verMas.style = display-none;
        }
      });*/
    } else if (document.body.id === "home") {
      mostrarGaleria(listaGeneros, 3);
    }
  } catch (error) {
    console.log(error)
    let errorWarning = document.createElement("h2");
    errorWarning.textContent = error;
    // generos.appendChild(errorWarning);
  }
}
});

//Sacar usuario para mostrar imagen y menú
if (document.getElementsByTagName("nav")[1]) {
  document.addEventListener('DOMContentLoaded', async () => {
    const espacioUsuario = document.getElementById("usuario");
    if (localStorage.getItem("usuario")) {
      document.getElementById("acceder").className = "btn btn-primary mr-4 d-none";
      document.getElementById("usuario").className = "nav-item dropdown d-flex justify-content-center align-items-center mx-3";

      let usuario = JSON.parse(localStorage.getItem("usuario"));
      const ul = document.getElementsByClassName("dropdown-menu")[0];
      const divider = document.getElementsByClassName("dropdown-divider")[0].parentElement;

      if (usuario.user.tipo === 4 || usuario.user.tipo === 3) {
        let aLibro = document.createElement("a");
        ul.insertBefore(aLibro, divider);

        aLibro.href = "nuevo-libro";
        aLibro.className = "dropdown-item";
        aLibro.textContent = "Añadir Libro";

        if (usuario.user.tipo === 4) {
          let aGenero = document.createElement("a");
          let aAdminGenero = document.createElement("a");
          let aAdminLibro = document.createElement("a");

          ul.insertBefore(aGenero, divider);
          ul.insertBefore(aAdminGenero, divider);
          ul.insertBefore(aAdminLibro, divider);

          aGenero.href = "nuevo-genero";
          aGenero.className = "dropdown-item";
          aGenero.textContent = "Añadir Género";
          aAdminGenero.href = "";
          aAdminGenero.className = "dropdown-item";
          aAdminGenero.textContent = "Administrar Géneros";
          aAdminLibro.href = "";
          aAdminLibro.className = "dropdown-item";
          aAdminLibro.textContent = "Administrar Libros";
        }
      }

      const fotoUsuario = document.getElementById("fotoUsurio");
      if (usuario.user.foto === null) {
        fotoUsuario.src = "Vista/images/default_avatars/1.png";
      } else {
        fotoUsuario.src = "\"" + usuario.user.foto.path() + "\"";
      }

      fotoUsuario.alt = usuario.user.nombre;

    } else {
      document.getElementById("acceder").className = "btn btn-primary mr-4";
      document.getElementById("usuario").className = "d-none";

      eliminarHijos(espacioUsuario);
    }
  });
}

if (buscador) {
  buscador.addEventListener("click", async (e) => {
    let titulo = buscador.previousElementSibling.value;
    localStorage.setItem("titulo", JSON.stringify(titulo));
    window.location.href = "buscador";
    e.preventDefault();
  });

  logOut.addEventListener("click", () => {
    window.localStorage.removeItem('usuario');
    window.location.href = "home";
  });
}

window.addEventListener('load', async () => {
  if(localStorage.getItem("oscuro")){
    noche(document.querySelector('body'));    
  }
});