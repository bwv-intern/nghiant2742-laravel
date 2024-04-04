<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryInterface 
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * Retrieve all records.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $columns = ['*'], array $relations = []): Collection {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Retrieve a record by its primary key.
     *
     * @param int $id
     * @return Model|null
     */
    public function getById($id): ?Model {
        return $this->model->find($id);
    }

    /**
     * Delete a record by its primary key.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id): ?bool {
        return DB::transaction(function () use ($id) {
            $this->getById($id)->delete();
            return true;
        });
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool {
        return DB::transaction(function () use ($data) {
            $this->model->create($data);
            return true;
        });
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool {
        // $success = false;
    
        // DB::transaction(function () use ($id, $data, &$success) {
        //     $success = $this->getById($id)->update($data);
        // });
        $r = $this->getById($id)->update($data);
        return $r;
    }
}
