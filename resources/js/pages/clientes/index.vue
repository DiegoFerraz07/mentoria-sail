<template>
	<table class="table table-striped table-sm">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Email</th>
				<th>CPF/CNPJ</th>
				<th>Data</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="client in customers" :key="client.id">
				<td>{{ $filter.formatId(client.id) }}</td>
				<td>{{ client.name }}</td>
				<td>{{ client.email }}</td>
				<td v-if="client.cpf">{{ client.cpf }}</td>
				<td v-else>{{ client.cnpj }}</td>
				<!--td>{{ $client->date_formatted }}</td-->
				<td>@date_ptbr{{client.date}}</td>
				<td>
					<a href="{{route(" client.edit", ['id'=> $client->id])}}" class="btn btn-light btn-sm">
						Editar
					</a>

					<meta name='csrf-token' content="{{ csrf_token() }}" />
					<button 
					@click="confirmDeleteClient('{{$client->id}}', '{{$client->name}}')"
						class="btn btn-danger btn-sm">
						Excluir
					</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</template>
<script>

export default ({
	props:['client'],
        data() {
            return {
                customers: []
            }
        },
		created() {
			let customers  = JSON.parse(this.customers)
            this.customers = customers.data;
		}
}
</script>
