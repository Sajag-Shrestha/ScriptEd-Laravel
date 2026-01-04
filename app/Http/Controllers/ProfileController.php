<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Achievement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show()
    {

        $user = Auth::user();
        // Get existing affiliations depending on role
        if ($user->role === 'Teacher') {
            $affiliations = $user->affiliatedStudents()->get();
        } else { // student
            $affiliations = $user->affiliatedTeachers()->get();
        }

        $earnedAchievements = $user->achievements()
            ->wherePivotNotNull('earned_at')
            ->withPivot('earned_at', 'progress_data')
            ->with('module')
            ->get();

        return view('profile.profile', compact('user', 'affiliations', 'earnedAchievements'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('q');

        if ($user->role === 'Teacher') {
            $results = User::where('role', 'Student')
                ->where('name', 'like', '%' . $query . '%')
                ->where('id', '!=', $user->id)
                ->limit(10)
                ->get();
        } else {
            $results = User::where('role', 'Teacher')
                ->where('name', 'like', '%' . $query . '%')
                ->where('id', '!=', $user->id)
                ->limit(10)
                ->get();
        }

        return response()->json($results);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $otherUserId = $request->input('user_id');

        // Validation
        if (!$otherUserId) {
            return response()->json(['error' => 'No user selected.'], 400);
        }

        if ($user->role === 'Teacher') {
            // teacher adding student
            $exists = $user->affiliatedStudents()->where('users.id', $otherUserId)->exists();

            if (!$exists) {
                $user->affiliatedStudents()->attach($otherUserId);
            }
        } else {
            // student adding teacher
            $exists = $user->affiliatedTeachers()->where('users.id', $otherUserId)->exists();

            if (!$exists) {
                $user->affiliatedTeachers()->attach($otherUserId);
            }
        }

        return response()->json(['success' => true]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'remove_image' => 'nullable|in:0,1',
        ]);

        // Defined images not to be deleted
        $protectedImages = [
            'uploads/admin.png',
            'uploads/default.png',
            'uploads/student.png',
            'uploads/teacher.png',
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it's not in the protected list
            if ($user->profile_image && !in_array($user->profile_image, $protectedImages)) {
                $oldPath = public_path($user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $user->profile_image = 'uploads/profile_images/' . $imageName;
        }

        // Handle remove image request
        if ($request->input('remove_image') === '1') {
            if ($user->profile_image && !in_array($user->profile_image, $protectedImages)) {
                $oldPath = public_path($user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $user->profile_image = 'uploads/default.png';
        }

        /** @var \App\Models\User $user */
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }




    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        /** @var \App\Models\User $user */
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password does not match our records.']);
        }

        // Delete avatar
        if ($user->profile_image && $user->profile_image != 'default.png') {
            Storage::delete('public/' . $user->profile_image);
        }

        /** @var \App\Models\User $user */
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted.');
    }
}
