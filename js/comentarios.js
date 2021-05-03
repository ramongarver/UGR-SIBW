// Mostrar u ocultar comentarios
function visualizacionComentarios() {
    let comentarios = document.getElementById("contenedor-interno-comentarios");
    let botonComentarios = document.getElementById("botonComentarios");

    // Comprobamos si se está mostrando o no y ocultamos o mostramos
    if (comentarios.style.display === "block") {
        comentarios.style.display = "none"; // Ocultamos
        botonComentarios.innerHTML = "Mostrar comentarios";
    }
    else {
        comentarios.style.display = "block"; // Mostramos como block
        botonComentarios.innerHTML = "Ocultar comentarios";

    }
}

// Añadir comentario al HTML
function enviarComentario() {
    // Obtenemos los valores del formulario
    const nombre = document.getElementById("nombre").value;
    const email = document.getElementById("email").value;
    const texto = document.getElementById("texto-comentario").value;
    const fecha = getFormattedDate();

    // Verificamos que se hayan rellenado todos los campos
    if (nombre.length === 0 || email.length === 0 || texto.length === 0) {
        alert("Por favor, rellene todos los campos antes de enviar su comentario.");
        return;
    }

    // Verificamos que el email sea correcto
    if (!verificarEmail(email)) {
        alert("Por favor, introduzca un email válido.");
        return;
    }

    // Creamos un nuevo comentario
    const nuevoComentario = crearComentario(nombre, fecha, texto);

    // Añadimos el nuevo comentario a los comentarios
    let comentarios = document.getElementById("comentarios");
    comentarios.insertBefore(nuevoComentario, comentarios.firstChild);

    limpiarFormulario();
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById("nombre").value = "";
    document.getElementById("email").value = "";
    document.getElementById("texto-comentario").value = "";
}

// Crear comentario
function crearComentario(nombreC, fechaC, textoC) {
    // Creamos el contenedor de un comentario
    let comentario = document.createElement("div");
    comentario.setAttribute("class", "comentario");

    // Creamos el contenedor del autor del comentario
    let autor = document.createElement("div");
    autor.setAttribute("class", "autor-comentario");
    const autorComentario = document.createTextNode(nombreC + ","); // Creamos el nodo con el texto del nombre
    autor.appendChild(autorComentario);
    comentario.appendChild(autor);

    // Creamos el contenedor de la fecha del comentario
    let fecha = document.createElement("div");
    fecha.setAttribute("class", "fecha-comentario");
    const fechaComentario = document.createTextNode("el " + fechaC + ", comentó:"); // Creamos el nodo con el texto de la fecha
    fecha.appendChild(fechaComentario);
    comentario.appendChild(fecha);

    // Creamos el párrafo del texto de opinión del comentario
    let texto = document.createElement("p");
    texto.setAttribute("class", "texto-comentario");
    const textoComentario = document.createTextNode(textoC); // Creamos el nodo con el texto
    texto.appendChild(textoComentario);
    comentario.appendChild(texto);

    return comentario;
}

// Verificar la expresión regular de un email
function verificarEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Filtrar palabrotas en la escritura de un comentario
function filtrarPalabrotas(palabrotas) {
    let texto = document.getElementById("texto-comentario").value;
    for (const palabra of palabrotas) {
         if (texto.match(palabra.palabrota)) {
            document.getElementById("texto-comentario").value = texto.replace(palabra.palabrota, "*".repeat(palabra.palabrota.length));
        }
    }
}

// Pasar getDay() a texto
function dayToText(date) {
    let day;
    switch (date.getDay()) {
        case 0:
            day = "domingo";
            break;
        case 1:
            day = "lunes";
            break;
        case 2:
            day = "martes";
            break;
        case 3:
            day = "miércoles";
            break;
        case 4:
            day = "jueves";
            break;
        case 5:
            day = "viernes";
            break;
        case 6:
            day = "sábado";
            break;
        default:
            day = "error: no day";
    }
    return day;
}

// Pasar getMonth() a texto
function monthToText(date) {
    let month;
    switch (date.getMonth()) {
        case 0:
            month = "enero";
            break;
        case 1:
            month = "febrero";
            break;
        case 2:
            month = "marzo";
            break;
        case 3:
            month = "abril";
            break;
        case 4:
            month = "mayo";
            break;
        case 5:
            month = "junio";
            break;
        case 6:
            month = "julio";
            break;
        case 7:
            month = "agosto";
            break;
        case 8:
            month = "septiembre";
            break;
        case 9:
            month = "octubre";
            break;
        case 10:
            month = "noviembre";
            break;
        case 11:
            month = "diciembre";
            break;
        default:
            month = "error: no month";
    }
    return month;
}

// Formatear fecha para comentario
function getFormattedDate() {
    const now = new Date().toISOString().
                replace(/T/, ' ').      // replace T with a space
                replace(/\..+/, '')     // delete the dot and everything after

    /*  ... Otra forma de formateo diferente ...
    const hours = ("0" + now.getHours()).slice(-2);
    const minutes = ("0" + now.getMinutes()).slice(-2);
    const day = now.getDate();
    const weekDay = dayToText(now);
    const month = monthToText(now);
    const year = now.getFullYear();
    return weekDay + " " + day + " de " + month + " de " + year + " a las " + hours + ":" + minutes;
    */

    return now;
}