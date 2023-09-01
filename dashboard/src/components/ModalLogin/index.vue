<template>
  <div>
    <div class="d-flex justify-content-between mb-3">
        <p class="fs-3 fw-bold ms-3">Entre na sua conta</p>
        <span
        @click="close"
        class="fs-2"
        style="color: gray; cursor: pointer;"
        >&times;</span>
    </div>
    <div class="d-flex flex-column gap-5 px-3">
      <form @submit.prevent="handleSubmit" class="d-flex flex-column gap-5">
        <div class="d-flex flex-column gap-4">
          <div class="d-flex flex-column input-group gap-2">
            <label class="fw-medium">E-mail</label>
            <input 
            v-model="state.email.value"
            :class="{'border border-2 border-danger' : !!state.email.errorMessage}"
            class="border-2 rounded rounded-1 p-1 px-2" 
            style="border-color: transparent"
            type="email" name="email" id="email">
            <span
            v-if="!!state.email.errorMessage"
            class="fw-medium text-danger"
            style="font-size: 12px"
            >{{state.email.errorMessage}}</span>
          </div>
          <div class="d-flex flex-column input-group gap-2">
            <label class="fw-medium">Senha</label>
            <input 
            v-model="state.password.value"
            :class="{'border border-2 border-danger' : !!state.password.errorMessage}"
            class="border-2 rounded rounded-1 p-1 px-2" 
            style="border-color: transparent"
            type="password" name="password" id="password">
            <span
            v-if="!!state.password.errorMessage"
            class="fw-medium text-danger "
            style="font-size: 12px"
            >{{state.password.errorMessage}}</span>
          </div>
        </div>
        <div>
          <button 
          :disabled="state.isLoading"
          :class="{'opacity-50' : state.isLoading}"
          type="submit"
          class="text-white border-0 rounded rounded-pill p-2 px-5"
          style="background-color: rgba(239, 73, 131, 1);"
          >
          <img v-if="state.isLoading" src="../../assets/images/loading.png" class="w-75">
          <span v-else>Entrar</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { reactive } from 'vue'
import { useField } from 'vee-validate'
import useModal from '../../hooks/useModal'
import { validateEmptyAndLength3, validateEmptyAndEmail } from '../../utils/validators'
import services from '../../services'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

export default {
  setup(){
    const router = useRouter();
    const toast = useToast();

    const {
      value: emailValue,
      errorMessage: emailErrorMessage
    } = useField('email', validateEmptyAndEmail)
    const {
      value: passwordValue,
      errorMessage: passwordErrorMessage
    } = useField('password', validateEmptyAndLength3)

    const modal = useModal();
    const state = reactive({
      hasErrors: false,
      isLoading: false,
      email: {
        value: emailValue,
        errorMessage: emailErrorMessage,
      },
      password: {
        value: passwordValue,
        errorMessage: passwordErrorMessage,
      }
    })

    async function handleSubmit(){
      try {
        toast.clear();
        state.isLoading = true
        const {data, errors, messageSuccess} = await services.auth.login({
          email: state.email.value,
          password: state.password.value
        })

        if(!errors){
          window.localStorage.setItem('token', data.token.value)
          window.localStorage.setItem('token_db', data.token.db_value)
          router.push({name: 'feedbacks'})
          state.isLoading = false
          toast.success(messageSuccess)
          modal.close() 
          return
        }

        if(errors){
          toast.error(errors.statusText);
        }

        state.isLoading = false

      } catch (errors) {
        console.log(errors)
        state.isLoading = false,
        state.hasErrors = !!errors,
        toast.error('Erro ao fazer o login')
      }
    }

    return {
      state,
      close: modal.close,
      handleSubmit
    };
  }
}
</script>

<style>
input[type="email"], input[type="password"]{
  background-color: rgb(240, 240, 240);
  font-family: 'Roboto';
  font-weight: 700;
}
button img{
  animation: loading 2s linear infinite;
}

@keyframes loading {
    0% {
        transform: rotate(0)
    }

    100% {
        transform: rotate(-360deg)
    }
}
</style>