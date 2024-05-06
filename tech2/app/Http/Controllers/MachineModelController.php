<?php

namespace App\Http\Controllers;

use App\Models\MachineModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MachineModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.machine_model.index', [
            'machine_models' => MachineModel::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.machine_model.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:machine_models',
            'weight' => 'required|numeric',
        ]);
        $MachineModel = MachineModel::create($data);
        return to_route('machine_model.index')->with('message', 'machine model created');
    }

    /**
     * Display the specified resource.
     */
    public function show(MachineModel $machineModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MachineModel $machineModel)
    {
        return view('admin.machine_model.edit', [
            'machine_model' => $machineModel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MachineModel $machineModel)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('machine_models')->ignore($machineModel->id)],
            'weight' => 'required|numeric',
        ]);

        $machineModel->update($data);

        return to_route('machine_model.index')->with('message', 'machine model was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MachineModel $machineModel)
    {
        $machineModel->delete();
        return to_route('machine_model.index')->with('message', 'machine model deleted');

    }
}
