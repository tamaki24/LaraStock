<?php

namespace App\Service;

use App\Repositories\CategoryRepository;
use App\Repositories\ItemMasterRepository;
use App\Repositories\StockRepository;

class StockService
{
    protected $stockRepository;
    protected $categoryRepository;
    protected $itemMasterRepository;

    public function __construct(StockRepository $stockRepository, CategoryRepository $categoryRepository, ItemMasterRepository $itemMasterRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->categoryRepository = $categoryRepository;
        $this->itemMasterRepository = $itemMasterRepository;
    }

    public function getIndexProps()
    {
        $stocks = $this->stockRepository->getAllStocks();
        $categories = $this->categoryRepository->getAllCategories();
        $items = $this->itemMasterRepository->getAllItems();

        return  [
            'stocks' => $stocks,
            'categories' => $categories,
            'items' => $items
        ];
    }

    public function getHomeProps()
    {
        $stocks = $this->stockRepository->getHomeProps();
        return ['stocks' => $stocks];
    }

    public function getCreateProps()
    {
        $items = $this->itemMasterRepository->getAllItemsWithCategories();
        return  [
            'items' => $items
        ];
    }

    public function getEditProps($stock_id)
    {
        $data = $this->stockRepository->getStock($stock_id);
        return  [
            'stock' => $data['stock'],
            'other_stocks' => $data['other_stocks'],
        ];
    }


    public function getfilterStocks($category_id, $master_id)
    {
        $stocks = $this->stockRepository->getAllStocks();

        // filter
        if (!is_null($category_id)) {
            $stocks = $stocks->filter(function ($stock) use ($category_id) {
                return $stock->categoryId === $category_id;
            });
        }

        if (!is_null($master_id)) {
            $stocks = $stocks->filter(function ($stock) use ($master_id) {
                return $stock->masterId === $master_id;
            });
        }

        return $stocks->values();
    }
}
