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
            <div class="bg-warning col-9 pt-5" >
                feedbacks
            </div>
        </div>
    </div>
</template>
<script>
import HeaderLogged from '../../components/HeaderLogged'
import Filters from './Filters'
import FiltersLoading from './FiltersLoading'

export default{
    components: { HeaderLogged, Filters, FiltersLoading }
}
</script>