<template>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fornecedores</h1>
    </div>
    <div>
        <input type="text" id="input-search" @keyup="handleInputSearch" required minlength="3" v-model="search" placeholder="Digite o nome" />
        <button @click="find()"> pesquisar </button>
        <button v-if="search" @click="clearSearch" class="btn btn-danger btn-sm">
            Limpar Pesquisa
        </button>
        <a type="button" :href="route('supply.add')" class="btn btn-success float-end">
            Adicionar
        </a>
        <div class="table-responsive mt-4">
            <p v-if="!supplies"> Não existe dados </p>
            <table v-if="supplies" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>cnpj</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(supply, key) in supplies " :key="key">
                        <td>{{ supply.id }}</td>
                        <td>{{ supply.name }}</td>
                        <td>{{ supply.cnpj }}</td>
                        <td>
                            <a :href="route('supply.edit', { id: supply.id })" class="btn btn-light btn-sm">
                                Editar
                            </a>
                            <button @click="confirmDeleteSupply(supply.id,  supply.name)" class="btn btn-danger btn-sm">
                                Excluir
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <PaginationVue />
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
import axios from 'axios';
const alertSwal = window.alertSweet;
import PaginationVue from '../../components/Pagination.vue';

export default {
    components: {
        PaginationVue
    },
    data() {
        return {
            supplies: [],
            paginationData: null,
            search: '',
        }
    },
    created() {
        this.getAllSupplies();
    },
    methods: {
        getAllSupplies() {
            axios.get(route('api.supply.index'))
                .then(response => {
                    console.log(response)
                    this.supplies = response.data.data
                    this.paginationData = {
                        links: response.data.links,
                        meta: response.data.meta
                    }
                })
                .catch(error => {
                    console.log(error)
                })

        },
        confirmDeleteSupply(id, name) {
            alertSwal(
                `Deseja realmente excluir o fornecedor <b>"${name}"</b>?`,
                'warning',
                success => {
                    this.deleteSupply(id);
                }
            );
        },
        deleteSupply(id) {
            axios.delete(route('api.supply.delete'), {
                data: {
                    idForne: id,
                }
            })  .then(response => {
                response = response.data;
                    if (response.data.success) {
                        alertSweet(
                            'Excluído com sucesso',
                            'success',
                            success => {
                                this.getAllSupplies();
                            }
                        );
                    }
                })
                .catch(error => {
                    alertSweet(
                        'Não foi possível excluir!!',
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
            
            if(!this.handleInputSearch()) {
                return;
            }

            axios.post(route('api.supply.find'), {search: this.search})
                .then(response => {
                    this.supplies = response.data.data
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
            this.getAllSupplies()
        }
    }
}
</script>
