<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategory(string $id);
    public function editCategory(string $id, string $name, string $storage);
    public function createCategory(string $name, string $storage);
    public function deleteCategory(string $id);
}
