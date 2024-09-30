<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return $this->sendRespons($categories, 'categories have been retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = $this->categoryService->createCategory($validated);
        return $this->sendRespons($category, 'category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        try {
            $category = $this->categoryService->showById($categoryId);
            return $this->sendRespons($category, 'category retrieve successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'retrieve failed');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $categoryId)
    {
        try {
            $validated = $request->validated();
            $category = $this->categoryService->updateCategory($validated, $categoryId);
            return $this->sendRespons($category, 'category updated successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        try {
            $this->categoryService->deleteCategory($categoryId);
            return $this->sendRespons([], 'category deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'delete failed');
        }
    }
}
