<template>
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Produtos</h1>
	</div>
	<div>
		<input type="text" id="input-search" @keyup="handleInputSearch" required minlength="3" v-model="search"
			placeholder="Digite o nome" />
		<button @click="find()"> pesquisar </button>
		<a v-if="search" @click="clearSearch" class="btn btn-danger btn-sm">
			Limpar Pesquisa
		</a>
		<a type="button" :href="route('product.add')" class="btn btn-success float-end">
			Adicionar
		</a>
		<div class="table-responsive mt-4">
			<p v-if="!products"> Não existe dados </p>
			<table v-if="products" class="table table-striped table-sm">
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
						<td>R$: {{ (product.valor) }}</td>
						<td>
							<span v-for="(type, key) in product.types" :key="key" class="badge badge-primary">{{type.name}}</span>
						</td>

						<td>
							<span v-bind:types="type" class="badge badge-primary">{{ product.brand.name }}</span>
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
			products: [],
			paginationData: null,
			search: '',
		}
	},
	created() {
		this.getAllProducts();
	},
	methods: {
		getAllProducts() {
			axios.get(route('api.product.index'))
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
					if (response.data.success) {
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
