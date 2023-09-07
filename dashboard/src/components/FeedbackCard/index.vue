<template>
    <div
    class="d-flex flex-column px-4 py-4 rounded"
    style="background-color: #F9F9F9; cursor: pointer"
    @click="handleToggle"
    >
        <div
        class="d-flex justify-content-between align-items-center w-100 mb-4"
        >
        <badge :type="state.feedback.type"/>
        <span
            class="text-secondary"
            style="font-size: .9rem">{{getDiffTimeBetweenCurrentDate(feedback.created_at)}}</span>
        </div>
        <div 
        class="fw-bold text-dark-emphasis"
        style="font-size: 1.5rem;"
        >
            {{feedback.text}}
        </div>
        <div 
        :class="{
            animate__fadeOutUp: state.isClosing
        }"
        class="d-flex flex-row mt-4 gap-5 animate__animated animate__fadeInUp animate__faster"
        v-if="state.isOpen">
            <div 
                class="d-flex flex-column gap-4">
                <div class="d-flex flex-column">
                    <span class="text-secondary text-uppercase fw-bold"
                    style="font-size: .9rem"
                    >página</span>
                    <span>{{feedback.page}}</span>
                </div>
                <div class="d-flex flex-column">
                    <span class="text-secondary text-uppercase fw-bold"
                    style="font-size: .9rem"
                    >dispositivo</span>
                    <span>{{feedback.device}}</span>
                </div>
            </div>
            <div 
                class="">
                <div class="d-flex flex-column">
                    <span class="text-secondary text-uppercase fw-bold"
                    style="font-size: .9rem"
                    >usuário</span>
                    <span>{{feedback.fingerprint}}</span>
                </div>
            </div>
        </div>
        <div
        v-if="!state.isOpen"
        class="d-flex justify-content-end mt-5 px-3 animate__animated animate__fadeInUp animate__faster"
        >
            <img 
            src="../../assets/images/arrow_down.svg" alt="open">
        </div>
    </div>
</template>

<script>
import Badge from './Badge'
import {getDiffTimeBetweenCurrentDate} from '../../utils/date'
import { reactive } from 'vue'
import {wait} from '../../utils/timeout'

export default {
    components: { Badge },
    props: {
        isOpened: {type: Boolean, default: false},
        feedback: { type: Object, required: true },
    },
    setup(props){
        const state = reactive({
            isOpen: props.isOpened,
            isClosing: !props.isOpened,
            feedback: props.feedback
        })

        async function handleToggle(){
            state.isClosing = true

            await wait(250)
            state.isClosing = false

            return state.isOpen = !state.isOpen
        }

        return {
            handleToggle,
            getDiffTimeBetweenCurrentDate,
            wait,
            state
        }
    }
}
</script>

<style>
label{
    font-size: .9rem;
}
</style>