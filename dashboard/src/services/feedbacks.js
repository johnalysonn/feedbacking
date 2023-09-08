import axios from 'axios'

const defaultPagination = {
    limit: 5,
    offset: 0
}

export default httpClient => ({
    // todos os feedbacks
    getAll: async ({ type, limit, offset, paramToken, paramToken_db  } = defaultPagination) => {
        const query = { limit, offset, token: paramToken_db}
        const headers = {'Authorization': `Bearer ${paramToken}`}
        const url = 'http://127.0.0.1:8000/api/feedbacks/index'
        if(type) {
            query.type = type
        }
        const response = await axios({
            method: 'get',
            url: url,
            params: query,
            headers: {
                Authorization: 'Bearer ' + paramToken
            }
        })

        return {
            data: response.data
        }
    },
    // tras a contagem dos indices dos feedbacks, quantos sao problemas, ideias e etc..
    getSummary: async () => {
        const response = await httpClient.get('/feedbacks/summary')

        return {
            data: response.data
        }
    },
})