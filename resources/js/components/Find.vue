<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <input class="form-control" 
                    type="text" 
                    :id="idInput || 'input-search'" 
                    @keyup="(event) => inputKeyup(event.target.value)" 
                    required 
                    minlength="3"
                    :value="search" 
                    placeholder="Digite o nome" />
            </div>
            <div class="col-md-4 flex-btn-container">
                <button class="btn btn-danger  btn-no-margin-top" 
                    v-if="search" 
                    @click="btnClearClick()">
                    {{ clearSearchText || 'Limpar Pesquisa' }}
                </button>
                <button class="btn btn-primary btn-block" 
                @click="btnFindClick()"> 
                    {{ searchText || 'Pesquisar' }} 
                </button>
            </div>
        </div>
        <div class="container-add">
            <a type="button" :href="routeAddNew" class="btn btn-success float-end btn-w300">
                {{ textAddNew  || 'Adicionar' }}
            </a>
        </div>
    </div>
</template>

<style scoped>
.flex-btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.btn-no-margin-top {
    margin-top: 0;
}

.container-add {
    display: flex;
    justify-content: start;
    align-items: center;
    margin-top: 5px;
}

.btn-w300 {
    width: 300px;
}
</style>



<script>
export default {
    props: [
        'idInput',
        'search',
        'inputKeyup',
        'btnClearClick',
        'btnFindClick',
        'routeAddNew',
        'textAddNew',
        'clearSearchText',
        'searchText'
    ],
    data() {
        return {
        }
    },
    created() {
    },
    methods: {
    }

}
</script>
