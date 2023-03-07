// HTML DOM references
const form = document.forms["landingForm"];

const username = document.getElementById("usuario");
const nombre = document.getElementById("nombre");
const surname = document.getElementById("apellidos");

const email = document.getElementById("email");

const pass_1 = document.getElementById("password_1");
const pass_2 = document.getElementById("password_2");

const birth = document.getElementById("fecha_nacimiento");

const address = document.getElementById("direccion");
const countrySelect = document.getElementById("pais");
const card = document.getElementById("tarjeta_credito");
const card_4 = document.getElementById("tarjeta_num_4");


const validate = function (e) {
  // console.log("Le has dado a submit.")

  // Validate username
  if (!validateUsername()) {
    // console.log("Problema con nombre de usuario.");
    username.focus();
    e.preventDefault();
    return false;
  }

  // Validate name
  if (!validateName()) {
    // console.log("Problema con nombre.");
    nombre.focus();
    e.preventDefault();
    return false;
  }

  // Validate surname
  if (!validateSurname()) {
    // console.log("Problema con apellido.");
    surname.focus();
    e.preventDefault();
    return false;
  }

  // Validate email
  // Done with default HTML validation for now

  // Validate password
  if (!validatePassword()) {
    // console.log("Problema con contraseña.");
    pass_1.focus();
    e.preventDefault();
    return false;
  }

  // Passwords match
  if (!passwordMatch()) {
    // console.log("Problema con contraseña 2.");
    pass_2.focus();
    e.preventDefault();
    return false;
  }

  // Validate age
  if (!validateBirth()) {
    // console.log("Problema con fecha de nacimiento.");
    birth.focus();
    e.preventDefault();
    return false;
  }

  // Validate credit card number
  if (card.style.display != "none" && !validateCardNum()) {
    // console.log("Problema con tarjeta");
    card.focus();
    e.preventDefault();
    return false;
  }

  // console.log("Enviando el formulario.");
  document.getElementById("submit_alert").innerHTML = "Formulario enviado correctamente.";

}

//#region Validation pure functions

const regEx = {
  username: /^[\p{L}\d_-]{3,20}$/u,
  name: /^(?=.{2,60}$)\p{L}*(\s\p{L}*)?$/u,

  email: /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,

  password: /(?=.*\p{Lu})(?=.*\p{Ll})(?=.*\d)(?=.*[¿?¡!*.<>|@#~€¬"·$%&()={}\[\]\/\\_\-]).{8,}/u,
  upperCase: /(?=.*\p{Lu}).*/u,
  lowerCase: /(?=.*\p{Ll}).*/u,
  number: /(?=.*\d).*/u,
  symbol: /(?=.*[¿?¡!*.<>|@#~€¬"·$%&()={}\[\]\/\\_\-]).*/,

  cardNum: /^\d{16}$/,
  cardNumPart: /^\d{4}$/,
}

const validUsername = function (str) {
  return regEx.username.test(str);
}

const validName = function (str) {
  return regEx.name.test(str);
}

const validSurname = function (str) {
  return regEx.name.test(str);
}

const validPassword = function (str) {
  return regEx.password.test(str);
}

const validEmail = function (str) {
  return regEx.email.test(str);
}


const validBirth = function (date) {
  const birth = new Date(date);
  const now = new Date();

  let age = Math.floor((now - birth) / (1000 * 60 * 60 * 24 * 345));

  return 18 < age && age < 120;
}

const validCardNum = function (str) {
  return regEx.cardNum.test(str);
}

const luhn = function (cardNum) {
  cardNum = String(cardNum).split("").reverse().map(x => parseInt(x));
  let sum = 0;
  let parity = cardNum.length % 2;

  for (let i = 0; i < cardNum.length; i++) {
    if (i % 2 == 0)
      sum = sum + cardNum[i];
    else if (cardNum[i] > 4)
      sum = sum + (2 * cardNum[i]) - 9;
    else
      sum = sum + 2 * cardNum[i];
  }
  return sum % 10 == 0;
}

//#endregion

// Validation events

const validateUsername = function () {
  // Esconder el alert
  document.getElementById("username_alert").innerHTML = "";

  if (!validUsername(username.value)) {
    let message = "El nombre de usuario tiene que tener entre 3 y 20 caracteres.";
    // console.log(message);
    document.getElementById("username_alert").innerHTML = message;
    return false;
  } else {
    // console.log("Nombre de usuario válido.");
    return true;
  }
}

const validateName = function () {
  // Esconder el alert
  document.getElementById("nombre_alert").innerHTML = "";

  if (!validName(nombre.value)) {
    let message = "Un nombre solo puede contener letras, un máximo de dos palabras y 60 caracteres.";
    // console.log(message);
    document.getElementById("nombre_alert").innerHTML = message;
    return false;
  } else {
    // console.log("Nombre válido.");
    return true;
  }
}

const validateSurname = function () {
  // Esconder el alert
  document.getElementById("apellidos_alert").innerHTML = "";

  if (!validSurname(surname.value)) {
    let message = "Un apellido solo puede contener letras, un máximo de dos palabras y 60 caracteres.";
    // console.log(message)
    document.getElementById("apellidos_alert").innerHTML = message;
    return false;
  } else {
    // console.log("Apellidos válidos.");
    return true;
  }
}

const validateEmail = function () {
  // Esconder el alert
  document.getElementById("email_alert").innerHTML = "";

  if (!validEmail(email.value)) {
    let message = "Email no valido.";
    // console.log(message)
    document.getElementById("email_alert").innerHTML = message;
    return false;
  } else {
    // console.log("Email válido.");
    return true;
  }
}


/* PASSWORD VALIDATION */
const validatePassword = function () {
  // Esconder las alerts
  document.getElementById("password_alerts").innerHTML = "";

  if (!validPassword(pass_1.value)) {
    // console.log("La contraseña no es válida.");
    passwordShowCorrections(pass_1.value);
    return false;
  } else {
    // console.log("La contraseña es válida.");
    return true;
  }
}

const passwordShowCorrections = function (str) {
  let messages = {};
  const length = /.{8,}/;
  const upperCase = /(?=.*\p{Lu}).*/u;
  const lowerCase = /(?=.*\p{Ll}).*/u;
  const number = /(?=.*\d).*/;
  const symbol = /(?=.*[¿?¡!*.<>|@#~€¬"·$%&()={}\[\]\/\\_\-]).*/;

  if (!length.test(str))
    messages.tamaño = "La contraseña tiene que tener un mínimo de 8 caracteres.";

  if (!upperCase.test(str))
    messages.mayúscula = "La contraseña tiene que contener una letra mayúscula.";

  if (!lowerCase.test(str))
    messages.minúscula = "La contraseña tiene que contener una letra minúscula.";

  if (!number.test(str))
    messages.números = "La contraseña tiene que contener un número.";

  if (!symbol.test(str))
    messages.símbolos = "La contraseña tiene que contener uno de estos símbolos: ¿?¡!*.<>|@#~€¬\"·$ %& ()={}[]/\\.";

  Object.keys(messages).forEach(
    key => {
      console.log(key)
      let p = document.createElement('p');
      p.id = key;
      p.innerHTML = messages[key];
      document.getElementById("password_alerts").appendChild(p);
    }
  )
};

const passwordMatch = function () {
  document.getElementById("password_alert_match").innerHTML = "";

  if (pass_1.value !== pass_2.value) {
    const message = "Las contraseñas no coinciden.";
    // console.log(message);
    document.getElementById("password_alert_match").innerHTML = message;
    return false;
  } else {
    // console.log("Las contraseñas coinciden.");
    return true;
  }
}

const validateBirth = function () {
  document.getElementById("fecha_alert").innerHTML = "";

  if (birth.value != "" && !validBirth(birth.value)) {
    let message = "Tienes que tener entre 18 y 120 años para poder leer.";
    // console.log(message);
    document.getElementById("fecha_alert").innerHTML = message;
    return false;
  } else {
    // console.log("La edad es válida o no está declarada.");
    return true;
  }
}

const validateCardNum = function () {
  document.getElementById("tarjeta_alert").innerHTML = "";

  // Piece together the card number form the four inputs
  let num = "";
  for (let i = 1; i < 5; i++)
    num += document.getElementById("tarjeta_num_" + i).value;

  if (num === "" || !validCardNum(num) && !luhn(num)) {
    message = "El numero de la tarjeta no es válido.";
    // console.log(message);
    document.getElementById("tarjeta_alert").innerHTML = message;
    return false;
  } else {
    // console.log("El numero de la tarjeta es válido o no ha sido rellenado.");
    return true;
  }
}

/* ADDRESS AND SHOW CARD INFO */
const showHideCard = function () {
  if (address.value == "" || countrySelect.options[countrySelect.selectedIndex].disabled)
    card.style.display = "none";
  else
    card.style.display = "block";
}

//#region Countries

// Europe
const countries = [
  { "name": "Aland Islands", "code": "AX" },
  { "name": "Albania", "code": "AL" },
  { "name": "Andorra", "code": "AD" },
  { "name": "Austria", "code": "AT" },
  { "name": "Belarus", "code": "BY" },
  { "name": "Belgium", "code": "BE" },
  { "name": "Bosnia and Herzegovina", "code": "BA" },
  { "name": "Bulgaria", "code": "BG" },
  { "name": "Croatia", "code": "HR" },
  { "name": "Czech Republic", "code": "CZ" },
  { "name": "Denmark", "code": "DK" },
  { "name": "Estonia", "code": "EE" },
  { "name": "Faroe Islands", "code": "FO" },
  { "name": "Finland", "code": "FI" },
  { "name": "France", "code": "FR" },
  { "name": "Germany", "code": "DE" },
  { "name": "Gibraltar", "code": "GI" },
  { "name": "Greece", "code": "GR" },
  { "name": "Guernsey", "code": "GG" },
  { "name": "Holy See (Vatican City State)", "code": "VA" },
  { "name": "Hungary", "code": "HU" },
  { "name": "Iceland", "code": "IS" },
  { "name": "Ireland", "code": "IE" },
  { "name": "Isle of Man", "code": "IM" },
  { "name": "Italy", "code": "IT" },
  { "name": "Jersey", "code": "JE" },
  { "name": "Kosovo", "code": "XK" },
  { "name": "Latvia", "code": "LV" },
  { "name": "Liechtenstein", "code": "LI" },
  { "name": "Lithuania", "code": "LT" },
  { "name": "Luxembourg", "code": "LU" },
  { "name": "Macedonia, the Former Yugoslav Republic of", "code": "MK" },
  { "name": "Malta", "code": "MT" },
  { "name": "Moldova, Republic of", "code": "MD" },
  { "name": "Monaco", "code": "MC" },
  { "name": "Montenegro", "code": "ME" },
  { "name": "Netherlands", "code": "NL" },
  { "name": "Norway", "code": "NO" },
  { "name": "Poland", "code": "PL" },
  { "name": "Portugal", "code": "PT" },
  { "name": "Romania", "code": "RO" },
  { "name": "San Marino", "code": "SM" },
  { "name": "Serbia", "code": "RS" },
  { "name": "Serbia and Montenegro", "code": "CS" },
  { "name": "Slovakia", "code": "SK" },
  { "name": "Slovenia", "code": "SI" },
  { "name": "Spain", "code": "ES" },
  { "name": "Svalbard and Jan Mayen", "code": "SJ" },
  { "name": "Sweden", "code": "SE" },
  { "name": "Switzerland", "code": "CH" },
  { "name": "Ukraine", "code": "UA" },
  { "name": "United Kingdom", "code": "GB" }
];

function generateCountries() {
  let content = ` <option disabled selected > País </option > `;
  for (id in countries) {
    content += `
    <option value=${countries[id].code}>${countries[id].name}</option>
    `;
  }
  countrySelect.innerHTML = content;
}

//#endregion

function init() {
  generateCountries();
  showHideCard();
}

const trim = function (e) {
  e.target.value = e.target.value.trim();
}

// Event Listeners
window.addEventListener("load", init);

form.addEventListener("submit", e => validate(e));
form.addEventListener("focusout", trim);

username.addEventListener("blur", validateUsername);
nombre.addEventListener("blur", validateName);
surname.addEventListener("blur", validateSurname);

email.addEventListener("blur", validateEmail);

pass_1.addEventListener("blur", validatePassword);
pass_2.addEventListener("blur", passwordMatch);

birth.addEventListener("blur", validateBirth);

address.addEventListener("blur", showHideCard);
countrySelect.addEventListener("change", showHideCard);

//card.addEventListener("focusout", validateCardPart);
card_4.addEventListener("blur", validateCardNum);
