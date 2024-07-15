<?php

namespace App\Http\Controllers;

use App\Repositories\ItemMasterRepository;
use App\Service\ItemMasterService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemMasterController extends Controller
{
    protected $itemMasterService;
    protected $itemMasterRepository;

    public function __construct(ItemMasterRepository $itemMasterRepository, ItemMasterService $itemMasterService)
    {
        $this->itemMasterRepository = $itemMasterRepository;
        $this->itemMasterService = $itemMasterService;
    }


    /***************************************************
     * Display resource.
     ***************************************************/

    /**
     * IndexページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function index()
    {
        $props = $this->itemMasterService->getIndexProps();

        return Inertia::render('Item/Index', $props);
    }

    /**
     * CreateページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function create()
    {
        $props = $this->itemMasterService->getCreateProps();
        return  Inertia::render('Item/Create', $props);
    }

    /**
     * EditページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function edit($stock_id)
    {
        $props = $this->itemMasterService->getEditProps($stock_id);
        return  Inertia::render('Item/Edit', $props);
    }

    /***************************************************
     * API resource.
     ***************************************************/

    /**
     * idに一致する商品を取得する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItem(Request $request)
    {
        $categoryId = $request->query('category_id');
        if (is_null($categoryId)) {
            // all
            $items = $this->itemMasterRepository->getAllItemsWithCategories();
        } else {
            $items = $this->itemMasterService->getFilterItems($categoryId);
        }

        return response()->json($items);
    }

    /**
     * idに一致する商品を編集する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'master_id' => 'required',
            'category_id' => 'required',
            'place' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('master_id');
        $name = $request->input('name');
        $categoryId = $request->input('category_id');
        $place = $request->input('place');
        $remarks = $request->input('remarks');

        $updatedStock = $this->itemMasterRepository->editItem($id, $name, $categoryId, $place, $remarks);

        return response()->json($updatedStock, 200);
    }

    /**
     * 商品を登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'place' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $name = $request->input('name');
        $categoryId = $request->input('category_id');
        $place = $request->input('place');
        $remarks = $request->input('remarks');


        $this->itemMasterRepository->createItem($name, $categoryId, $place, $remarks);

        return response()->json([
            'message' => 'Item created successfully',
        ], 201);
    }

    /**
     * 商品を理論削除する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'master_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('master_id');

        $this->itemMasterRepository->deleteItem($id);

        return response()->json([
            'message' => 'Item deleted successfully',
        ], 201);
    }
}
