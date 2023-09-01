export default httpCliente => ({
    register: async({name, email, password}) => {
        const response = await httpCliente.post('/user/store', {
            name,
            email,
            password
        })

        const messageRegister = {
            success: "Usuário criado com sucesso"
        }

        let errors = null
        let messageSuccess = null

        if(!response.data){
            errors = {
                status: response.request.status,
                statusText: response.request.statusText
            }
        }
    
        if(response.data.message === messageRegister.success){
            messageSuccess = messageRegister.success
            errors = null
        }
        return {
            data: response.data,
            messageSuccess,
            errors
        }
    
    },
    login: async ({email, password}) => {
        const response = await httpCliente.post('/user/login', {
            email,
            password
        })

        const messageAuth = {
            isInvalid: "E-mail ou senha inválidos",
            logged: "Usuário logado com sucesso"
        }
        let errors = null
        let messageSuccess = null

        if(!response.data){
            errors = {
                status: response.request.status,
                statusText: response.request.statusText
            }
        }
        if(response.data.message === messageAuth.isInvalid){
            errors = {
                status: 401,
                statusText: messageAuth.isInvalid
            }
        }
        if(response.data.message === "Usuário logado com sucesso"){
            messageSuccess = "Usuário logado com sucesso"
            errors = null
        }
        return {
            data: response.data,
            messageSuccess,
            errors
        }

    }
})