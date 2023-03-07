var bot = document.getElementById('addCart');
var circulo = document.getElementById('numeroCarrito');

bot.addEventListener('click',moverCirculo)

function moverCirculo(){
    var posicion = 0;
    var transicion = setInterval(move,20)

    function move(){
        if(posicion >= 5){
            circulo.style.top = 0+'px';
            clearInterval(transicion)
        }
        else{
            posicion += 1;
            circulo.style.top = '-'+posicion+'px';
        }
    }
}