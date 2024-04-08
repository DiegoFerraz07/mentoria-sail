<template>
	<form>
		<input type="hidden"
			id="brand-id"
			:value="brands ? brands.id : ''"/>
		<div class="form-group">
			<label for="name">Nome</label>
			<input type="text"
				class="form-control"
				name="name"
				id="name"
				:value="brands ? brands.name : ''"
				required
				placeholder="Nome">
		</div>
		<div class="form-group">
			<label for="description">Descrição</label>
			<input type="text"
				class="form-control"
				name="description"
				maxlength="512"
				minlength="3"
				:value="brands ? brands.description : ''"
				required
				placeholder="Descrição">
		</div>
		<button type="submit" class="btn btn-success mt-2">Salvar</button>
	</form>
</template>

<script>

export default{

	data() {
        return {
            brands: [],
        }
    },
	created: { },
	methods: {
		
	}
	
}
</script>
