<?php

namespace App\Http\Controllers;

use App\Models\CommonIssue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommonIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.common_issue.index', [

            'common_issues' => CommonIssue::orderBy('id', 'DESC')->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.common_issue.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'issue' => 'required|unique:common_issues',
        ]);
        $commonIssue = CommonIssue::create($data);
        return to_route('common_issue.index')->with('message', 'Common Issue created');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommonIssue $commonIssue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommonIssue $commonIssue)
    {
        return view('admin.common_issue.edit', [

            'common_issue' => $commonIssue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommonIssue $commonIssue)
    {
        $data = $request->validate([
            'issue' => ['required', Rule::unique('common_issues')->ignore($commonIssue->id)],
        ]);

        $commonIssue->update($data);
        return to_route('common_issue.index')->with('message', 'common issue updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommonIssue $commonIssue)
    {
        $commonIssue->delete();
        return to_route('common_issue.index')->with('message', 'common issue deleted');
    }
}
