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
    let busqueda = document.getElementById("barra-busqueda").value;
    for (let i = 0; i < eventos.length; i++) {
        let enlace = document.createElement('a');
        enlace.setAttribute('id', "enlace-" + eventos[i]['id_evento']);
        enlace.setAttribute('href', "evento/" + eventos[i]['id_evento']);

        let div = document.createElement('div');
        div.setAttribute('id', "evento" + eventos[i]['id_evento']);
        div.setAttribute('class', "evento");
        div.setAttribute('style', "background-image: url('.." + eventos[i]['url_portada'] + "');");

        let h3 = document.createElement('h3');
        let nombreEvento = eventos[i]['nombre'];

        console.log(eventos[i]['nombre']);
        if (busqueda.length) {
            let regexp = new RegExp(busqueda, "gi");
            let restante = nombreEvento;
            do {
                let startBusqueda = restante.search(regexp);
                let endBusqueda = startBusqueda + busqueda.length - 1;

                let inicio = restante.substring(0, startBusqueda);
                h3.appendChild(document.createTextNode(inicio));

                let resaltado = restante.substring(startBusqueda, endBusqueda + 1);
                let span = document.createElement("span");
                span.appendChild(document.createTextNode(resaltado))
                span.style.color = "yellow";
                h3.appendChild(span);
                console.log(resaltado);

                restante = restante.substring(endBusqueda + 1, nombreEvento.length);
            } while(restante.search(regexp) != -1);
            h3.appendChild(document.createTextNode(restante));
        }
        else {
            h3.appendChild(document.createTextNode(nombreEvento));
        }


        let resaltado = document.createElement('span');
        resaltado.setAttribute('class', "resaltado");

        let p = document.createElement('p');
        p.appendChild(document.createTextNode(eventos[i]['fecha']));

        div.appendChild(h3);
        div.appendChild(p);

        enlace.appendChild(div);

        document.getElementById("eventos").appendChild(enlace);
    }
}

