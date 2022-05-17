<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseInterface
{

    protected function transaction($closure, $retry = 5)
    {
        // TODO: Implement transaction() method.
        return DB::transaction($closure, $retry);
    }


    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all();
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    public function paginateData($perPage = 10)
    {
        // TODO: Implement paginateData() method.
        return $this->model->latest()->paginate($perPage);
    }

    public function store(array $attributes)
    {
        // TODO: Implement store() method.
        return $this->transaction(function () use ($attributes){
            return $this->model->create($attributes);
        });

    }

    public function update($id, $attributes)
    {

        // TODO: Implement update() method.
        return $this->transaction(function () use ($id, $attributes){
            $model = $this->model->findOrFail($id);
            $model->fill($attributes);
            $model->save();

            return $model;
        });

    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->transaction(function () use ($id){
            return $this->model->findOrFail($id)->delete();
        });
    }

    public function trashed()
    {
        return $this->model->onlyTrashed()->latest()->paginate(10);
    }
}
