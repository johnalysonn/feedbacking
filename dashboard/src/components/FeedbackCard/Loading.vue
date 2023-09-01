<template>
    <content-loader
    width='100%'
    height='200px'
    class="p-3 d-flex flex-column gap-5 rounded"
    >
        <div 
            class="d-flex justify-content-between w-100">
            <content-loader
                width='20%'
                height='20px'
                animation-duration="2s"
            />
            <content-loader
                width='25%'
                height='20px'
                animation-duration="2.3s"
            />  
        </div>
        <div class="d-flex flex-column gap-4">
            <content-loader
                    width='100%'
                    height='20px'
                    animation-duration="2.8s"
            />
            <content-loader
                    width='80%'
                    height='20px'
                    animation-duration="3s"
            /><content-loader
                    width='90%'
                    height='20px'
                    animation-duration="3.3s"
            />
        </div>
    </content-loader>
</template>

<script>
import ContentLoader from '../ContentLoader'

export default {
    components: {ContentLoader}
}
</script>

<style>

</style>