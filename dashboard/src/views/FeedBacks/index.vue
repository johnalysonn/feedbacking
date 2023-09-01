<template>
    <header-logged/>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center py-5" style="background-color: #F9F9F9">
        <h1 class="fw-bold">Feedbacks</h1>
        <p class="">Detalhe de todos os feeebacks recebidos.</p>
    </div>
    <div class="w-100 px-5 py-3 d-flex justify-content-center">
        <div class="d-flex w-100 gap-5 px-5">
            <div class="col-3">
                <p class="fs-3 fw-bold">Listagem</p>
                <suspense>
                    <template #default>
                        <filters class="animate__animated animate__fadeInDown animate__faster"/>
                    </template>
                    <template #fallback>
                        <filters-loading class="mt-5"/>
                    </template>
                </suspense>
            </div>
            <div class="col-9 pt-5" >
                <p 
                class="text-center "
                v-if="state.hasError"
                >Erro ao exibir os feedbacks 😢
                </p>
                <!-- <p 
                class="text-center "
                v-if="!state.feedbacks.length && !state.isLoading"
                >Nenhum feedback recebido 😎
                </p> -->

                <feedback-card-loading v-if="state.isLoading"/>
                <!-- <feedback-card
                v-else
                v-for="(feedback, index) in state.feedbacks"
                :key="feedback.id"
                :is-opened="index === 0"
                :feedback="feedback"
                class="mb-3"
                /> -->
                <feedback-card v-else
                :is-opened="true"/>
                
            </div>
        </div>
    </div>
</template>
<script>
import { onMounted, reactive } from 'vue'
import HeaderLogged from '../../components/HeaderLogged'
import Filters from './Filters'
import FiltersLoading from './FiltersLoading'
import FeedbackCardLoading from '../../components/FeedbackCard/Loading'
import FeedbackCard from '../../components/FeedbackCard'

export default{
    components: { HeaderLogged, Filters, FiltersLoading, FeedbackCardLoading, FeedbackCard},

    setup (){
        const state = reactive({
            isLoading: false,
            feedbacks: [],
            hasError: false,
            currentFeedbackType: '',
            pagination: {
                limit: 5,
                offset: 0
            }
        })

        onMounted(() => {
            fetchFeedbacks()
        })
        function handleError(error){
            state.hasError = !!error
        }

        async function fetchFeedbacks(){
            // try {
            //     state.isLoading = true

            //     const {data} = await services.feedbacks.getAll({
            //         ...state.pagination,
            //         type: state.currentFeedbackType
            //     })

            //     state.feedbacks = data.results
            //     state.pagination = data.pagination
            //     state.isLoading = false

            // } catch (error) {
            //     handleError(error)
            // }
        }

        return {
            state,
            handleError
        }
    }
}
</script>