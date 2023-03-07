// Variables
var clases = ["f0", "f1", "f2", "f3", "f4", "f5", "f6", "f7"];
var claseIndex = 2;

// HTML DOM references
const bigger = document.getElementById("increase_font_size");
const smaller = document.getElementById("decrease_font_size");
const night = document.getElementById("modo_noche");
const cartas = document.getElementsByClassName("card");
// HTML DOM references for the night mode in @media
var mql = window.matchMedia("(max-device-width: 800px)");

// Functions
const modoNoche = function () {
  // console.log("Modo noche...");
  noche(document.querySelector('body'));
};

const noche = function (element) {
  if(element.id === "contacto"){
    if (element.children[5].firstElementChild.firstElementChild.style.backgroundColor === "rgb(35, 33, 33)") {
      if(localStorage.getItem("oscuro")){
        localStorage.removeItem("oscuro");
      }

      element.children[5].firstElementChild.firstElementChild.setAttribute('style', 'background-color:white !important; color:black;');
      element.children[5].firstElementChild.lastElementChild.setAttribute('style', 'background-color:rgba(var(--bs-secondary-rgb),var(--bs-bg-opacity))');  
      element.children[5].firstElementChild.lastElementChild.className = "col-12 col-md-8 bg-secondary p-4";
      element.children[5].firstElementChild.firstElementChild.className = "col-12 col-md-4 bg-white p-4";
      console.log(localStorage.getItem("oscuro")); 
    } else {
      if(!localStorage.getItem("oscuro")){
        localStorage.setItem("oscuro", "modo-Oscuro"); 
      }

      element.children[5].firstElementChild.firstElementChild.setAttribute('style', 'background-color:rgb(35, 33, 33)!important; color:white;');
      element.children[5].firstElementChild.lastElementChild.setAttribute('style', 'background-color:rgb(35, 33, 33)!important; color:white;');
      element.children[5].firstElementChild.lastElementChild.className = "col-12 col-md-8 bg-secondary p-4 border border-white";
      element.children[5].firstElementChild.firstElementChild.className = "col-12 col-md-4 bg-white p-4 border border-white";
    }
    // console.log(element.children[5].firstElementChild);
    element = element.children[5].firstElementChild;
  }else{
    if (element.style.backgroundColor === "rgb(35, 33, 33)") {
      if(localStorage.getItem("oscuro")){
        localStorage.removeItem("oscuro");
      }

      element.style.backgroundColor = "white";
      if(cartas !== "undefined"){
        for (let i = 0; i < cartas.length; i++) {
          // console.log(cartas)
          cartas[i].setAttribute('style', 'background-color:white ; color:black!important;');
          if(document.getElementById("libros") && cartas[i].className === "card text-dark text-decoration-none w-100 border-white"){
            cartas[i].className = "card text-dark text-decoration-none w-100";
          }
        }
      }
      element.style.color = "black";
      
    } else {
      if(!localStorage.getItem("oscuro")){
        localStorage.setItem("oscuro", "modo-Oscuro"); 
      }

      element.style.backgroundColor = "rgb(35, 33, 33)";

      if(cartas !== "undefined"){
        for (let i = 0; i < cartas.length; i++) {
        console.log("Entrando en noche cartas numero " + i)

          console.log(cartas[i].parentElement)
          cartas[i].setAttribute('style', 'background-color:rgb(35, 33, 33) ; color:white!important;');
          if(cartas[i].children[1].className !== "undefined" && cartas[i].children[1].className === "card-img-overlay d-flex align-items-center justify-content-center p-0"){
            cartas[i].children[1].className = "card-img-overlay d-flex align-items-center justify-content-center text-dark p-0"
          }
          if(document.getElementById("libros") && cartas[i].className === "card text-dark text-decoration-none w-100"){
            cartas[i].className = "card text-dark text-decoration-none w-100 border-white";
          }
        }
      }
      if(document.getElementById("cards")){
        console.log(cards.children[1].children.length)
        for (let i = 0; i < cards.children[1].children.length; i++) {
          cards.children[1].children[i].style.color = "white"
        }
      }
      if(document.getElementById("darkText") !== null){
        document.getElementById("darkText").style.color = "black"
      }
      element.style.color = "white";
    }
  }
};

// Events
window.onload = () => {
  bigger.addEventListener("click", increaseFont);
  smaller.addEventListener("click", decreaseFont);
  night.addEventListener("click", modoNoche);
}

const increaseFont = function (){
  let claseAnterior = claseIndex;
  claseIndex++;
  claseIndex = (claseIndex == clases.length) ? clases.length - 1 : claseIndex;
  changeClass(claseAnterior, claseIndex);
}

const decreaseFont = function (){
  let claseAnterior = claseIndex;
  claseIndex--;
  claseIndex = (claseIndex < 0) ? 0 : claseIndex;
  changeClass(claseAnterior, claseIndex);
}

function changeClass(anterior, siguiente) {
  if(anterior != siguiente) {
    var htmlElement = document.querySelector('html');
    htmlElement.classList.remove(clases[anterior]);
    htmlElement.classList.add(clases[siguiente]);
  }
}