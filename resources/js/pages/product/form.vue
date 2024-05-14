<template>

	<input type="hidden" id="product-id" value="product.id">
	<div class="form-group">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" name="nome" id="nome"
			v-model="products.nome" required placeholder="Nome">
	</div>
	<div class="form-group">
		<label for="valor">Valor</label>
		<money3 class="form-control valor"
			v-model="products.valor" 
			v-bind="config"
			inputId="currency-br" 
			mode="currency" 
			currency="BRL" 
			locale="pt-BR" 
			required placeholder="Valor">
		</money3>
		<div id="valor-error" class="error"></div>
	</div>
	<div class="form-group">
		<label for="types">Tipos</label><p></p>	
			<MultiSelect 
				v-model="this.selectType"
				:options="types"
				display="chip"
				filter
				optionLabel="name"	
				placeholder="Selecione um Tipo"
			>
			</MultiSelect>
		<div id="valor-error" class="error"></div>
	</div>
	<div class="form-group">
		<label for="brand">Marcas</label><p></p>
			<Dropdown 
				v-model="this.selectBrand"
				:options="brands"
				filter
				option-label="name"
				placeholder="Selecione uma Marca"	
				class="col-sm-3"
			>
			</Dropdown>
		<div id="valor-error" class="error"></div>
	</div>
	<button @click="save" class="btn btn-success mt-2">Salvar</button>
</template>
<script>
import axios from 'axios';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import MultiSelect from 'primevue/multiselect';
import { Money3Component, format } from 'v-money3'


export default{
	props:['productsProp', 'productTypesProp',],
	components: {
		Dropdown,
		MultiSelect,
		InputNumber,
		money3: Money3Component
	},
	data(){
		console.log('productsProp', this.productsProp);
		console.log('productTypesProp', this.productTypesProp);
		return {
			products: {
					id: this.productsProp.id || '',
					nome: this.productsProp.nome || '',
					valor: this.productsProp.valor || '',
					brandId: this.productsProp.brand_id || '',
				},
			productTypes: this.productTypesProp || [],
			types: [],
			brands:[],
			selectType: [],
			selectBrand: [],
			routeIndex: route('product.index'),
			routeSave: route('api.product.store'),
			routeUpdate: route('api.product.update'),
			config: {
				masked: false,
				prefix: 'R$ ',
				suffix: '',
				thousands: '.',
				decimal: ',',
				precision: 2,
				disableNegative: true,
				disabled: false,
				min: null,
				max: 999999999999999999,
				allowBlank: false,
				minimumNumberOfCharacters: 0,
				shouldRound: true,
				focusOnRight: true,
        	}
		}
	},
	beforeMount(){
		this.getAllTypes();
		this.getAllBrands();
	},
	created(){
	},
	methods: {
		findType(id) {
			const found = this.productTypes.find(productType => productType.type_id === id);
			if(found !== undefined){
				return true;
			}
			return false;
		},
		getAllTypes() {
			axios.get(route('api.types.allTypes'))
				.then(response => {
					console.log(response)
					this.types = response.data;
					let chosenType = [];
					
					this.types.forEach(type => { 
						if( this.findType(type.id) ){
							chosenType.push(type);
						}
					});
					
					if (chosenType.length > 0) {
						this.selectType = chosenType
						console.log('select: ', this.selectType)
					}
				})
				.catch(error => {
					console.log(error)
				})
			
		},
		getAllBrands() {
			axios.get(route('api.brand.allBrands'))
				.then(response => {
					console.log(response)
					this.brands = response.data
					let chosenBrand = null;

					this.brands.forEach(brand => {
						if(brand.id === this.products.brandId){
							console.log('brand: ', brand)
							chosenBrand = brand;
						}
					});

					if(chosenBrand) {
						this.selectBrand = chosenBrand;
						console.log('select: ', selectBrand)
					}	
				})
				.catch(error => {
					console.log(error)
				})
			
		},
		save() {
			this.products.valor = parseFloat(this.products.valor);
			console.log('valor',  typeof(this.products.valor));
			this.types = this.selectType;
			console.log('typesSelecionados: ', this.types)
			if(this.types){
				this.products['types'] = this.types
			}
            let brandId = this.selectBrand.id;
			if (brandId) {
				this.products.brandId = brandId
			}
			console.log('save');
			let route = this.routeSave;
			let messageSuccess = "Adicionado com sucesso";
			
			
			if(this.products.id) {
				route = this.routeUpdate;
				messageSuccess = "Alterado com sucesso";
			}
			
			let method = 'post';
			if(this.products.id) {
				method = 'put';
			}
			axios({
				method: method,
				url: route, 
				data: this.products
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
		}
	},
}
</script>
