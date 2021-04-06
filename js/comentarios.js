function visualizacionComentarios() {
    let comentarios = document.getElementById("contenedor-interno-comentarios");
    let botonComentarios = document.getElementById("botonComentarios");

    if (comentarios.style.display === "block") {
        comentarios.style.display = "none";
        botonComentarios.innerHTML = "Mostrar comentarios";
    }
    else {
        comentarios.style.display = "block";
        botonComentarios.innerHTML = "Ocultar comentarios";

    }
}

function enviarComentario() {

}