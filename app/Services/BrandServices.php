<?php

namespace App\Services;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;

class BrandServices
{
    public function list()
    {
        return Brand::paginate();
    }

    public function store(BrandStoreRequest $request)
    {
        return Brand::create($request->validated());
    }

    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        return $brand;
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
    }
}
