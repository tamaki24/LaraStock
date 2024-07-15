<?php

namespace App\Repositories;

use App\Interfaces\StockRepositoryInterface;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Str;

class StockRepository implements StockRepositoryInterface
{

    protected $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function getAllStocks()
    {
        try {
            $stocks = $this->stock::leftJoin('item_master as m', function ($join) {
                $join->on('m.id', '=', 'master_id')
                    ->whereNull('m.deleted_at');
            })
                ->leftJoin('categories as c', function ($join) {
                    $join->on('c.id', '=', 'm.category_id')
                        ->whereNull('c.deleted_at');
                })
                ->orderBy('deadline', 'asc')
                ->orderBy('m.id', 'asc')
                ->orderBy('c.id', 'asc')
                ->orderBy('m.name', 'asc')
                ->get([
                    'stocks.id',
                    'stocks.stock',
                    'stocks.deadline',
                    'm.id as masterId',
                    'm.name as itemName',
                    'm.place',
                    'm.remarks',
                    'c.id as categoryId',
                    'c.name as categoryName',
                    'c.storage',
                ]);

            return $stocks;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getHomeProps()
    {
        try {
            $stocks = $this->stock::leftJoin('item_master as m', function ($join) {
                $join->on('m.id', '=', 'master_id')
                    ->whereNull('m.deleted_at');
            })
                ->leftJoin('categories as c', function ($join) {
                    $join->on('c.id', '=', 'm.category_id')
                        ->whereNull('c.deleted_at');
                })
                ->orderBy('deadline', 'asc')
                ->orderBy('m.id', 'asc')
                ->orderBy('c.id', 'asc')
                ->limit('10')
                ->get([
                    'stocks.id',
                    'stocks.stock',
                    'stocks.deadline',
                    'm.id as masterId',
                    'm.name as itemName',
                    'm.place',
                    'm.remarks',
                    'c.id as categoryId',
                    'c.name as categoryName',
                    'c.storage',
                ]);

            return $stocks;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getStock($id)
    {
        try {
            $stock = $this->stock::leftJoin('item_master as m', function ($join) {
                $join->on('m.id', '=', 'master_id')
                    ->whereNull('m.deleted_at');
            })
                ->leftJoin('categories as c', function ($join) {
                    $join->on('c.id', '=', 'm.category_id')
                        ->whereNull('c.deleted_at');
                })->where('stocks.id', '=', $id)->first([
                    'stocks.id',
                    'stocks.stock',
                    'stocks.deadline',
                    'm.id as masterId',
                    'm.name as itemName',
                    'm.place',
                    'm.remarks',
                    'c.id as categoryId',
                    'c.name as categoryName',
                    'c.storage',
                ]);

            $targetId = $stock->toArray()["id"];
            $targetMasterId = $stock->toArray()["masterId"];
            $targetCategoryId = $stock->toArray()["categoryId"];
            $otherStocks = Stock::leftJoin('item_master as m', function ($join) {
                $join->on('m.id', '=', 'master_id')
                    ->whereNull('m.deleted_at');
            })
                ->leftJoin('categories as c', function ($join) {
                    $join->on('c.id', '=', 'm.category_id')
                        ->whereNull('c.deleted_at');
                })->where('stocks.id', '<>', $targetId)->where('m.id', '=', $targetMasterId)->where('c.id', '=', $targetCategoryId)
                ->get([
                    'stocks.id',
                    'stocks.stock',
                    'stocks.deadline',
                    'm.id as master_id',
                    'm.name as itemName',
                    'm.place',
                    'm.remarks',
                    'c.id as categoryId',
                    'c.name as categoryName',
                    'c.storage',
                ]);

            return ['stock' => $stock, 'other_stocks' => $otherStocks];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function editStock($id, $stock, $deadline)
    {
        try {
            $data = $this->stock::find($id);

            if (!$data) {
                return response()->json(['message' => 'Stock not found'], 404);
            }

            // 更新
            $data->stock = $stock;
            $data->deadline = \Carbon\Carbon::createFromFormat('Y-m-d', $deadline);
            $data->save();

            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function createStock($stock, $deadline, $masterId)
    {
        try {
            $data = new Stock();
            $data->id = Str::uuid();
            $data->stock = $stock;
            $data->deadline = \Carbon\Carbon::createFromFormat('Y-m-d', $deadline);
            $data->master_id = $masterId;

            $data->save();
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function deleteStock($id)
    {
        try {
            $data = $this->stock::find($id);

            if (!$data) {
                return response()->json(['message' => 'Stock not found'], 404);
            }

            $data->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
