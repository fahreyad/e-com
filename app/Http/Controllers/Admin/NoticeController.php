<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Notice::latest())
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $color = match ($row->status->value) {
                        0 => ' text-red-600 ',
                        1 => ' text-green-600 ',
                        default => ' text-gray-600 '
                    };
                    return '<span class="text-sm' . $color . '">
                    ' . $row->status->key . '
                    </span>';
                })
                ->rawColumns(['status'])
                ->toJson();
        }
        return view('admin.notice.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'status' => 'nullable|numeric'
        ]);

        return response()->reportTo(
            Notice::create($validated),
            'Created successfully',
            route('admin.notice.index')
        );
    }

    public function edit(Notice $notice)
    {
        return view('admin.notice.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string',
            'status' => 'nullable|numeric'
        ]);
        // Return response
        return response()->reportTo(
            $notice->update($validated),
            'Updated successfully',
            route('admin.notice.index')
        );
    }


    public function destroy(Notice $notice)
    {
        return response()->reportTo(
            $notice->delete(),
            'Deleted successfully',
            route('admin.notice.index')
        );
    }
}
