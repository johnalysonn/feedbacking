<template>
  <teleport to="body">
    <div 
    v-if="state.isActive"
    class="position-fixed top-0 start-0 d-flex justify-content-center align-items-center vh-100 w-100 bg-dark bg-opacity-50"
    @click="handleModalToogle({status: false})">
        <div 
        @click.stop
        class="position-fixed mx-2" :style="state.width">
            <div class="d-flex flex-column overflow-hidden bg-white rounded rounded-1 animate__animated animate__fadeInDown animate__faster">
                <div class="d-flex flex-column p-4 bg-white">
                    <component :is="state.component"/>
                </div>
            </div>
        </div>
    </div>
  </teleport>
</template>

<script>
import { onMounted, defineAsyncComponent, onBeforeUnmount, reactive } from 'vue'
import useModal from '../../hooks/useModal'

const ModalLogin = defineAsyncComponent(() => import('../ModalLogin'))
const ModalAccountCreate = defineAsyncComponent(() => import('../ModalAccountCreate'))

const DEFAULT_WIDTH = 'width: 30%'

export default {
    components: {
        ModalLogin,
        ModalAccountCreate
    },
    setup (){
        const modal = useModal();
        const state = reactive({
            isActive: false,
            component: {},
            props: {},
            width: DEFAULT_WIDTH,

        })

        onMounted(() => {
            modal.listen(handleModalToogle)
        }) 

        onBeforeUnmount(() => {
            modal.off(handleModalToogle)
        })

        function handleModalToogle(payload){
            if (payload.status) {
                state.component = payload.component
                state.props = payload.props
                state.width = payload.width ?? DEFAULT_WIDTH
            }else{
                state.component = {}
                state.props = {}
                state.width = DEFAULT_WIDTH
            }

            state.isActive = payload.status
        }

        return {
            state,
            handleModalToogle
        }
    }
}
</script>