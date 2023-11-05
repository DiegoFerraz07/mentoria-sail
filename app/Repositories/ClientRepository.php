<?php

namespace App\Repositories;

use App\Http\Requests\Client\ClientAddFormRequest;
use App\Http\Requests\Client\ClientUpdateFormRequest;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class ClientRepository implements ClientRepositoryInterface
{

    public function getAll(): Collection
    {
        return Client::all()
            ->sortByDesc('id');
    }

    /**
     * find a client by name or CPf and return first 10
     *
     * @param string $search
     *
     * @return Collection<Client>
     */
    public function find(string $search): Collection
    {
        return Client::where(function($q) use ($search) {
            $q->where("name", "LIKE", "%$search%")
                ->orWhere("cpf", $search);
        })->limit(10)->get();
    }

    /**
     * Delete a specific client
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleted = Client::where('id', $id)
            ->delete();

        return $deleted
            ? true
            : false;
    }

    /**
     * Store a new client
     * @param ClientAddFormRequest $request
     *
     * @return array
     */
    public function store(ClientAddFormRequest $request): array
    {
        try {
            $client = new Client();
            $client->fillClient($request);
            $saved = $client->save();
            return array(
                'success' => $saved,
                'message' => ''
            );
        } catch(Exception $e) {
            $message = 'Houve um erro';
            if($e->getMessage() && str_contains($e->getMessage(), 'cliente_cpf_unique')) {
                $message = 'Já existe um cliente com esse CPF';
            }
            Log::error($e->getMessage() . $e->getTraceAsString());
            return array(
                'success' => false,
                'message' => $message
            );
        }
    }

    /**
     * get a specific client
     * @param int $id
     *
     * @return Client|null
     */
    public function get(int $id): Client|null
    {
        return Client::where('id', $id)->first();
    }

      /**
     * Store a new Client
     * @param ClientAddFormRequest $request
     *
     * @return bool
     */
    public function update(ClientUpdateFormRequest $request): bool
    {
        try {
            $client = $this->get($request->id);
            $client->fillClient($request);
            return $client->update();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }
}
