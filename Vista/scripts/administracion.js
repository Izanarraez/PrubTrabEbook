window.addEventListener('DOMContentLoaded', async () => {
  const radios = document.getElementsByName("panel_selector");
  radios.forEach(radio => {
    radio.addEventListener('change', (e) => { managePanel(e.target.id) })
  })

  managePanel('books');
});

async function managePanel(target) {
  const table = document.getElementById('table');
  const header = table.querySelector('thead');
  const rows = table.querySelector('tbody');


  switch (target) {
    case 'books':
      data = await loadBooks();
      break;
    case 'genres':
      data = await loadGenres();
      break;
    case 'users':
      data = await loadUsers();
      break;
  }

  header.innerHTML = "";
  rows.innerHTML = "";
  header.appendChild(data['header']);
  data['rows'].forEach(row => { rows.appendChild(row); });
}

async function loadBooks() {
  const books = await fetch('http://localhost/DAW02-EBOOK-STORE/book')
    .then(response => response.json());

  const rows = [];
  const header = document.getElementById('header_template_book').cloneNode(true);
  header.removeAttribute('id');

  books.forEach(book => {
    const row = document.getElementById('row_template').cloneNode(true);
    row.removeAttribute('id');
    row.querySelector('[data-id]').innerText = book.id;
    row.querySelector('[data-1]').innerText = book.titulo;
    row.querySelector('[data-2]').innerText = book.autores[0].nombre;
    rows.push(row);
  })

  return { 'header': header, 'rows': rows };
}

async function loadGenres() {
  const genres = await fetch('http://localhost/DAW02-EBOOK-STORE/category')
    .then(response => response.json());

  const rows = [];
  const header = document.getElementById('header_template_category').cloneNode(true);
  header.removeAttribute('id');

  genres.forEach(genre => {
    const row = document.getElementById('row_template').cloneNode(true);
    row.removeAttribute('id');
    row.querySelector('[data-id]').innerText = genre.id;
    row.querySelector('[data-1]').innerText = genre.nombre;
    row.querySelector('[data-2]').innerText = genre.descripcion;
    rows.push(row);
  })

  return { 'header': header, 'rows': rows };
}

async function loadUsers() {
  const users = await fetch('http://localhost/DAW02-EBOOK-STORE/user?get')
    .then(response => response.json());

  const rows = [];
  const header = document.getElementById('header_template_user').cloneNode(true);
  header.removeAttribute('id');

  users.forEach(user => {
    const row = document.getElementById('row_template').cloneNode(true);
    row.removeAttribute('id');
    row.querySelector('[data-id]').innerText = user.id;
    row.querySelector('[data-1]').innerText = user.usuario;
    row.querySelector('[data-2]').innerText = user.correo;
    rows.push(row);
  })

  return { 'header': header, 'rows': rows };
}