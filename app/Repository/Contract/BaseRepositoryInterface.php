<?php

namespace App\Repository\Contract;

interface BaseRepositoryInterface
{
    public function store(array $data);

    public function findOne(int $id);

    public function findAll(array $params);

    public function delete(int $id);

    public function update(int $id, array $data);
}
