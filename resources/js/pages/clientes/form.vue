<template>
	<div class="row">
		<div class="col-md-6 col-lg-6">
			<input type="hidden" id="client-id" v-model="client.id">
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" class="form-control" name="name" id="name" v-model="client.name" required
					placeholder="Nome">
			</div>
		</div>
		<div class="col-md-6 col-lg-6">
			<div class="form-group">
				<label for="name">E-mail</label>
				<input type="text" class="form-control" name="email" id="email" v-model="client.email" required
					placeholder="E-mail">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="cpf">CPF/CNPJ</label>
		<input type="hidden" id="isLegalAge" name="is_legal_age" v-model="this.client.is_legal_age">
		<input :value="client.cpf || client.cnpj" type="text" class="form-control document" name="document"
			id="document" minlength="14" @keyup="validateDocument($event.target.value)"
			v-mask="['###.###.###-##','##.###.###/####-##']" placeholder="CPF/CNPJ" required>
		<div id="document-error" class="error"></div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
				<label for="name">Cep</label>
				<input type="text" class="form-control" :key="count" v-mask="'#####-###'" @keyup="getCep"
					v-model="this.client.address.zipcode" required placeholder="Cep">
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<label for="name">Estado</label>
				<Dropdown v-if="allStates" v-model="this.client.address.state" :options="allStates" filter
					optionLabel="name" placeholder="Selecione um estado" class="w-full md:w-14rem">
				</Dropdown>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="name">Cidade</label>
				<Dropdown v-model="this.client.address.city"
					:disabled="!this.client.address.state"
					:options="this.client.address.state ? this.getCitiesByState() : []" 
					filter 
					optionLabel="name"
					:placeholder="!this.client.address.state ? 'Selecione um estado primeiro' : 'Selecione uma cidade'" 
					class="w-full md:w-14rem">
				</Dropdown>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
				<label for="name">Rua</label>
				<input type="text" class="form-control" v-model="this.client.address.street" required placeholder="Rua">
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label for="name">Numero</label>
				<input type="text" class="form-control" v-model="this.client.address.number" required
					placeholder="Numero">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="name">Complemento</label>
				<input type="text" class="form-control" v-model="this.client.address.complement" required
					placeholder="Complemento">
			</div>
		</div>
	</div>
	<div v-if="isClientCpf()" class="form-group">
		<label for="date">{{ getLabelBirth }}</label><br />
		<Datepicker :disabled="!isClientCpf()" v-model="client.date" :selected="updateDate" format="dd/MM/yyyy"
			:max-date="isClientCpf() ? maxDate : null" />
		<div id="data-error" class="error"></div>
	</div>


	<button @click="save" class="btn btn-success mt-2">Salvar</button>
</template>

<script>
import axios from 'axios';
import { route } from 'ziggy-js';
import { mask } from 'vue-the-mask';
import moment from 'moment';
import validityCPF from '@/utils/cpf-verify.js';
import validityCNPJ from '@/utils/cnpj-verify.js';
import Datepicker from 'vuejs3-datepicker';
import {states, cities} from '@/utils/statesAndCitiesBR.js';
import Dropdown from 'primevue/dropdown'; // https://primevue.org/

export default {
	props:['clientProp'],
	directives:{mask},
	components: {
		Datepicker,
		Dropdown
	},
	data() {
		return {
			count: 0,
			client: {
				id: this.clientProp.id || '',
				name: this.clientProp.name || '',
				email: this.clientProp.email || '',
				cpf: this.clientProp.cpf || '',
				cnpj: this.clientProp.cnpj || '',
				date: this.clientProp.date || moment().subtract(18, 'years').format('YYYY-MM-DD'),
				is_legal_age: this.clientProp.is_legal_age || 0,
				address: this.clientProp && this.clientProp.address ? 
					JSON.parse(this.clientProp.address || {}) : 
					{},
				document: 0
			},
			routeIndex: route('client.index'),
			routeSave: route('api.client.store'),
			routeUpdate: route('api.client.update'),
			maxDate: moment().subtract(18, 'years').format('YYYY-MM-DD'),	
			erroMessage: '',
			allStates: states

		}
	},
	mounted(){
		if(this.clientProp.address) {
			this.client.address = JSON.parse(this.clientProp.address);
			this.count++;
		}
		console.log(this.clientProp, route('api.client.store'), states, cities);
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
		},
	},
	methods: {
		setMessageErrorCPF(message = '') {
			$('#document-error')[0].innerHTML = message;
		},
		getCitiesByState() {
			const stateId = this.allStates.find(state => state.mast == this.client.address.state.mast).id;
			if(!stateId)
				return [];
			return cities.filter(city => city.state == stateId);
		},
		validateDocument(document) {
            // pegar o valor do input cpf
			console.log(document)
            // Limpar a div
            this.setMessageErrorCPF();
            // verifica o tamanho do cpf
            	if(document.length == 14) {
                    if(!validityCPF(document)) {
                        this.setMessageErrorCPF("<p class='text-danger'>CPF inválido</p>");
                        return false;
                    } else {
                        this.setMessageErrorCPF("<p class='text-success'>CPF válido</p>")
                        return true;
                    }
                }else if(document.length == 18) {
                    if(!validityCNPJ(document)) {
                        this.setMessageErrorCPF("<p class='text-danger'>CNPJ inválido</p>");
                        return false;
                    } else {
                        this.setMessageErrorCPF("<p class='text-success'>CNPJ válido</p>")
                        return true;
                    }
                }
            	return false
        },
		isClientCpf(){
			return this.client.cpf ? true : false
		},
		changeDocument(document) {
			console.log(this.client);
			if (document.length > 0 && document.length <= 14) {
				this.client.cnpj = '';
				this.client.cpf = document;
				console.log(this.client.cpf);
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
			axios({
				method: this.client.id ? 'put' : 'post',
				url: route,
				data: this.client
			}).then(response => {
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

		},
		getCep() {
			let cep = this.client.address.zipcode;
			console.log(cep);
			if(cep.length === 9) {
				axios.get(`https:viacep.com.br/ws/${cep}/json/`)
					.then(response => {
						this.client.address = {
						zipcode: response.data.cep,
						city: response.data.localidade,
						state: response.data.uf,
						street: response.data.logradouro,
						neighborhood : response.data.bairro
						};
					})
					.catch(error =>{
						console.error('ops! ocorreu um erro na busca do endereço:', error);
					})
			}else{
				console.error('Cep invalido'. error);
			}
		}
	}
}
</script>