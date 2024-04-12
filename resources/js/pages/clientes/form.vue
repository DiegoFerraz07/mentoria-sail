<template>
	<input type="hidden" id="client-id" v-model="client.id">
	<div class="form-group">
		<label for="name">Nome</label>
		<input type="text" class="form-control" name="name" id="name" v-model="client.name" required placeholder="Nome">
	</div>
	<div class="form-group">
		<label for="name">E-mail</label>
		<input type="text" class="form-control" name="email" id="email" v-model="client.email" required
			placeholder="E-mail">
	</div>
	<div class="form-group">
		<label for="cpf">CPF/CNPJ</label>
		<input type="hidden" id="isLegalAge" name="is_legal_age"
			v-model="client.is_legal_age">
		<input
			:v-model="client.cpf || client.cnpj"
			type="text"
			class="form-control document"
			name="document"
			id="document"
			@keyup="changeDocument($event.target.value)"
			v-mask="['###.###.###-##','##.###.###/####-##']"
			placeholder="CPF/CNPJ"
			required>
		<div id="document-error" class="error"></div>
	</div>
	<div v-if="isClientCpf()" class="form-group">
		<label for="date">{{ getLabelBirth }}</label>
			<VueDatePicker
				:readonly="!isClientCpf()"
				v-model="client.date"
			 	:max-date="isClientCpf() ? maxDate : null"
			 	prevent-min-max-navigation
				:enable-time-picker="false"
				locale="pt-BR"
				format="dd/MM/yyyy"
				@date-update="updateDate"
				@select-date="updateDate"
			/>
			<div id="data-error" class="error"></div>
	</div>

	<button @click="save" class="btn btn-success mt-2">Salvar</button>
</template>


<script>
import axios from 'axios';
import { route } from 'ziggy-js';
import { mask } from 'vue-the-mask';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';

export default {
	props:['clientProp'],
	directives:{mask},
	components: {
		VueDatePicker,
	},
	data() {
		return {
			client: {
				id: this.clientProp.id || '',
				name: this.clientProp.name || '',
				email: this.clientProp.email || '',
				cpf: this.clientProp.cpf || '',
				cnpj: this.clientProp.cnpj || '',
				date: this.clientProp.date || moment().subtract(18, 'years').format('YYYY-MM-DD'),
				address: this.clientProp.address || '',
				document: 0
			},
			routeIndex: route('client.index'),
			routeSave: route('api.client.store'),
			routeUpdate: route('api.client.update'),
			maxDate: moment().subtract(18, 'years').format('YYYY-MM-DD'),
		}
	},
	created(){
		console.log(this.clientProp, route('api.client.store'));
	},
	computed: {
		getLabelBirth() {
			const isClient = this.client 
				&& this.client.cpf 
				&& this.client.cpf.length > 0 
				&& this.client.cpf.length < 14 ? true : false;
			const isCompany = this.client 
				&& this.client.cnpj 
				&& this.client.cnpj.length > 14 
				&& this.client.cnpj.length <= 18 ? true : false;
			if(isClient)
				return 'Data de Nascimento';
			if(isCompany)
				return 'Data de Abertura da Empresa';
			return 'Data de Nascimento';
		}
	},
	methods: {
		isClientCpf(){
			return this.client.cpf ? true : false
		},
		changeDocument(document) {
			console.log(this.client);
			if (document.length > 0 && document.length <= 14) {
				this.client.cnpj = '';
				this.client.cpf = document;
			} else {
				this.client.cpf = '';
				this.client.date = moment().format('YYYY-MM-DD');
				this.client.cnpj = document;
			}

		},
		updateDate(date) {
			this.client.date = moment(date)
				
				.format('YYYY-MM-DD');
		},
		save() {
			let route = this.routeSave;
			let messageSuccess = "Adicionado com sucesso";

			if(this.client.id) {
				route = this.routeUpdate;
				messageSuccess = "Alterado com sucesso";
			}

			this.client.date = moment(this.client.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
			console.log(this.client);
			return; 
			axios.post(
				route,
				this.client
			).then(response => {
				let apiResponse = response.data;
				if (apiResponse.data) {
					apiResponse = apiResponse.data;
				}
				if (apiResponse.success) {
					alertSweet(
						messageSuccess,
						'success',
						success => {
							// redirect to index
							document.location.href = this.routeIndex;
						}
					);
				} else {
					let message = 'Não foi possível Salvar!!';
					if (apiResponse.message) {
						message = apiResponse.message;
					}
					alertSweet(
						message,
						'error'
					)
				}

			})
			.catch(error => {
				console.log(error)
				alertSweet(
					'Não foi possivel Salvar!!',
					'error'
				)
			});

		}
	}
}
</script>