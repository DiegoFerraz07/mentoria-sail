<template>

	<input type="hidden" id="product-id" value="product.id">
	<div class="form-group">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" name="nome" id="nome"
			v-model="products.name" required placeholder="Nome">
	</div>
	<div class="form-group">
		<label for="valor">Valor</label>
		<input type="text" class="form-control valor" name="valor" id="valor"
			v-model="products.valor" required placeholder="Valor">
		<div id="valor-error" class="error"></div>
	</div>
	<div class="form-group">
		<label for="valor">Tipos</label>	
		<select id="types"  multiple="multiple" class="form-control" >
				<option v-if="!types">Nenhum tipo cadastrado</option><!-- se não exitir nenhum type-->
				<option v-else readonly disabled >Selecione um tipo</option><!-- se exitir type-->
				<div v-if="productTypes && productTypes.includes(types.id)">
					<option v-for="(type, key) in types" :key="key" :value="type.id" selected>{{ type.name }}</option>
				</div>
				<div v-else>
					<option v-for="(type, key) in types" :key="key" :value="type.id">{{ type.name }}</option>
				</div>
		</select>
		<div id="valor-error" class="error"></div>
	</div>
	<div class="form-group">
		<label for="valor">Marcas</label>
		<select id="brandId" name="brandId"  class="form-control" >
				<option v-if="!brand.id" value="">Nenhuma marca cadastrada</option>
				<option v-else value="" readonly disabled selected>Selecione uma marca</option>
				<div v-if="products.brand_id && brand.id == products.brand_id">
							<option v-for="(brand, key) in brands" :key="key" :value="brand.id" selected>{{ brand.name }}</option>
				</div>
				<div v-else>
					<option v-for="(brand, key) in brands" :key="key" :value="brand.id">{{ brand.name }}</option>
				</div>
		</select>
		<div id="valor-error" class="error"></div>
	</div>
	<button type="submit" class="btn btn-success mt-2">Salvar</button>
</template>
<script>
import axios from 'axios';
 
export default{
	props:['productsProp', 'productTypesProp'],
	data(){
		console.log('productsProp', this.productsProp);
		return {
			products: {
					id: this.productsProp.id || '',
					name: this.productsProp.name || '',
					brand_id: this.productsProp.brand_id || '',
				},
			productTypes: this.productTypesProp || [],
			types: [],	
			brands: [],
			routeIndex: route('product.index'),
			routeSave: route('api.product.store'),
			routeUpdate: route('api.product.update'),
		}
	},
	methods: {
		save() {
			console.log('save');
			let route = this.routeSave;
			let messageSuccess = "Adicionado com sucesso";
			
			if(this.product.id) {
				route = this.routeUpdate;
				messageSuccess = "Alterado com sucesso";
			}

			axios.post(
				route,
				this.product
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
	},
}
</script>
