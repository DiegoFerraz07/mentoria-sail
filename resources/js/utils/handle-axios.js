const handleRequest = ({
    method = 'post',
    url, 
    data, 
    header = {}, 
    successCallback = null,
    errorCallback = null,
}) => {
    
    header = {
        'Content-Type': 'application/json',
        'Access-Control-Request-Method': '*',
        ...header
    }
    
    axios({
        method,
        url,
        data,
        header
    }).then(response => {
        let apiResponse = response.data;

        if(apiResponse.data) {
            apiResponse = apiResponse.data;
        }
        
        if(apiResponse.success) {
            if(typeof successCallback == 'function' && successCallback) {
                return successCallback();
            }

            let messageSuccess = 'Salvo com Sucesso!!';
            if(apiResponse.message) {
                messageSuccess = apiResponse.message;
            }

            alertSweet(
                messageSuccess,
                'success',
            );
        } else {
            if(typeof errorCallback == 'function' && errorCallback) {
                return errorCallback();
            }

            let message = 'Não foi possivel Salvar!!';
            if(apiResponse.message) {
                message = apiResponse.message;
            }
            alertSweet(
                message,
                'error'
            )
        }
        return true;
    })
    .catch(error => {
        if(typeof errorCallback == 'function' && errorCallback) {
            return errorCallback();
        }
        alertSweet(
            'Não foi possivel Salvar!!',
            'error'
        )
    })

}


window.handleAxios = handleRequest;