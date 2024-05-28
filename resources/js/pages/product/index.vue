<template>
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Produtos</h1>
	</div>
	<div>
		<Find idInput="input-search"
        	:search="search"
        	:inputKeyup="(search) => handleInputSearch(search)"
			:btnClearClick="() => clearSearch()"
        	:btnFindClick="() => find()"
			:routeAddNew="route('product.add')"
        	textAddNew="Adicionar novo Produto"
			clearSearchText="Limpar Pesquisa"
			searchText="Pesquisar Produto" />

		<div class="table-responsive mt-4">
			<p v-if="!products"> Não existe dados </p>
			<table v-if="products" class="table table-hover table-striped table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Valor</th>
						<th>Tipos</th>
						<th>Marcas</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody v-for="(product, key) in products " :key="key">
					<tr>
						<td>{{ product.id }}</td>
						<td>{{ product.nome }}</td>
						<td>R$: {{ formatPrice(product.valor) }}</td>
						<td>
							<span v-for="(type, key) in product.types" :key="key" class="badge badge-primary mr-1">{{type.name}}</span>
						</td>

						<td>
							<span v-if="product.brand" class="badge badge-primary">{{ product.brand.name }}</span>
						</td>

						<td>
							<a :href="route('product.edit', { id: product.id })" class="btn btn-light btn-sm">
								Editar
							</a>
							<button @click="confirmDeleteProduct(product.id, product.nome)"
								class="btn btn-danger btn-sm">
								Excluir
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<PaginationVue v-if="paginationData" 
                :pagination-data="paginationData"
                @go-page="(url) => getAllProducts(url)" />
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
import Find from '../../components/Find.vue';
import PaginationVue from '../../components/Pagination.vue';


export default {
	components: {
		PaginationVue,
		Find
	},
	data() {
		return {
			products: [],
			paginationData: null,
			search: '',
		}
	},
	created() {
		this.getAllProducts();
	},
	methods: {
		getAllProducts(goPage = '') {
			let url = route('api.product.index')
			if(goPage) {
                url = goPage;
            }

			this.paginationData = null;
			axios.get(url)
				.then(response => {
					console.log(response)
					this.products = response.data.data
					this.paginationData = {
						links: response.data.links,
						meta: response.data.meta
					}
				})
				.catch(error => {
					console.log(error)
				})

		},
		formatPrice(value) {
			let val = (value/1).toFixed(2).replace('.', ',')
        	return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    	},

		confirmDeleteProduct(id, nome) {
			alertSwal(
				`Deseja realmente excluir o produto <b>"${nome}"</b>?`,
				'warning',
				success => {
					this.deleteProduct(id);
				}
			);
		},

		deleteProduct(id) {
			axios.delete(route('api.product.delete'), {
				data: {
					id: id,
				}
			})
				.then(response => {
					let dataResp = response.data;
					if (dataResp.data) {
						dataResp = dataResp.data;
					}
					if (dataResp.success) {
						alertSweet(
							'Excluido com sucesso',
							'success',
							success => {
								this.getAllProducts();
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
		handleInputSearch(search) {
			this.search = search;
			const inputSearch = document.getElementById('input-search');
			if(inputSearch) {
				inputSearch.classList.remove('is-invalid');
	
				if (this.search.length < 3 && this.search.length > 0) {
					inputSearch.classList.add('is-invalid');
					return false;
				}
			}
			return true;
		},
		find() {
			if (!this.handleInputSearch(this.search)) {
				return;
			}

			axios.post(route('api.product.find'), { search: this.search })
				.then(response => {
					this.products = response.data.data
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
			this.getAllProducts()
		}
	}
}

</script>
