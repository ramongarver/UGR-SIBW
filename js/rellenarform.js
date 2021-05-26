function rellenarForm(usuario) {
    document.getElementById("username").value = usuario.username;
    document.getElementById("password").value = "pordefecto";
    document.getElementById("email").value = usuario.email;
    document.getElementById("nombre").value = usuario.nombre;
    document.getElementById("apellidos").value = usuario.apellidos;
    let id_genero;
    switch (usuario.genero) {
        case "Hombre":  id_genero = "hombre";   break;
        case "Mujer":   id_genero = "mujer";    break;
        case "Otro":    id_genero = "otro";     break;
    }
    document.getElementById(id_genero).checked = true;
    document.getElementById("fecha_nacimiento").value = usuario.fecha_nacimiento;
    document.getElementById("telefono").value = usuario.telefono;
}
