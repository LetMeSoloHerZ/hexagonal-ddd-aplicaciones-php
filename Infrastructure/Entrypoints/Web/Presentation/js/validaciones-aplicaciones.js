/**
 * Validaciones del lado del cliente para el modulo de aplicaciones.
 * Son una ayuda de usabilidad: el servidor y el dominio validan de nuevo.
 */

/**
 * Solicita confirmacion antes de eliminar una aplicacion.
 * El formulario debe traer data-name con el nombre de la aplicacion.
 *
 * @param {HTMLFormElement} form
 * @returns {boolean}
 */
function confirmDeleteAplicacion(form) {
    var name = form.getAttribute('data-name');
    return confirm('¿Eliminar la aplicación ' + name + '?');
}

/**
 * Valida el formulario de registro/edicion de aplicaciones.
 *
 * @param {HTMLFormElement} form
 * @returns {boolean} false si hay errores (cancela el envio)
 */
function validateAplicacionForm(form) {
    var errors = [];
    var value = function (name) {
        var field = form.elements[name];
        return field ? String(field.value).trim().replace(',', '.') : '';
    };

    var nombre = value('nombre');
    if (nombre.length < 2 || nombre.length > 100) {
        errors.push('El nombre debe tener entre 2 y 100 caracteres.');
    }

    if (value('proveedor') === '') {
        errors.push('El proveedor es obligatorio.');
    }

    var principal = value('lenguajePrincipal');
    var secundario = value('lenguajeSecundario');
    if (principal === '') {
        errors.push('El lenguaje principal es obligatorio.');
    }
    if (secundario !== '' && secundario.toLowerCase() === principal.toLowerCase()) {
        errors.push('El lenguaje secundario debe ser distinto del principal.');
    }

    var licencia = value('licencia');
    var precioTexto = value('precio');
    var precio = Number(precioTexto);
    if (precioTexto === '' || isNaN(precio) || precio < 0) {
        errors.push('El precio debe ser un número mayor o igual a cero.');
    } else if ((licencia === 'GRATUITA' || licencia === 'OPEN_SOURCE') && precio > 0) {
        errors.push('Una licencia ' + licencia + ' debe tener precio 0.');
    } else if (licencia === 'COMERCIAL' && precio <= 0) {
        errors.push('Una licencia COMERCIAL debe tener un precio mayor que 0.');
    }

    var web = value('web');
    if (web !== '' && !/^https?:\/\/\S+$/i.test(web)) {
        errors.push('La web debe empezar por http:// o https://.');
    }

    var correo = value('correo');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        errors.push('El correo no tiene un formato válido.');
    }

    var tamanoTexto = value('tamanoInstalador');
    var tamano = Number(tamanoTexto);
    if (tamanoTexto === '' || isNaN(tamano) || tamano <= 0) {
        errors.push('El tamaño del instalador debe ser un número mayor que cero.');
    }

    if (errors.length > 0) {
        alert('Corrige lo siguiente:\n\n- ' + errors.join('\n- '));
        return false;
    }

    return true;
}

/**
 * Filtra las filas de una tabla segun el texto escrito en el buscador.
 *
 * @param {HTMLInputElement} input
 * @param {string} tableId
 */
function filterAplicaciones(input, tableId) {
    var term = input.value.toLowerCase();
    var rows = document.querySelectorAll('#' + tableId + ' tbody tr');

    for (var i = 0; i < rows.length; i++) {
        var text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.indexOf(term) === -1 ? 'none' : '';
    }
}
