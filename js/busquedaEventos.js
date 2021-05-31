function realizarBusqueda(rol) {
    busquedaPeticionAjax(rol);
}

function busquedaPeticionAjax(rol) {
    let datos = new Map();
    datos['busqueda'] = document.getElementById("barra-busqueda").value;
    datos['rol'] = rol;
    datos = JSON.stringify(datos);

    $.ajax({
        data: {datos},
        url: '/js/busquedaEventos.php',
        type: 'post',
        beforeSend: function () {
        },
        success: function(eventos) {
            mostrarEventos(eventos);
        }
    });
}

function mostrarEventos(eventos) {
    $("#eventos").empty();
    console.log(eventos.length);
    for (let i = 0; i < eventos.length; i++) {
        console.log(eventos[i]);

        let enlace = document.createElement('a');
        enlace.setAttribute('id', "enlace-" + eventos[i]['id_evento']);
        enlace.setAttribute('href', "evento/" + eventos[i]['id_evento']);

        let div = document.createElement('div');
        div.setAttribute('id', "evento" + eventos[i]['id_evento']);
        div.setAttribute('class', "evento");
        div.setAttribute('style', "background-image: url('.." + eventos[i]['url_portada'] + "');");

        let h3 = document.createElement('h3');
        h3.appendChild(document.createTextNode(eventos[i]['nombre']));

        let p = document.createElement('p');
        p.appendChild(document.createTextNode(eventos[i]['fecha']));

        div.appendChild(h3);
        div.appendChild(p);

        enlace.appendChild(div);

        document.getElementById("eventos").appendChild(enlace);
    }
}