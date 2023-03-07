window.addEventListener('DOMContentLoaded', async () => {
  load_languages();
  load_genres();
});

window.addEventListener('DOMContentLoaded', () => {
  document.getElementById('traer_libro').addEventListener('submit', get_book);
  document.getElementById('submit_button').addEventListener('click', send_book);
  document.getElementById('reset_button').addEventListener('click', reset_form);

  document.getElementById('add_file_button').addEventListener('click', async (e) => {
    document.getElementById('files').appendChild(await create_file_fields(e));
  });
});

function showImage(e) {
  const [file] = e.target.files
  if (file) e.target.form.querySelector('#show_image').src = URL.createObjectURL(file);
  // if (genero.imagen) cardImg.src = "data:image/png;base64," + genero.imagen;
}

function updateFormat(e) {
  const [file] = e.target.files
  if (file) {
    let extension = file.name.match(/\w*$/)[0]
    e.target.nextElementSibling.value = extension.toUpperCase();
    e.target.nextElementSibling.innerText = extension.toUpperCase();
  }
}

let availableLanguages;
async function load_languages() {
  availableLanguages = await fetch('http://localhost/DAW02-EBOOK-STORE/languages')
    .then(response => response.json());
}

async function reset_form() {
  console.log(document.querySelector('[data-form-book]'));
  document.querySelector('[data-form-book]').reset();
  document.querySelectorAll('[data-form-file]').forEach(node => { if (!node.hidden) node.remove() })
}

async function load_genres() {
  const generos_select = document.getElementById('genero');
  const genres = await fetch('http://localhost/DAW02-EBOOK-STORE/category')
    .then(response => response.json());

  genres.forEach(element => {
    const genre = document.getElementById('option_template').cloneNode();
    genre.hidden = false;
    genre.id = 'genero_' + element.id;
    genre.value = element.nombre;
    genre.innerText = element.nombre;
    generos_select.appendChild(genre)
  });
}

function get_book(e) {
  e.preventDefault();
  const form = e.target;
  const form_data = new FormData(form);

  fetch('http://localhost/DAW02-EBOOK-STORE/book/id/' + form_data.get('id_libro'))
    // // .then(response => response.text())
    // .then(response => {
    //   try { console.log(JSON.parse(response)); }
    //   catch { console.log(response) };
    // })
    .then(response => response.json())
    .then(book => load_book(book['book']));
}

async function send_book(e) {
  const book = document.querySelector('[data-form-book]');
  const files = document.querySelectorAll('[data-form-file]');
  const formData = new FormData(book);

  let required = [book.querySelectorAll(':required')];
  let i = 0;
  files.forEach(form => {
    if (!form.hidden) {
      required.push(form.querySelectorAll(':required'));
      const data = new FormData(form)
      for (const datum of data.entries()) {
        if (datum[1] instanceof File)
          formData.append(`${datum[0]}_${i}`, datum[1])
        else
          formData.append(`file[${i}][${datum[0]}]`, datum[1])
      }
      i++;
    }
  });

  // Check required fields contain stuff
  valid = true
  required.forEach(nodelist => nodelist.forEach(node => {
    if (!node.checkValidity()) {
      node.form.querySelector('button').click();
      valid = false;
    }
  }))

  if (valid) {
    fetch('http://localhost/DAW02-EBOOK-STORE/book/add', {
      method: 'POST',
      body: formData
    }).then(response => response.text())
      .then(response => {
        try { console.log(JSON.parse(response)); }
        catch { console.log(response) };
      })
    // location.reload();
  }
}

function getFileContent(file) {
  return new Promise((resolve, reject) => {
    var fr = new FileReader();
    fr.readAsText(file);
    fr.onload = function () { resolve(this.response); };
    fr.onerror = function () { reject("fuck"); };
  });
}

async function load_book(book) {
  // ! very crude
  // ! so precarious
  document.getElementById('files').innerHTML = "";

  for (const prop in book) {
    try {
      document.getElementById(prop).value = book[prop];
      // document.getElementById(prop).innerText = book[prop];
    } catch { }

    // ! so uncivilized
    if (prop == "autores") document.getElementById('autor').value = book[prop][0]['nombre']
    if (prop == "generos") document.getElementById('genero').value = book[prop][0]['nombre']
    if (prop == "archivos") {
      let counter = 0;
      for (const archivo of book[prop]) {
        let fieldset = await create_file_fields(null, archivo);
        // fieldset.dataset.file = counter++;
        document.getElementById('files').appendChild(fieldset)
      }
    }
  }
}

async function create_file_fields(e = null, data = null) {
  if (e != null) e.preventDefault();

  const template = document.getElementById('file_template');
  const file = template.cloneNode(true);

  file.hidden = false;

  availableLanguages.forEach(language => {
    const option = document.getElementById('option_template').cloneNode();

    option.hidden = false;
    option.id = '' + language.id;
    option.value = language.idioma;
    option.innerText = language.idioma;

    file.querySelector('#idioma').appendChild(option)
  });

  for (const prop in data) {
    switch (prop) {
      case 'idioma':
        file.querySelector(`[value="${data[prop]}"]`).selected = true;
        break;
      default:
        try {
          file.querySelector('#' + prop).innerText = data[prop];
          file.querySelector('#' + prop).value = data[prop];
          file.querySelector('#' + prop).placeholder = data[prop];
        } catch { }
        break;
    }

    if ((prop == 'archivo') && data[prop] != null) {
      const myFile = new File([data[prop]], `${data['titulo']}.${data['formato']}`);
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(myFile);
      file.querySelector('#' + prop).files = dataTransfer.files;
      file.querySelector('#' + prop).dispatchEvent(new Event('change'));
    }

    if ((prop == 'portada') && data[prop] != null) {
      let portada = await fetch("data:image/png;base64," + data[prop])
        .then(res => res.blob())
        .then(blob => new File([blob], `${data['titulo']}_portada`))

      // const myFile = new File([data[prop]], `${data['titulo']}_portada`);
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(portada);
      file.querySelector('#' + prop).files = dataTransfer.files;
      const [portada_url] = file.querySelector('#' + prop).files
      file.querySelector('#show_image').src = URL.createObjectURL(portada_url);
    }

  }

  return file;
}

