<template>
  <modal-factory/>
  <router-view/>
</template>

<script>
import { watch } from 'vue';
import { useRoute, useRouter } from 'vue-router'
import ModalFactory from './components/ModalFactory/index.vue'
import services from './services'
import { useToast } from 'vue-toastification';
import {setCurrentUser} from './store/user'

export default {
  components: {
      ModalFactory,
  },
  setup () {
    const toast = useToast();
    const router = useRouter();
    const route = useRoute();
  
    watch(() => route.path, async () => {
      if(route.meta.hasAuth){
        const token = window.localStorage.getItem('token');

        if(!token){
          router.push({name: 'home'})
          return
        }

        const { data } = await services.users.getMe()
        setCurrentUser(data.user)
      }
    })

  },
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;1,400&family=Poppins:wght@400;500;600;900&family=Roboto:wght@300;400;500;700;900&display=swap');

  *{
    font-family: 'Roboto';
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
</style>