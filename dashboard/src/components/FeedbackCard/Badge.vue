<template>
    <!-- <span
        :class="`bg-${classColor}`"
        
        class="p-2 fw-bold text-uppercase text-white"
    >
        {{label}}
    </span> -->
    <span        
        class="p-2 px-3 fw-bold text-uppercase text-white bg-danger rounded-pill"
        style="font-size: .5rem;"
    >
        problema
    </span>
</template>

<script>
import { computed } from 'vue'
export default {
    props: {
        type: { type: String, required: true}
    },

    setup(props){
        const label = computed(() => {
            if (props.type === 'ISSUE') {
                return 'problema'
            }
            if (props.type === 'IDEA') {
                return 'ideia'
            }  
            
            return 'outros'
        })

        const classColor = computed(() => {
            if (props.type === 'ISSUE') {
                return 'danger'
            }
            if (props.type === 'IDEA') {
                return 'warning'
            }  
            
            return 'secondary bg-opacity-50'
        })

        return {
            label,
            classColor
        }
    }
}
</script>

<style>

</style>