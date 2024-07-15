<?php

namespace App\Interfaces;

interface ItemMasterRepositoryInterface
{
    public function getAllItems();
    public function getAllItemsWithCategories();
    public function getItem(string $id);
    public function editItem(string $id, string $name, string $categoryId, string $place, string $remarks);
    public function createItem(string $name, string $categoryId, string $place, string $remarks);
    public function deleteItem(string $id);
}
