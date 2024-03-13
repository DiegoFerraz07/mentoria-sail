<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                    <button @click="count++">Add +1</button>
                        count: {{count}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        }

    }
</script>
