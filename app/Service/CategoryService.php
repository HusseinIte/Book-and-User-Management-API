<?php

namespace App\Service;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        $categories = Category::all();
        return $categories;
    }

    public function createCategory(array $data)
    {
        return Category::create([
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : null
        ]);
    }

    public function updateCategory(array $data, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update([
            'name'        => isset($data['name']) ? $data['name'] : $category->name,
            'description' => isset($data['description']) ? $data['description'] : $category->description
        ]);
        return $category;
    }
    public function showById($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return $category;
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
    }
}
