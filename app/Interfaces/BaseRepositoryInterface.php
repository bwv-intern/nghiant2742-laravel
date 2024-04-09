<?php

namespace App\Interfaces;

interface BaseRepositoryInterface 
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function store($table, array $data);
    public function update($table, $id, array $data);
}