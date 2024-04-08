<template>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Marcas</h1>
    </div>
    <div>
        <input type="text" id="input-search" @keyup="handleInputSearch" required minlength="3" v-model="search"
            placeholder="Digite o nome" />
        <button @click="find()"> pesquisar </button>
        <button v-if="search" @click="clearSearch" class="btn btn-danger btn-sm">
            Limpar Pesquisa
        </button>
        <a type="button" :href="route('types.add')" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            <p v-if="!types"> Não existe dados </p>
            <table v-if="types" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Data de Criação</th>
                        <th>Data de Edição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(type, key) in types" :key="key">
                        <td>{{ type.id }}</td>
                        <td>{{ type.name }}</td>
                        <td>{{ type.description }}</td>
                        <td>{{ format_date(type.created_at) }}</td>
                        <td>{{ format_date(type.updated_at) }}</td>
                        <td>
                            <button :href="route('types.edit', { id: type.id })" class="btn btn-light btn-sm">
                                Editar
                            </button>
                            <button @click="confirmDeleteTypes(type.id, type.name)" class="btn btn-danger btn-sm">
                                Excluir
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style scoped>
.is-invalid {
    border-color: #dc3545;
    border-width: 2px;
    border-style: solid;
}
</style>
<script>
import moment from 'moment';
import axios from 'axios';
import PaginationVue from '../../components/Pagination.vue';
const alertSwal = window.alertSweet;
export default {
    components: {
        PaginationVue
    },
    data() {
        return {
            types: [],
            paginationData: null,
            search: '',
        }
    },
    created() {
        this.getAllTypes();
    },
    methods: {
		format_date(value){
         if (value) {
           return moment(String(value)).format('DD/MM/YYYY')
          }
      	},
        getAllTypes() {
            axios.get(route('api.brand.index'))
                .then(response => {
                    console.log(response)
                    this.types = response.data.data
                    this.paginationData = {
                        links: response.data.links,
                        meta: response.data.meta
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        confirmDeleteTypes(id, name) {

            alertSwal(
                `Deseja realmente excluir o tipo <b>"${name}"</b>?`,
                'warning',
                success => {
                    this.deleteType(id);
                }
            );
        },

        deleteType(id) {
            axios.delete(route('api.types.delete'), {
                data: {
                    id,
                }
            })
                .then(response => {
                    if (response.data.success) {
                        alertSweet(
                            'Excluido com sucesso',
                            'success',
                            success => {
                                this.getAllTypes();
                            }
                        );
                    }
                })
                .catch(error => {
                    alertSweet(
                        'Não foi possivel excluir!!',
                        'error'
                    )
                });
        },
        handleInputSearch() {
            const inputSearch = document.getElementById('input-search');
            inputSearch.classList.remove('is-invalid');

            console.log(this.search)
            if (this.search.length < 3 && this.search.length > 0) {
                inputSearch.classList.add('is-invalid');
                return false;
            }

            return true;
        },
        find() {

            if (!this.handleInputSearch()) {
                return;
            }

            axios.post(route('api.types.find'), { search: this.search })
                .then(response => {
                    this.types = response.data.data
                    this.paginationData = {
                        links: response.data.links,
                        meta: response.data.meta
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        clearSearch() {
            this.search = '';
            this.getAllTypes()
        }
    }
}
</script>
