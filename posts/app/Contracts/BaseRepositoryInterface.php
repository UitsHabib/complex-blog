<?php

namespace App\Contracts;

/**
 * Interface BaseRepositoryContract
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    public function findOrFail($ids);

    public function getAll();

    public function save(array $data);

    public function update($resource, $data = []);

    public function delete($resource);

    public function getModel();

}
