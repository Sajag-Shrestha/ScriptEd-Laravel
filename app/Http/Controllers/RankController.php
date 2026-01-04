<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankController extends Controller
{
    // Admin Rank Controller

    public function index()
    {
        $ranks = Rank::orderBy('order')->get();

        return view('admin.ranks.index', compact('ranks'));
    }

    public function create()
    {
        return view('admin.ranks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rank' =>  'required|max:255',
            'order'=>  'required|integer|min:0|unique:ranks,order',
            'icon' =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'req_xp'=> 'required|integer|min:0',
        ]);

        $imageName = time() . '.' . $request->icon->extension();
        $request->icon->move(public_path('uploads/Rank_Icon'), $imageName);
        $iconPath = 'uploads/Rank_Icon/' . $imageName;

        Rank::create([
            'rank' => $request->rank,
            'order' => $request->order,
            'req_xp' => $request->req_xp,
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.ranks.index')->with('success', 'Rank added successfully.');
    }

    public function edit($id)
    {
        $rank = Rank::findOrFail($id);
        return view('admin.ranks.edit', compact('rank'));
    }

    public function update(Request $request, $id)
    {
        $rank = Rank::findOrFail($id);

        $request->validate([
            'rank' => 'required|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'order'=>  'required|integer|min:0|unique:ranks,order,' . $id,
            'req_xp'=> 'required|integer|min:0',
        ]);

        if ($request->hasFile('icon')) {
            if (!empty($rank->icon) && file_exists(public_path($rank->icon))) {
                unlink(public_path($rank->icon));
            }

            $imageName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/Rank_Icon'), $imageName);
            $rank->icon = 'uploads/Rank_Icon/' . $imageName;
        }

        $rank->rank = $request->rank;
        $rank->order = $request->order;
        $rank->req_xp = $request->req_xp;
        $rank->save();

        return redirect()->route('admin.ranks.index')->with('success', 'Rank updated successfully.');
    }

    public function delete($id)
    {
        $rank = Rank::findOrFail($id);

        if (!empty($rank->icon) && file_exists(public_path($rank->icon))) {
            unlink(public_path($rank->icon));
        }

        $rank->delete();

        return redirect()->route('admin.ranks.index')->with('success', 'Rank deleted successfully.');
    }
}
