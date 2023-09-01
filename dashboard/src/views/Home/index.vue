<template>
    <custom-header
    @create-account="handleCreateAccount"
    @login="handleLogin"
    />
    <contact/>
    <footer class="p-5">
        <p class="text-center">FeedBacker &copy; 2023</p>
    </footer>
</template>
<script>
import CustomHeader from './CustomHeader.vue'
import Contact from './Contact.vue'
import useModal from '../../hooks/useModal'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

export default{
    components: {
        CustomHeader,
        Contact
    },
    setup (){
        const modal = useModal()
        const router = useRouter();
        onMounted(()=>{
            const token = window.localStorage.getItem('token')

            if(token){
                router.push({name: 'feedbacks'});
            }
        })
        function handleLogin(){
            modal.open({
                component: 'ModalLogin'
            })
        }
        function handleCreateAccount(){
            modal.open({
                component: 'ModalAccountCreate'
            })
        }
        return{
            handleLogin,
            handleCreateAccount,
        }
    }
}
</script>
<style scoped>
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
footer{
    background-color: rgb(209, 209, 209);
    color: gray;
}
p{
    font-family:'Roboto';
    font-weight: 800;
}
</style>