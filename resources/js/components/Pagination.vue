<template>
    <div class="container">
        <p>Pagination</p>
    </div>
</template>

<script>
export default {
    props: ['paginationData'],
    data() {
        return {
            count: 0
        }
    },
    mounted() {
        console.log('Component mounted.')
        console.log(this.paginationData)
    }

}
</script>
