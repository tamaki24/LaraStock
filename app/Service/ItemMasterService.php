<?php

namespace App\Service;

use App\Repositories\CategoryRepository;
use App\Repositories\ItemMasterRepository;

class ItemMasterService
{
    protected $categoryRepository;
    protected $itemMasterRepository;

    public function __construct(CategoryRepository $categoryRepository, ItemMasterRepository $itemMasterRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->itemMasterRepository = $itemMasterRepository;
    }

    public function getIndexProps()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $items = $this->itemMasterRepository->getAllItemsWithCategories();

        return  [
            'categories' => $categories,
            'items' => $items
        ];
    }

    public function getCreateProps()
    {
        $categories = $this->categoryRepository->getAllCategories();
        return  [
            'categories' => $categories,
        ];
    }

    public function getEditProps($item_id)
    {
        $item = $this->itemMasterRepository->getItem($item_id);
        $categories = $this->categoryRepository->getAllCategories();
        return  [
            'categories' => $categories,
            'item' => $item,
        ];
    }

    public function getFilterItems($category_id)
    {
        $items = $this->itemMasterRepository->getAllItemsWithCategories();
        // filter
        $items = $items->filter(function ($item) use ($category_id) {
            return $item->category_id === $category_id;
        });

        return $items->values();
    }
}
