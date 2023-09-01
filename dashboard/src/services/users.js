import useStore from "@/hooks/useStore"

export default httpClient => ({
    getMe: async () => {
        const response = await httpClient.get('/user/show')
    
        return {
            data: response.data
        }
    },

    generateApiKey: async () => {
        const store = useStore()
        const currentUser = store.User.currentUser
        const response = await httpClient.patch(`/user/patch/${currentUser.id}`)

        return {
            data: response.data
        }
    }
    
})