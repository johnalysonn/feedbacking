import axios from 'axios'
import AuthService from './auth'
import router from '../router'
import UsersService from './users'
import FeedbacksService from './feedbacks'
import { setGlobalLoading } from '../store/global'

const API_ENVS = {
    production: '',
    development: '',
    local: 'http://127.0.0.1:8000/api'
}

const httpClient = axios.create({
    baseURL: API_ENVS.local
})

httpClient.interceptors.request.use(config => {
    setGlobalLoading(true)
    const token = window.localStorage.getItem('token')
    const token_db = window.localStorage.getItem('token_db')

    if(token){
        config.headers.Authorization = `Bearer ${token}`
        config.params = {token: token_db}
    }
    return config
}),

httpClient.interceptors.response.use((response) => {
    setGlobalLoading(false)
    
    return response
}, (error) => {
    const canThrowAnError = error.request.status === 0 ||
    error.request.status === 500

    if(canThrowAnError){
        setGlobalLoading(false)
        throw new Error(error.message)
    }

    if(error.request.status === 401){
        router.push({name: 'home'})
    }

    setGlobalLoading(false)
    return error
})

export default {
    auth: AuthService(httpClient),
    users: UsersService(httpClient),
    feedbacks: FeedbacksService(httpClient)
}