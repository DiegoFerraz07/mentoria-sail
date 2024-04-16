<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
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

            Client::create(
                [
                    'name' => $faker->name(),
                    'cpf' => $faker->unique()->cpf(),
                    'date' => $faker->date(),
                    'email' => $faker->unique()->email(),
                    'address' => json_encode($fullAddress),
                ]
            );
        }
    }
}
