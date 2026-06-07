<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Team::get())->addIndexColumn()->toJson();
        }
        return view('admin.team.index');
    }


    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial'        => 'nullable|integer',
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:5120', // if uploading an image
            'name'          => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
            'fb_link'       => 'nullable|url|max:255',
            'youtube_link'  => 'nullable|url|max:255',
        ]);

        return response()->reportTo(
            Team::create($validated),
            'Created successfully',
            route('admin.team.index')
        );
    }

    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {

        // Validate input
        $validated = $request->validate([
            'serial'        => 'nullable|integer',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // if uploading an image
            'name'          => 'nullable|string|max:255',
            'designation'   => 'nullable|string|max:255',
            'fb_link'       => 'nullable|url|max:255',
            'youtube_link'  => 'nullable|url|max:255',

        ]);


        // Return response
        return response()->reportTo(
            $team->update($validated),
            'Updated successfully',
            route('admin.team.index')
        );
    }


    public function destroy(Team $team)
    {
        return response()->reportTo(
            $team->delete(),
            'Deleted successfully',
            route('admin.team.index')
        );
    }
}
