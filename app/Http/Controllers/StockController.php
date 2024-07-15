<?php

namespace App\Http\Controllers;

use App\Service\StockService;
use App\Repositories\StockRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockController extends Controller
{
    protected $stockService;
    protected $stockRepository;

    public function __construct(StockRepository $stockRepository, StockService $stockService)
    {
        $this->stockRepository = $stockRepository;
        $this->stockService = $stockService;
    }

    /***************************************************
     * Display resource.
     ***************************************************/

    /**
     * Indexページと在庫を返す
     *
     * @return \InerLia\Response
     */
    public function index()
    {
        $props = $this->stockService->getIndexProps();

        return Inertia::render('Stock/Index', $props);
    }

    /**
     * HomeページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function home()
    {
        $props = $this->stockService->getHomeProps();
        return Inertia::render('Home', $props);
    }

    /**
     * CreateページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function create()
    {
        $props = $this->stockService->getCreateProps();
        return  Inertia::render('Stock/Create', $props);
    }

    /**
     * EditページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function edit($stock_id)
    {

        $props = $this->stockService->getEditProps($stock_id);
        return  Inertia::render('Stock/Edit', $props);
    }

    /***************************************************
     * API resource.
     ***************************************************/

    /**
     * idに一致する在庫を取得する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStocks(Request $request)
    {
        $categoryId = $request->query('category_id');
        $masterId = $request->input('master_id');

        // all
        if (is_null($categoryId) && is_null($masterId)) {
            $stocks = $this->stockRepository->getAllStocks();
        } else {
            $stocks = $this->stockService->getfilterStocks($categoryId, $masterId);
        }

        return response()->json($stocks);
    }

    /**
     * idに一致する在庫を編集する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stock_id' => 'required',
            'stock' => 'required',
            'deadline' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('stock_id');
        $stock = $request->input('stock');
        $deadline = $request->input('deadline');

        $updatedStock = $this->stockRepository->editStock($id, $stock, $deadline);

        return response()->json($updatedStock, 200);;
    }

    /**
     * 在庫を登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'master_id' => 'required',
            'stock' => 'required',
            'deadline' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stock = $request->input('stock');
        $deadline = $request->input('deadline');
        $masterId = $request->input('master_id');

        $this->stockRepository->createStock($stock, $deadline, $masterId);

        return response()->json([
            'message' => 'Stock created successfully',
        ], 201);
    }

    /**
     * idに一致する在庫を削除する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stock_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('stock_id');

        $this->stockRepository->deleteStock($id);

        return response()->json([
            'message' => 'Stock deleted successfully',
        ], 201);
    }
}
