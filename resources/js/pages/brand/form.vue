<template>
	<input type="hidden" v-model="brand.id"/>
	<div class="form-group">
		<label for="name">Nome</label>
		<input type="text"
			class="form-control"
			v-model="brand.name"
			required
			placeholder="Nome">
	</div>
	<div class="form-group">
		<label for="description">Descrição</label>
		<input type="text"
			class="form-control"
			maxlength="512"
			minlength="3"
			v-model="brand.description"
			required
			placeholder="Descrição">
	</div>
	<button @click="save" class="btn btn-success mt-2">Salvar</button>
</template>

<script>
import axios from 'axios';
import { route } from 'ziggy-js';


export default{
	props: ['brandProp'],
	data() {
        return {
            brand: {
				id: '',
				name: '',
				description: '',
			},
			routeIndex: route('brand.index'),
			routeSave: route('api.brand.store'),
			routeUpdate: route('api.brand.update'),
        }
    },
	created() {
		console.log(this.brandProp, route('api.brand.store'));
	},
	methods: {
		save() {
			console.log('save');
			let route = this.routeSave;
			let messageSuccess = "Adicionado com sucesso";
			
			if(this.brand.id) {
				route = this.routeUpdate;
				messageSuccess = "Alterado com sucesso";
			}

			axios.post(
				route,
				this.brand
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
