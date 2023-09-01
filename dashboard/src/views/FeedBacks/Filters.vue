<template>
    <div class="d-flex flex-column">
        <p class="fs-5 text-secondary-emphasis">Filtros</p>

        <ul class="d-flex flex-column list-unstyled">
            <!-- <li
            v-for="filter in state.filters"
            :key="filter.label"
            :class="{'bg-secondary bg-opacity-50' : filter.active}"
            @click="() => handleSelect(filter)"
            >
                <span
                :class="`bg-${filter.color}`"
                class="rounded rounded-circle"/>
                {{filter.label}}

                <label
                :class="filter.active? `text-${filter.color}` : 'text-secondary'"
                class="fw-bold"
                >{{filter.amount}}</label>
                l
            </li> -->
            <li class="d-flex align-items-center justify-content-between px-4 py-1 bg-secondary-subtle bg-opacity-50 rounded" style="cursor: pointer">
                <div class="d-flex align-items-center">
                    <span
                    class="rounded rounded-circle bg-info me-3 p-1"/>
                    Todos
                </div>
                <label
                    class="fw-bold text-info"
                    >300</label>
            </li>
            <li class="d-flex align-items-center justify-content-between px-4 py-1 " style="cursor: pointer">
                <div class="d-flex align-items-center">
                    <span
                    class="rounded rounded-circle bg-danger me-3 p-1"/>
                    Problemas
                </div>
                <label
                    class="fw-bold text-secondary"
                    >150</label>
            </li>
            <li class="d-flex align-items-center justify-content-between px-4 py-1 " style="cursor: pointer">
                <div class="d-flex align-items-center">
                    <span
                    class="rounded rounded-circle bg-warning me-3 p-1"/>
                    Ideias
                </div>
                <label
                    class="fw-bold text-secondary"
                    >50</label>
            </li>
            <li class="d-flex align-items-center justify-content-between px-4 py-1 " style="cursor: pointer">
                <div class="d-flex align-items-center">
                    <span
                    class="rounded rounded-circle bg-secondary me-3 p-1"/>
                    Outros
                </div>
                <label
                    class="fw-bold text-secondary"
                    >100</label>
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
    all: 'bg-info',
    issue: 'bg-danger',
    idea: 'bg-warning',
    other: 'bg-secondary'
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
                { label:null, amount:null }
            ]
        })

        try {   
            const {data} = await services.feedbacks.getSummary()
            state.filters = applyFiltersStructure(data)
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
