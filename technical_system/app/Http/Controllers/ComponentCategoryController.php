<?php

namespace App\Http\Controllers;

use App\Models\ComponentCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComponentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.component_category.index', [
            'component_categories' => ComponentCategory::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.component_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:component_categories',
        ]);
        $ComponentCategory = ComponentCategory::create($data);
        return to_route('component_category.index')->with('message', 'component category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComponentCategory $componentCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComponentCategory $componentCategory)
    {
        return view('admin.component_category.edit', [
            'component_category' => $componentCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComponentCategory $componentCategory)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('component_categories')->ignore($componentCategory->id)],
        ]);

        $componentCategory->update($data);

        return to_route('component_category.index')->with('message', 'component category was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponentCategory $componentCategory)
    {
        $componentCategory->delete();
        return to_route('component_category.index')->with('message', 'component category was deleted');
    }
}
