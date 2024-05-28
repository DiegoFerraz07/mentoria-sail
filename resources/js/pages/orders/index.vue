<template>
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Pedidos</h1>
	</div>
	<div>
		<Find idInput="input-search"
        	:search="search"
        	:inputKeyup="(search) => handleInputSearch(search)"
			:btnClearClick="() => clearSearch()"
        	:btnFindClick="() => find()"
			:routeAddNew="route('orders.add')"
        	textAddNew="Adicionar novos Pedidos"
			clearSearchText="Limpar Pesquisa"
			searchText="Pesquisar Pedido" />
			
		<div class="table-responsive mt-4">
			<p v-if="orders.length == 0"> Não existe dados </p>
			<table v-if="orders.length > 0" class="table table-hover table-striped table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>numero do Pedido</th>
						<th>descrição</th>
						<th>taxa</th>
						<th>Icms</th>
						<th>Valor Total</th>
						<th>Cliente</th>
						<th>CPF/CNPJ</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(order, key) in orders " :key="key">
						<td>{{ order.id }}</td>
						<td>{{ order.numero_order }}</td>
						<td>{{ order.description_order }}</td>
						<td>{{ order.tax_order }}</td>
						<td>{{ order.icms_order }}</td>
						<td>{{ order.total_value_order }}</td>
						<td>{{ order.name_client }}</td>
						<td v-if="order.cpf_client">{{ order.cpf_client }}</td>
						<td v-else>{{ cnpj_client }}</td>
						
						<td>
							<a  class="btn btn-light btn-sm">
								Ver Pedido
							</a>
							<button @click="confirmDeleteOrder(order.id, order.nameClient)" class="btn btn-danger btn-sm">
								Excluir
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<PaginationVue v-if="paginationData" :pagination-data="paginationData"
				@go-page="(url) => getAllOrders(url)" />
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
import PaginationVue from '../../components/Pagination.vue';
import Find from '../../components/Find.vue';
const alertSwal = window.alertSweet;
export default {
	components: {
		PaginationVue,
		Find
	},
	data() {
		return {
			orders: [],
			paginationData: null,
			search: '',
		}
	},
	created() {
		this.getAllOrders();
	},
	methods: {
		getAllOrders(goPage = '') {
			let url = route('api.orders.index');
			if (goPage) {
				url = goPage;
			}

			this.paginationData = null;
			axios.get(url)
				.then(response => {
					console.log(response)
					this.orders = response.data.data
					if(response.data.links && response.data.meta) {
						this.paginationData = {
							links: response.data.links,
							meta: response.data.meta
						}
					}
				})
				.catch(error => {
					console.log(error)
				})
		},
		confirmDeleteOrder(id, nameClient) {
			alertSwal(
				`Deseja realmente excluir o Pedido do<b>"${nameClient}"</b>?`,
				'warning',
				success => {
					this.deleteOrder(id);
				}
			);
		},

		deleteOrder(id) {
			axios.delete(route('api.orders.delete'), {
				data: {
					id,
				}
			})
				.then(response => {
					response = response.data
					if (response.data.success) {
						alertSwal(
							'Excluido com sucesso',
							'success',
							success => {
								this.getAllOrders();
							}
						);
					}
				})
				.catch(error => {
					alertSwal(
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

			axios.post(route('api.orders.find'), { search: this.search })
				.then(response => {
					this.customers = response.data.data
					if(response.data.links && response.data.meta) {
						this.paginationData = {
							links: response.data.links,
							meta: response.data.meta
						}
					}
				})
				.catch(error => {
					console.log(error)
				})
		},
		clearSearch() {
			this.search = '';
			this.getAllOrders()
		},
	
	}
};

</script>