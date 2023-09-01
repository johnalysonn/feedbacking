const defaultPagination = {
    limit: 5,
    offset: 0
}
export default httpClient => ({
    // todos os feedbacks
    getAll: async ({ type, limit, offset  } = defaultPagination) => {
        const query = { limit, offset}

        if(type) {
            query.type = type
        }

        const response = await httpClient.get('/feedbacks', {params: query})

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
    }
})