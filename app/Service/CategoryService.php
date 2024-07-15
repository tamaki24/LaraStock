<?php

namespace App\Service;

use App\Repositories\CategoryRepository;
use App\Repositories\ItemMasterRepository;

class CategoryService
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
        $items = $this->itemMasterRepository->getAllItems();

        return  [
            'categories' => $categories,
            'items' => $items
        ];
    }

    public function getEditProps($category_id)
    {
        $data = $this->categoryRepository->getCategory($category_id);
        return  [
            'category' => $data,
        ];
    }
}
