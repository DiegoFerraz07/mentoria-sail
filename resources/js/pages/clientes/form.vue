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
		<input v-if="client.cpf" 
				type="text"
				class="form-control document"
				name="document"
				id="document"
				maxlength="14"
				v-model="client.cpf"
				v-mask="['###.###.###-##']"
				placeholder="CPF/CNPJ"
				required>
			<input v-else-if="client.cnpj" 
				v-model="client.cnpj"
				type="text"
				class="form-control document"
				name="document"
				id="document"
				maxlength="18"
				v-mask="['##.###.###/####-##']"
				placeholder="CPF/CNPJ"
				required>
				<input v-else 
				:v-model="client.cpf || client.cnpj"
				type="text"
				class="form-control document"
				name="document"
				id="document"
				maxlength="18"
				v-mask="['###.###.###-##','##.###.###/####-##']"
				placeholder="CPF/CNPJ"
				required>
		<div id="document-error" class="error"></div>
	</div>
	<div class="form-group">
		<label for="date">Data Nascimento</label>
			<VueDatePicker
				:readonly="getClientCpf()"
				v-model="client.date"
			 	:max-date="maxDate"
			 	prevent-min-max-navigation
				:enable-time-picker="false"
				locale="pt-BR"
				format="dd/MM/yyyy"
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

export default {
	props:['clientProp'],
	directives:{mask},
	components: {
		VueDatePicker,
	},
	data() {
		return {
			client: {
				id: this.clientProp.id,
				name: this.clientProp.name,
				email: this.clientProp.email,
				cpf: this.clientProp.cpf,
				cnpj: this.clientProp.cnpj,
				date: this.clientProp.date,
				address: this.clientProp.address

			},
			routeIndex: route('client.index'),
			routeSave: route('api.client.store'),
			routeUpdate: route('api.client.update'),
			maxDate: Date.now(),
		}
	},
	created(){
		console.log(this.clientProp, route('api.client.store'));
		this.getClientCpf();
	},
	methods: {
		getClientCpf(){
			return this.client.cnpj ? true : false
		},
		save() {
			console.log('save');
			let route = this.routeSave;
			let messageSuccess = "Adicionado com sucesso";


			if(this.client.id) {
				route = this.routeUpdate;
				messageSuccess = "Alterado com sucesso";
			}

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