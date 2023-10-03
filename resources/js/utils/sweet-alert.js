const alertSweet = (message, type = 'success', success = () => {} ) => {
    let title = 'Sucesso';
    let icon = 'success';
    let showConfirmButton = false; 
    let showCancelButton = false; 
    let confirmButtonColor = '#2ecc71';
    let cancelButtonColor = '#e74c3c';
    let confirmButtonText = 'OK';
    let cancelButtonText = 'Cancelar';

    switch (type) {
        case 'warning':
            title = 'Atenção';
            icon = 'warning';
            showConfirmButton = true; 
            showCancelButton = true; 
            confirmButtonColor = '#868e96';
            confirmButtonText = 'Sim, prosseguir';
            break;
        case 'error':
        case 'danger':
            title = 'Oops!';
            icon = 'error';
            showConfirmButton = true; 
            break;
    }

    if(!showCancelButton) {
        return Swal.fire({
            title,
            html: message,
            icon,
        }).then((response) => success(response));
    }

    return Swal.fire({
        title,
        html: message,
        icon,
        showCancelButton,
        showConfirmButton,
        confirmButtonColor,
        cancelButtonColor,
        confirmButtonText,
        cancelButtonText
    }).then((response) => {
        if (response.isConfirmed) {
            success(response)
        }
    })
    .catch(error => {
        console.log(error);
            Swal.fire(
                'Oops',
                'Não foi possível executar a ação!!',
                'error'
            )
    });
}

window.alertSweet = alertSweet;