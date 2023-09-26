function deleteRegistroPaginacao(rotaUrl, idDoRegisto) {
    if (confirm('deseja confirmar a exclusão?')) {
        $.ajax({
            url: rotaUrl,
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: idDoRegisto,
            }, 
            beforeSend: function () {
                $.blockUI({
                    message: 'Carregando...',
                    timeout: 2000,
                });
            },
        }).done(function(data){
            $.unblockUI();
            console.log(data);
        }).fail(function(data) {
            $unblockUI();
            alert('Não foi possivel buscars os dados');
        });
    }
}