<template>
    <div
    class="d-flex flex-column px-4 py-5 rounded"
    style="background-color: #F9F9F9; cursor: pointer"
    @click="handleToggle"
    >
        <div
        class="d-flex justify-content-between align-items-center w-100 mb-4"
        >
        <badge/>
        <!-- <span>{{feedback.created_at}}</span> -->
        <span
            class="text-secondary"
            style="font-size: .9rem">{{getDiffTimeBetweenCurrentDate(109202300000)}}</span>
        </div>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
                    <span class="text-secondary text-uppercase fw-bold">página</span>
                    <span>https://feedbacker.com/ajuda</span>
                </div>
                <div class="d-flex flex-column">
                    <span class="text-secondary text-uppercase fw-bold">dispositivo</span>
                    <span>Chrome 85.0, macOS 10.14</span>
                </div>
            </div>
            <div 
                class="">
                <div class="d-flex flex-column">
                    <span class="text-secondary text-uppercase fw-bold">usuário</span>
                    <span>g9j0vLMEcN6Ffwxaplxp</span>
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
        feedbacks: { type: Object, required: true },
    },
    setup(props){
        const state = reactive({
            isOpen: props.isOpened,
            isClosing: !props.isOpened
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