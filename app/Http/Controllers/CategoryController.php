<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Service\CategoryService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
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
        $props = $this->categoryService->getIndexProps();

        return Inertia::render('Category/Index', $props);
    }

    /**
     * CreateページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function create()
    {
        return  Inertia::render('Category/Create');
    }

    /**
     * EditページとPropsを返す
     *
     * @return \InerLia\Response
     */
    public function edit($category_id)
    {
        $props = $this->categoryService->getEditProps($category_id);
        return  Inertia::render('Category/Edit', $props);
    }

    /***************************************************
     * API resource.
     ***************************************************/

    /**
     * idに一致するカテゴリーを取得する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request)
    {
        // all
        $stocks = $this->categoryRepository->getAllCategories();

        return response()->json($stocks);
    }

    /**
     * idに一致するカテゴリーを編集する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'storage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('category_id');
        $name = $request->input('name');
        $storage = $request->input('storage');

        $updatedStock = $this->categoryRepository->editCategory($id, $name, $storage);

        return response()->json($updatedStock, 200);;
    }

    /**
     * カテゴリーを登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'storage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $name = $request->input('name');
        $storage = $request->input('storage');

        $this->categoryRepository->createCategory($name, $storage);

        return response()->json([
            'message' => 'Stock created successfully',
        ], 201);
    }

    /**
     * idに一致するカテゴリーを削除する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = $request->input('category_id');

        $this->categoryRepository->deleteCategory($id);

        return response()->json([
            'message' => 'Stock deleted successfully',
        ], 201);
    }
}
