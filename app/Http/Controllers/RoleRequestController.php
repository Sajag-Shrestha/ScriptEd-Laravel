<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    // Admin Role Request Controller
    public function index()
    {
        $roleRequests = RoleRequest::with('user')->latest()->get();

        return view('admin.role-requests.index', compact('roleRequests'));
    }

    public function approve($id)
    {
        $request = RoleRequest::findOrFail($id);
        $user = $request->user;

        $user->role = 'Teacher';
        $user->status = 'Approved';
        $user->save();

        return redirect()->route('admin.role-requests.index')->with('success', 'Request approved successfully.');
    }

    public function reject($id)
    {
        $request = RoleRequest::findOrFail($id);
        $user = $request->user;

        $user->status = 'Rejected';
        $user->save();

        return redirect()->route('admin.role-requests.index')->with('success', 'Request rejected successfully.');
    }

    public function revaluate($id)
    {
        $request = RoleRequest::findOrFail($id);
        $user = $request->user;

        $user->status = 'Pending';
        $user->save();

        return back()->with('success', 'Request has been set for re-evaluation.');
    }

    public function revert($id)
{
    $request = RoleRequest::findOrFail($id);
    $user = $request->user;

    $user->role = 'Student';
    $user->status = 'Pending';
    $user->save();

    return redirect()->back()->with('success', 'The user\'s status has been reverted to Pending and their role reset to Student.');
}

    // Student / Teacher Role Request Controller
    public function store(Request $request)
    {
        $request->validate([
            'request_msg' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();
        RoleRequest::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'request_msg' => $request->request_msg,
        ]);

        $user->status = 'Pending';
        $user->save();

        return back()->with('success', 'Request sent to admin.');
    }

}
