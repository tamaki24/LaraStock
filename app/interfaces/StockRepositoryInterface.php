<?php

namespace App\Interfaces;

interface StockRepositoryInterface
{
    public function getAllStocks();
    public function getHomeProps();
    public function getStock(string $id);
    public function editStock(string $id, int $stock, string $deadline);
    public function createStock(int $stock, string $deadline, string $masterId);
    public function deleteStock(string $id);
}
