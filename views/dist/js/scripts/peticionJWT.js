


function peticionJWT(opciones) {
    let token = localStorage.getItem('token');

    if (!token) {
        window.location = urlCliente + 'login';
        return;
    }

    $.ajax({
        ...opciones,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            if (typeof opciones.beforeSend === 'function') {
                opciones.beforeSend(xhr);
            }
        },
        error: function (jqXHR) {
            if (jqXHR.status === 401) {
                // Token expirado o inválido
                localStorage.removeItem('token');
                window.location = urlCliente + 'login';
            } else if (typeof opciones.error === 'function') {
                // Si el usuario definió su propio error
                opciones.error(jqXHR);
            } else {
                console.error('Error en la petición:', jqXHR.status, jqXHR.responseText);
            }
        }
    });
}
