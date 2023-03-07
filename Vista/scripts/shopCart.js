const botonCarrito = document.getElementById("cart_icon");
let cartShop = [];
let idCartContent = 0;

document.addEventListener('DOMContentLoaded', () => {
    localGet();
    updateIconCart();
});

if (document.body.id === "libro") {
    document.addEventListener('DOMContentLoaded', async (e) => {
        const addCart = document.getElementById("addCart");
        var url = decodeURI(window.location.href);
        let idLibro = url.substring(url.lastIndexOf("=") + 1, url.length);
        try {
            let datosLibro = await new XMLHttp().search("book/id/" + idLibro + "/");
            addCart.addEventListener("click", () => {
                // console.log(e.target.parentElement.parentElement)
                addItem(datosLibro);
                // ! GET
                // localGet();
                // updateIconCart();
            });
        } catch (error) {
            console.log(error)
            let errorWarning = document.createElement("h2");
            errorWarning.textContent = error;
        }
    });
} else if (document.body.id === "shopping_cart") {
    const items = document.getElementById("items");

    // ! GET
    localGet();
    updateIconCart()
    paintCart(cartShop)

    items.addEventListener("click", e => {
        btnAccion(e);
    });

}

const addItem = objeto => {
    console.log(objeto.book.archivos[0].portada)
    console.log(objeto.book.archivos[0].portada)
    const select = document.getElementById("idioma");
    const product = {
        id: objeto.book.id,
        // imagen: document.querySelectorAll("img")[5].src,
        imagen: (objeto.book.archivos[0].portada !== null) ?  objeto.book.archivos[0].portada: (localStorage.getItem("usuario"))?document.querySelectorAll("img")[5].src:document.querySelectorAll("img")[4].src,
        // subtitle: objeto.book.subtitulo,
        // author: objeto.book.autores[0].nombre,
        format: document.querySelector("input[name='formato']:checked").parentElement.textContent,
        language: select.value,
        quantity: 1
    };

    for (let i = 0; i < objeto.book.archivos.length; i++) {
        if (product.format === objeto.book.archivos[i].formato && product.language === objeto.book.archivos[i].idioma) {
            product.title = objeto.book.archivos[i].titulo;
            product.price = objeto.book.archivos[i].precio;
        }
    }

    let count = 0;
    product.position = cartShop.length;
    // console.log(cartShop.length);

    if (cartShop.length !== 0) {

        for (let i = 0; i < cartShop.length; i++) {
            if (cartShop[i].title === product.title && cartShop[i].format === product.format && cartShop[i].language === product.language) {
                cartShop[i].quantity += 1;
                break;
            } else {
                count++;
            }

        }
        if (count === cartShop.length) {
            // console.log("OTROS")

            cartShop.push(product);
        }
    } else {
        // console.log("PRIMERO")
        cartShop.push(product)

    }

    // console.log(cartShop)
    localSet();

    localGet();
    updateIconCart();
    // console.log("--------------------------------------------------------------")

    return cartShop;
}

function paintCart(cartShop) {
    // console.log(cartShop)
    // localGet();
    const templateCarrito = document.getElementById("template-carrito").content;

    const items = document.getElementById("items");
    const fragment = document.createDocumentFragment();

    eliminarHijos(items);
    // items.innerHTML = "";

    Object.values(cartShop).forEach(dato => {
        templateCarrito.querySelector("img").src = dato.imagen;
        templateCarrito.querySelector("img").href = "Portada de " + dato.title;
        let a = templateCarrito.getElementById("nombreLibro");
        // let a = document.createElement('a');
        a.href = "libro?id=" + dato.id;
        a.textContent = dato.title;
        // templateCarrito.querySelectorAll("td")[1].innerHTML = "";
        // templateCarrito.querySelectorAll("td")[1].textContent = dato.title;
        // templateCarrito.querySelectorAll("td")[2].textContent = dato.subtitle;
        // templateCarrito.querySelectorAll("td")[3].textContent = dato.author;
        templateCarrito.querySelectorAll("td")[2].textContent = dato.format;
        templateCarrito.querySelectorAll("td")[3].textContent = dato.language;
        templateCarrito.querySelectorAll("td")[4].textContent = dato.price;
        templateCarrito.querySelectorAll("td")[5].textContent = dato.quantity;
        templateCarrito.querySelector('.btn-info').dataset.id = dato.position;
        templateCarrito.querySelector('.btn-danger').dataset.id = dato.position;
        templateCarrito.querySelector("span").textContent = (parseFloat(dato.price.replace('€', '')) * dato.quantity);

        const clone = templateCarrito.cloneNode(true);
        fragment.appendChild(clone);
    });


    items.appendChild(fragment);

    pintarFooter()
};

function pintarFooter() {
    const templateFooter = document.getElementById("template-footer").content;

    const footer = document.getElementById("footer");

    const fragment = document.createDocumentFragment();

    footer.innerHTML = "";

    const nQuantity = Object.values(cartShop).reduce((acumulador, { quantity }) => acumulador + quantity, 0);
    const nPrice = Object.values(cartShop).reduce((acumulador, { quantity, price }) => acumulador + quantity * (parseFloat(price.replace('€', ''))), 0);

    templateFooter.querySelectorAll('td')[0].textContent = nQuantity;
    templateFooter.querySelector("span").textContent = nPrice;

    const clone = templateFooter.cloneNode(true)
    fragment.appendChild(clone);

    footer.appendChild(fragment)

    const btnComprar = document.getElementById("btnComprar");
    const vaciarCarrito = document.getElementById("vaciar-carrito");

    vaciarCarrito.addEventListener("click", () => {
        cartShop = [];
        paintCart(cartShop);
        updateIconCart()
        footer.innerHTML = "";
    });

    btnComprar.addEventListener("click", () => {
        if (localStorage.getItem("usuario")) {
            cartShop = [];
            paintCart(cartShop);
            updateIconCart()
            footer.innerHTML = "";
            crearModal("Compra realizada")
            // alert("Compra realizada");
            document.getElementById("compra").firstElementChild.firstElementChild.children[1].firstElementChild.addEventListener("click", ()=>{
                window.location.href = "home";
            });
        }else{
            crearModal("Debes registrarte para comprar")
            document.getElementById("compra").firstElementChild.firstElementChild.children[1].firstElementChild.addEventListener("click", ()=>{
                window.location.href = "acceso";
            });

        }
    });

    //vaciarCarrito.addEventListener("click", emptyCart());
    // btnComprar.addEventListener("click", emptyCart);

}

function crearModal(texto){
    document.getElementById("compra").firstElementChild.firstElementChild.firstElementChild.firstElementChild.textContent = texto;
}

function emptyCart() {
    const footer = document.getElementById("footer");
    cartShop = [];
    paintCart(cartShop);
    updateIconCart()
    footer.innerHTML = "";

}

const btnAccion = e => {
    let borrado = 0;
    let bol = false;
    // console.log("bol " + bol + " borrado  " + borrado)

    for (let i = 0; i < cartShop.length; i++) {
        // console.log("PROBANDO RESTART DATASET")
        // console.log(e.target.dataset.id)
        // console.log(i)
        document.querySelectorAll('.btn-danger')[i].dataset.id = i;
        document.querySelectorAll('.btn-info')[i].dataset.id = i;
        // console.log("DEVOLVIENDO RESTART DATASET")
        // console.log(e.target.dataset.id)
        // console.log(i)
    }

    for (let i = 0; i < cartShop.length; i++) {

        // console.log("pos " + i + " ");
        // console.log(cartShop[i])
        // console.log("bol "+ bol + " borrado  " + borrado)
        // console.log(e.target.classList.contains('btn-danger'))
        // console.log(e.target.dataset.id)
        // console.log(i == e.target.dataset.id)


        //*PARA aumentar cantidad
        if (e.target.classList.contains('btn-info') && i == e.target.dataset.id) {
            // console.log("posicion carrito");
            // console.log(cartShop);

            // let product = cartShop[i].quantity;
            // product++;

            cartShop[i].quantity = ++cartShop[i].quantity;
            //*PARA disminuir cantidad
        } else if (e.target.classList.contains('btn-danger') && i == e.target.dataset.id) {
            // console.log("RESTANDO")
            let product = cartShop[i].quantity;
            product--;
            if (product === 0) {
                borrado = i;
                bol = true;
                break;
            } else {
                cartShop[i].quantity = product;
            }
        }
        // console.log("-----------------------------------------")


    }


    if (bol) {
        cartShop.splice(borrado, 1);
        if (cartShop.length == 0) {
            cartShop = [];
        }


    } else {
        // console.log("no vacio")
    }



    // console.log("-----------------------------------------")
    localSet();
    // ! GET
    localGet();
    updateIconCart()
    paintCart(cartShop);
    e.stopPropagation();
}


function updateIconCart() {
    const numCarrito = document.getElementById("numeroCarrito");
    // console.log("CARTSHOP")
    // console.log(cartShop)

    if (cartShop.length > 0) {
        let cantidades = cartShop.map(x => x.quantity)
        numCarrito.textContent = cantidades.reduce(function (total, x) {
            return total + x;
        }, 0);

    } else {
        numCarrito.textContent = 0;
    }

    localSet();
}

function localGet() {
    if (localStorage.getItem("carrito")) {
        // console.log(localStorage.getItem("carrito"))
        // console.log("lo que quiero ver", JSON.parse(localStorage.getItem("carrito")))

        if (JSON.parse(localStorage.getItem("carrito")).length !== 0)
            cartShop = JSON.parse(localStorage.getItem("carrito"));
    }
}

function localSet() {
    localStorage.setItem("carrito", JSON.stringify(cartShop));
    // console.log(localStorage)

}