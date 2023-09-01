<template>
    <header>
        <nav class="navbar navbar-expand-lg" style="padding: 20px 100px">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="../../assets/images/logo_white.png"  alt="Logo" style="width: 20%"></a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item me-4">
                            <a
                            @click="() => router.push({name: 'credentials'})" 
                            class="nav-link text-white fw-medium" aria-current="page" href="#">Credenciais</a>
                        </li>
                        <li class="nav-item me-4">
                            <a 
                            @click="() => router.push({name: 'feedbacks'})" 
                            class="nav-link text-white fw-medium" aria-current="page" href="#">Feedbacks</a>
                        </li>
                        <li class="nav-item">
                            <a
                            @click="handleLogout"
                             class="nav-link rounded rounded-pill px-4 bg-white a-hover fw-bold" id="a-link" aria-current="page" href="#">
                            {{logoutLabel}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { clearCurrentUser } from '../../store/user';
import { useRouter } from 'vue-router'
import { computed } from 'vue';
import useStore from '../../hooks/useStore';
import { useToast } from 'vue-toastification';
export default {
    setup(){
        const router = useRouter();
        const store = useStore('User');
        const toast = useToast();

        const logoutLabel = computed(() => {
            if(!store.currentUser.name){
                return '...'
            }
            return `${store.currentUser.name} (sair)`
        })

        function handleLogout(){
            window.localStorage.removeItem('token')
            window.localStorage.removeItem('token_db')
            toast.success('Logout realizado com sucesso')
            clearCurrentUser()
            router.push({name: 'home'})
        }
        return {
            router,
            logoutLabel,
            handleLogout
        }
    }
}
</script>

<style scoped>
header{
    background-color: #EF4983;
}
#a-link{
    color: #EF4983;
}
</style>