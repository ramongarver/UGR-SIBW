function rellenarComentario(comentario) {
    console.log(comentario);
    document.getElementById("nombre").value = comentario.nombre;
    document.getElementById("email").value = comentario.email;
    document.getElementById("texto-comentario").value = comentario.comentario;
}
