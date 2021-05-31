function rellenarEvento(evento) {
    document.getElementById("nombre").value = evento.nombre;
    document.getElementById("organizador").value = evento.organizador;
    document.getElementById("lugar").value = evento.lugar;
    document.getElementById("fecha").value = evento.fecha;
    document.getElementById("hora").value = evento.hora;
    document.getElementById("url").value = evento.url;
    document.getElementById("descripcion").value = evento.descripcion;
}
