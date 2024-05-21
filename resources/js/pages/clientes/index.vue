<template>
	<div
		class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Cliente</h1>
	</div>
	<div>
		<Find idInput="input-search"
        	:search="search"
        	:inputKeyup="(search) => handleInputSearch(search)"
			:btnClearClick="() => clearSearch()"
        	:btnFindClick="() => find()"
			:routeAddNew="route('client.add')"
        	textAddNew="Adicionar novo Cliente"
			clearSearchText="Limpar Pesquisa"
			searchText="Pesquisar Cliente" />
			
		<div class="table-responsive mt-4">
			<p v-if="customers.length == 0"> Não existe dados </p>


			<table v-if="customers.length > 0" class="table table-hover table-striped table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Email</th>
						<th>CPF/CNPJ</th>
						<th>Data</th>
						<th>Endereço</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(client, key) in customers " :key="key">
						<td>{{ client.id }}</td>
						<td>{{ client.name }}</td>
						<td>{{ client.email }}</td>
						<td v-if="client.cpf">{{ client.cpf }}</td>
						<td v-else>{{ client.cnpj }}</td>
						<!--td>{{ $client->date_formatted }}</td-->
						<td>{{ $filters.formatDate(client.date, 'DD/MM/YYYY') }}</td>
						<td>{{ getFullAddress(client.address) }}</td>
						<td>
							<a :href="route('client.edit', { id: client.id })" class="btn btn-light btn-sm">
								Editar
							</a>
							<button @click="confirmDeleteClient(client.id, client.name)" class="btn btn-danger btn-sm">
								Excluir
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<PaginationVue v-if="paginationData" :pagination-data="paginationData"
				@go-page="(url) => getAllCustomers(url)" />
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
			customers: [],
			paginationData: null,
			search: '',
		}
	},
	created() {
		this.getAllCustomers();
	},
	methods: {
		getAllCustomers(goPage = '') {
			let url = route('api.client.index');
			if (goPage) {
				url = goPage;
			}

			this.paginationData = null;
			axios.get(url)
				.then(response => {
					console.log(response)
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
		confirmDeleteClient(id, name) {
			alertSwal(
				`Deseja realmente excluir o Cliente <b>"${name}"</b>?`,
				'warning',
				success => {
					this.deleteClient(id);
				}
			);
		},

		deleteClient(id) {
			axios.delete(route('api.client.delete'), {
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
								this.getAllCustomers();
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

			axios.post(route('api.client.find'), { search: this.search })
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
			this.getAllCustomers()
		},
		getFullAddress(address) {
			address = JSON.parse(address);
			return `${address.street}, ${address.number} - ${address.neighborhood}, ${address.city} - ${address.state}`;
		}
	}
};

</script>