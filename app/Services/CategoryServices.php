<?php

namespace App\Services;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;

class CategoryServices
{
    public function list()
    {
        return Category::paginate();
    }

    public function store(CategoryStoreRequest $request)
    {
        return Category::create($request->validated());
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
