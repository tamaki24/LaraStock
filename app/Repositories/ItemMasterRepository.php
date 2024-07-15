<?php

namespace App\Repositories;

use App\Interfaces\ItemMasterRepositoryInterface;
use Illuminate\Support\Str;
use App\Models\ItemMaster;
use Exception;

class ItemMasterRepository implements ItemMasterRepositoryInterface
{

    protected $item;

    public function __construct(ItemMaster $item)
    {
        $this->item = $item;
    }

    public function getAllItems()
    {
        try {
            $items = $this->item::all();
            return $items;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getAllItemsWithCategories()
    {
        return ItemMaster::with('category')->get();
    }

    public function getItem($id)
    {
        try {
            $item = $this->item::with('category')->find($id);

            return $item;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function editItem($id, $name, $categoryId, $place, $remarks)
    {
        try {
            $data = $this->item::find($id);

            if (!$data) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            // 更新
            $data->name = $name;
            $data->category_id = $categoryId;
            $data->place = $place;
            $data->remarks = $remarks;

            $data->save();

            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function createItem($name, $categoryId, $place, $remarks)
    {
        try {
            $data = new ItemMaster();
            $data->id = Str::uuid();
            $data->name = $name;
            $data->category_id = $categoryId;
            $data->place = $place;
            $data->remarks = $remarks;

            $data->save();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function deleteItem($id)
    {
        try {
            $data = $this->item::find($id);

            if (!$data) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            $data->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
