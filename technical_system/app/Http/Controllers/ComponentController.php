<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Http\Controllers\Controller;
use App\Models\ComponentCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.component.index', [

            'components' => Component::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.component.create', [
            'component_categories' => ComponentCategory::orderBy('id', 'DESC')->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:components',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'component_category_id' => 'required'
        ]);
        $Component = Component::create($data);
        return to_route('component.index')->with('message', 'component created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Component $component)
    {
        return view('admin.component.edit', [
            'repair_component' => $component,
            'component_categories' => ComponentCategory::orderBy('id', 'DESC')->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Component $component)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('components')->ignore($component->id)],
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'component_category_id' => 'required'
        ]);

        $component->update($data);
        return to_route('component.index')->with('message', 'component updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        $component->delete();
        return to_route('component.index')->with('message', 'component was deleted');
    }
}
