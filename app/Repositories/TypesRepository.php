<?php

namespace App\Repositories;

use App\Http\Requests\Type\TypesAddFormRequest;
use App\Http\Requests\Type\TypesUpdateFormRequest;
use App\Interfaces\TypesRepositoryInterface;
use App\Models\Types;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class TypesRepository implements TypesRepositoryInterface
{

    /**
     * Get all types
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return Types::all()
            ->sortByDesc('id')
            ->toQuery()
            ->paginate(20);
    }
    /**
    *Get all types no restricion to numbers
    */
    public function getAllForTypes(): Collection
    {
        $types = Types::all('name', 'id');
        return $types;
    }

    /**
     * get a specific type
     * @param int $id
     * 
     * @return Types|null
     */
    public function get(int $id): Types|null
    {
        return Types::where('id', $id)->first();
    }

    /**
     * Find by name or description 
     *
     * @param string $search
     *
     * @return LengthAwarePaginator<Types>
     */
    public function find(string $search): LengthAwarePaginator
    {
        return Types::where(function($q) use ($search) {
            $q->where("name", "LIKE", "%$search%")
                ->orWhere("description", "LIKE", $search);
        })->paginate(10);
    }


    /**
     * Store a new type
     * @param TypesAddFormRequest $request
     *
     * @return array
     */
    public function store(TypesAddFormRequest $request): array
    {
        try {
            $type = new Types();
            $type->fillType($request);
            $saved = $type->save();
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
     * Delete a specific type
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $deleted = Types::where('id', $id)
            ->delete();

        return $deleted
            ? true
            : false;
    }


    /**
     * Update a type
     * @param TypesUpdateFormRequest $request
     * 
     * @return bool
     */
    public function update(TypesUpdateFormRequest $request): bool
    {
        try {
            $type = $this->get($request->id);
            $type->fillType($request);
            return $type->update();
        } catch(Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }

}
