<template>
    <table class="table table-striped table-sm">
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
            <tr v-for="brand in allBrands" :key="brand.id">
                <td>{{ $filters.formatId(brand.id)}}</td>
                <td>{{ brand.name}}</td>
                <td>{{ brand.description}}</td>
                <td>{{ $filters.formatDate(brand.created_at) }}</td>
                <td>{{ $filters.formatDate(brand.updated_at) }}</td>
                <td>
                    <button class="btn btn-light btn-sm">
                        Editar
                    </button>
                    <button
                        @click="deleteBrand(brand.id)" 
                        class="btn btn-danger btn-sm">
                        Excluir
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import axios from 'axios';
    export default {
        props:['brands'],
        data() {
            return {
                allBrands: []
            }
        },
        created() {
            let brands = JSON.parse(this.brands)
            this.allBrands = brands.data;
        },
        methods: {
            getAllBrands() {
                /*axios.get('/api/brands')
                    .then(response => {
                        this.allBrands = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })*/

            },
            deleteBrand(id) {
                console.log('Deletar a marca com o id: ' + id)
                /*axios.delete('/api/brands/' + id)
                    .then(response => {
                        this.getAllBrands();
                    })
                    .catch(error => {
                        console.log(error)
                    })*/
            }
        }
    }
</script>
