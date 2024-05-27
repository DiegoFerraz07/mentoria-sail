<?php

namespace Database\Seeders;

use App\Models\Orders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');
        for ($i = 0; $i < 100; $i++) {
            $fullAddress = array(
                'street' => $faker->streetAddress(),
                'number' => $faker->buildingNumber(),
                'complement' => $faker->secondaryAddress(), // 'complemento
                'neighborhood' => $faker->streetName(), // 'bairro
                'city' => $faker->city(),
                'state' => $faker->stateAbbr(),
                'zipcode' => $faker->postcode()
            );
            $fullItens = array(
                'id' => $faker->randomNumber(),
                'nome' => $faker->name(),
                'quantity' => $faker->randomNumber(),
                'description' => $faker->sentences(1, true),
                'unitValue' => $faker->randomNumber(2),
                'totalValue' => $faker->randomNumber(2),
                'taxValue' => $faker->randomNumber(2),
                'icmsValue' => $faker->randomNumber(2),
            );

            Orders::create(
                [
                    'numero_order'=> $faker->unique()->randomNumber(),
                    'description_order'=> $faker->sentences(1, true),
                    'tax_order'=>$faker->randomNumber(2),
                    'icms_order'=>$faker->randomNumber(2),
                    'total_value_order'=>$faker->randomNumber(2),
                    'obs_order'=> $faker->sentences(1, true),
                    'name_supply' => $faker->name(),
                    'cnpj_supply' => $faker->cnpj(),
                    'name_client' => $faker->name(),
                    'cpf_client' => $faker->cpf(),
                    'cnpj_client' => $faker->cnpj(),
                    'address_client' => json_encode($fullAddress),
                    'orders_itens' => json_encode($fullItens)
                ]
            );
        }
    }
}
