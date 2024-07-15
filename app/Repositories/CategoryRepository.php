<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Str;
use App\Models\Category;
use Exception;

class CategoryRepository implements CategoryRepositoryInterface
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategories()
    {
        try {
            $category = $this->category::all();
            return $category;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getCategory($id)
    {
        try {
            $category = $this->category::find($id);

            return $category;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function editCategory($id, $name, $storage)
    {
        try {
            $data = $this->category::find($id);

            if (!$data) {
                return response()->json(['message' => 'Stock not found'], 404);
            }

            $data->name = $name;
            $data->storage = $storage;

            $data->save();

            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function createCategory($name, $storage)
    {
        try {
            $data = new Category();
            $data->id = Str::uuid();
            $data->name = $name;
            $data->storage = $storage;

            $data->save();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $data = $this->category::find($id);

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
