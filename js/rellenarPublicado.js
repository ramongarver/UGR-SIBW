function rellenarPublicado(eventos) {
    for (let i = 0; i < eventos.length; i++){
        document.getElementById("publicado"+eventos[i].id_evento).checked = eventos[i].publicado == 1;
    }
}