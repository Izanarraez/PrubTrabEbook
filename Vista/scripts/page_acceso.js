const selector_formulario = document.getElementById('botones');

function gestionar_botones(e) {
  if (e.target.id === selector_formulario.id)
    return;

  cargar_formulario(e.target.id);
}

function cargar_formulario(formulario) {
  var request = new XMLHttpRequest();
  request.open("GET", `Vista/Plantillas/${formulario}.php`, true);
  request.onerror = (e) => console.error(request.statusText);

  request.onload = (e) => {
    if (request.status !== 200)
      return;
    document.getElementById('formulario').innerHTML = request.response;

    document.getElementById('formulario')
      .querySelectorAll('input')
      .forEach(element => {
        restaurar_datos(element.id)
      });

    const form = document.querySelector('form');
    form.addEventListener('submit', sendForm);
    console.log(form);
  };

  request.send();
}

async function sendForm(e) {
  e.preventDefault();
  const form = e.target;
  const action = form.id.split('_')[1];
  const formData = new FormData(form);

  let response = await fetch('http://localhost/DAW02-EBOOK-STORE/user/' + action, {
    method: 'POST',
    body: formData
  }).then(response => response.text())
    .then(response => JSON.parse(response));

    console.log(response)
  if (response.success) {
    console.log(response.login)
    localStorage.setItem("usuario", JSON.stringify(response.login));
    window.location.href = "home";
  } else {
    console.log(response)
  }
}


function restaurar_datos(id) {
  if (sessionStorage.getItem(id) != null)
    document.getElementById(id).value = sessionStorage.getItem(id);
}

function guardar_datos(e) {
  sessionStorage.setItem(e.target.id, e.target.value);
}

function init() {
  cargar_formulario('form_login');

  selector_formulario
    .addEventListener('click', e => gestionar_botones(e));
  document
    .getElementById('formulario')
    .addEventListener('change', e => guardar_datos(e));
}

window.addEventListener('load', init)
