<template>
    <div class="container" v-if="paginationData">
        <nav role="navigation 3" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                        Showing
                        <span class="font-medium">
                            {{ meta.from }}
                        </span> to
                        <span class="font-medium">
                            {{ meta.to }}
                        </span> of
                        <span class="font-medium">
                            {{ meta.total }}
                        </span> results
                    </p>
                </div>
                <div>
                    <span
                        class="container-previous-custom relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                        <span v-for="(link, key) in meta.links" class="container-button" :key="key" aria-current="page">
                            <span v-if="link.active && link.url"
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600"
                                v-html="link.label">
                            </span>

                            <span v-if="!link.active && link.url" @click="clickPage(link.url)"
                                class="relative active inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800"
                                style="cursor: pointer;" v-html="link.label">
                            </span>
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    </div>
</template>

<style scoped >
    .active {
        color: #245dc5;
    }
    .active:hover {
        background-color: #d8d8d8 !important;
    }
</style>

<script>
export default {
    props: ['paginationData', 'goPage'],
    data() {
        return {
            meta: this.paginationData.meta,
            links: this.paginationData.links
        }
    },
    mounted() {
    },
    methods: {
        clickPage(url) {
            this.$emit('goPage', url)
        }
    }

}
</script>
