<template>
    <div class="d-flex flex-column">
        <p class="fs-5 text-secondary-emphasis">Filtros</p>

        <ul class="d-flex flex-column list-unstyled">
            <li
            v-for="filter in state.filters"
            :key="filter.label"
            :class="{'bg-secondary bg-opacity-50' : filter.active}"
            class="d-flex align-items-center justify-content-between rounded px-4 py-1"
            style="cursor: pointer"
            @click="() => handleSelect(filter)"
            >
                <div class="d-flex align-items-center">
                    <span
                    :class="`bg-${filter.colors}`"
                    class="rounded rounded-circle me-3 p-1"/>
                    {{filter.label}}
                </div>
                
                <label
                    :class="filter.active? `text-${filter.colors}` : 'text-secondary'"
                    class="fw-bold"
                    >{{filter.amount}}</label>
            </li>
        </ul>
    </div>
</template>

<script>
import { reactive } from 'vue'
import useStore from '@/hooks/useStore'
import services from '@/services'

const LABELS = {
    all: 'Todos',
    issue: 'Problemas',
    idea: 'Ideias',
    other: 'Outros'
}
const COLORS ={
    all: 'info',
    issue: 'danger',
    idea: 'warning',
    other: 'secondary'
}

function applyFiltersStructure (summary){
    return Object.keys(summary).reduce((acc, cur) => {
        const currentFilter = {
            label: LABELS[cur],
            colors: COLORS[cur],
            amount: summary[cur]
        }

        if (cur === 'all') {
            currentFilter.active = true
        }
        else{
            currentFilter.type = cur
        }

        return [...acc, currentFilter]
    }, [])
}

export default {
    async setup(props, {emit}){
        const store = useStore('Global')
        const state = reactive({
            hasErrors: false,
            filters: [
                { label:null, amount:null, colors:null }
            ]
        })

        try {   
            const {data} = await services.feedbacks.getSummary()
            state.filters = applyFiltersStructure(data.response)
        } catch (error) {
            state.hasErrors = !!error
            state.filters = applyFiltersStructure({all: 0, issue: 0, idea: 0, other: 0})
        }

        function handleSelect({type}){
            if(store.isLoading){
                return
            }

            state.filters = state.filters.map((filter) => {
                if(filter.type === type){
                    return {...filter, active: true}
                }

                return {...filter, active:false}
            })

            emit('select', type)
        }

        return {state, handleSelect}
    }
}
</script>
