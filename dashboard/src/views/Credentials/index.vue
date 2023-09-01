<template>
    <header-logged/>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center py-5" style="background-color: #F9F9F9">
        <h1 class="fw-bold">Credenciais</h1>
        <p class="">Guia de instalação e geração de suas credenciais</p>
    </div>
    <div class="px-5 py-4 d-flex flex-column gap-3 col-md-6">
        <h2>Instalação e configuração</h2>

        <div>
            <p>Este aqui é sua chave api</p>
            <content-loader
            v-if="store.Global.isLoading || state.isLoading"
            class="rounded rounded-2"
            width="600px"
            height="50px"
            ></content-loader>
            <div v-else class="d-flex align-items-center justify-content-between text-center p-3" style="background-color: #F9F9F9; height: 60px">
                <span v-if="state.hasErrors">Erro ao carregar a apikey</span>
                <label v-else class="fw-bold">{{store.User.currentUser.apiKey}}</label>
                <div class="d-flex gap-3 justify-content-center align-items-center" v-if="!state.hasErrors">
                    <img 
                    @click="handleCopy"
                    src="../../assets/images/copy.svg">
                    <img 
                    @click="handleGenerateApiKey"
                    src="../../assets/images/loading.svg">
                </div>
            </div>
        </div>
         <div>
            <p>Coloque o script abaixo no seu site para começar a receber feedbacks</p>
            <content-loader
            v-if="store.Global.isLoading || state.isLoading"
            class="rounded rounded-2"
            width="600px"
            height="50px"
            ></content-loader>
            <div v-else class="p-3" style="background-color: #F9F9F9; height: 60px">
                <span v-if="state.hasErrors">Erro ao carregar script</span>
                <label v-else class="fw-bold justify-content-center align-items-center d-flex">
                <pre>&lt;script src="http://johnalysonn-feedbacker-widget.netlify.app?api_key={{store.User.currentUser.apiKey}}"&gt;&lt;/script&gt;</pre>
                </label>
            </div>
        </div>
    </div>
</template>
<script>
import HeaderLogged from '../../components/HeaderLogged'
import ContentLoader from '../../components/ContentLoader'
import useStore from '../../hooks/useStore'
import { handleError, reactive, watch } from 'vue'
import services from '@/services'
import { setApiKey } from '@/store/user'
import { useToast } from 'vue-toastification'

export default{
    components: {
        ContentLoader, 
        HeaderLogged
    },
    setup(){
        const store = useStore()
        const toast = useToast()
        const state = reactive({
            isLoading: false,
            hasErrors: false
        })

        watch(() => store.User.currentUser, () => {
            if (!store.Global.isLoading && !store.User.currentUser.apiKey) {
                handleError(true)
            }
        })
        function handleError(error){
            state.isLoading = false
            state.hasErrors = !!error
        }
        async function handleCopy() {
            toast.clear()

            try {
                await navigator.clipboard.writeText(store.User.currentUser.apiKey)

                toast.success('Copiado')
            } catch (error) {
                handleError(error)
            }
        }
        async function handleGenerateApiKey(){
            try {
                toast.clear()

                state.isLoading = true

                const { data } = await services.users.generateApiKey()
                setApiKey(data.apiKey)

                state.isLoading = false
                toast.success(data.message)

            } catch (error) {
                handleError(error)
            }
        }

        return {
            store,
            state,
            handleGenerateApiKey,
            handleCopy
        }
    }
}
</script>
<style scoped>
img{
    cursor: pointer;
}
</style>