<template>
    <content-loader
    class="d-flex flex-column p-3 rounded"
    width="100%"
    height="180px"
    >
        <content-loader
        class="mt-3 rounded"
        width="90%"
        height="50px"
        animation-duration="2s"
        />
        <content-loader
        class="mt-3 rounded"
        width="80%"
        height="50px"
        animation-duration="2.3s"
        />
        <content-loader
        class="mt-3 rounded"
        width="85%"
        height="50px"
        animation-duration="2.7s"
        />
        <content-loader
        class="mt-3 rounded"
        width="85%"
        height="50px"
        animation-duration="2.9s"
        />
    </content-loader>
</template>

<script>
import ContentLoader from '../../components/ContentLoader'

export default {
    components: {ContentLoader}
}
</script>
