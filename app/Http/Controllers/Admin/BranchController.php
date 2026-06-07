<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Branch::orderBy('created_at', 'desc'))
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.branch.index');
    }

    public function create()
    {
        return view('admin.branch.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:branches,email',
            'phone'    => 'required|string|max:20',
            'location' => 'required|string',
        ]);

     

        return response()->reportTo(
            Branch::create($validated),
            'Created successfully',
            route('admin.branch.index')
        );
    }

    public function edit(Branch $branch)
    {
        return view('admin.branch.edit', compact('branch'));
    }


    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:branches,email',
            'phone'    => 'required|string|max:20',
            'location' => 'required|string',
        ]);

        // Return response
        return response()->reportTo(
            $branch->update($validated),
            'Updated successfully',
            route('admin.branch.index')
        );
    }


    public function destroy(Branch $branch)
    {
        return response()->report(
            $branch->delete(),
            'Deleted successfully',
        );
    }

    public function branchSelect(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        $branch = Branch::findOrFail($validated['branch_id']);

        // Just set the session directly (overwrites old value)
        session()->put('branch', [
            'id' => $branch->id,
            'name' => $branch->name,
        ]);

        return redirect()->back()->with('success', 'Branch selected!');
    }
}
