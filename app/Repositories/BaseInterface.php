<?php

namespace App\Repositories;

interface BaseInterface
{
    // fetch
    public function all();

    public function getById($id);

    public function paginateData($perPage);

    // logic
    public function store(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

}
