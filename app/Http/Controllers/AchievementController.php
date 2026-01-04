<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Module;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    // Admin Achievement Controller
    public function index()
    {
        $achievements = Achievement::with('module')->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        // we need modules to populate the Module-Completed dropdown
        $modules = Module::orderBy('name')->get();
        return view('admin.achievements.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'type'              => 'required|in:Module Completed,Time Spent',
            'criteria_module'   => 'required_if:type,Module Completed|nullable|exists:modules,id',
            'criteria_amount'   => 'required_if:type,Time Spent|nullable|integer|min:1',
            'xp_reward'         => 'required|integer|min:0',
            'icon'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        // store the uploaded icon
        $imageName = time() . '.' . $request->icon->extension();
        $request->icon->move(public_path('uploads/Achievement_Icon'), $imageName);
        $iconPath = 'uploads/Achievement_Icon/' . $imageName;

        Achievement::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'type'              => $request->type,
            'criteria_module'   => $request->criteria_module,
            'criteria_amount'   => $request->criteria_amount * 60,
            'xp_reward'         => $request->xp_reward,
            'icon'              => $iconPath,
        ]);

        return redirect()
            ->route('admin.achievements.index')
            ->with('success', 'Achievement created successfully.');
    }

    public function edit($id)
    {
        $achievement = Achievement::findOrFail($id);
        $modules     = Module::orderBy('name')->get();

        return view('admin.achievements.edit', compact('achievement', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'type'              => 'required|in:Module Completed,Time Spent',
            'criteria_module'   => 'required_if:type,Module Completed|nullable|exists:modules,id',
            'criteria_amount'   => 'required_if:type,Time Spent|nullable|integer',
            'xp_reward'         => 'required|integer|min:0',
            'icon'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        if ($request->hasFile('icon')) {
            if (!empty($achievement->icon) && file_exists(public_path($achievement->icon))) {
                unlink(public_path($achievement->icon));
            }

            $imageName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/Achievement_Icon'), $imageName);
            $achievement->icon = 'uploads/Achievement_Icon/' . $imageName;
        }

        $achievement->title           = $request->title;
        $achievement->description     = $request->description;
        $achievement->type            = $request->type;
        $achievement->criteria_module = $request->criteria_module;
        $achievement->criteria_amount = $request->criteria_amount * 60;
        $achievement->xp_reward       = $request->xp_reward;
        $achievement->save();

        return redirect()
            ->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully.');
    }

    public function delete($id)
    {
        $achievement = Achievement::findOrFail($id);

        // delete icon file
        if (!empty($achievement->icon) && file_exists(public_path($achievement->icon))) {
            unlink(public_path($achievement->icon));
        }

        $achievement->delete();

        return redirect()
            ->route('admin.achievements.index')
            ->with('success', 'Achievement deleted successfully.');
    }

    // Student Achievement Controller 
    public function handleAchievementsAndRank(User $user)
    {
        $existing = $user->achievements()
            ->get()
            ->keyBy('id')
            ->map(function ($achievement) {
                return [
                    'earned_at'     => $achievement->pivot->earned_at,
                    'progress_data' => $achievement->pivot->progress_data,
                ];
            })
            ->toArray();
    
        Achievement::cursor()->each(function ($achievement) use ($user, $existing) {
            $type = $achievement->type;
            $criteriaAmount = (int) $achievement->criteria_amount;
            $criteriaModuleId = (int) $achievement->criteria_module;
    
            $progress = [];
            $earned = false;
    
            if ($type === 'Module Completed') {
                $library = $user->libraries()
                    ->where('module_id', $criteriaModuleId)
                    ->where('progress', '>=', 100)
                    ->first();
    
                if ($library) {
                    $earned = true;
                    $progress = ['completed_module' => $criteriaModuleId];
                } else {
                   
                    $incomplete = $user->libraries()
                        ->where('module_id', $criteriaModuleId)
                        ->first();
    
                    if ($incomplete) {
                        $progress = ['progress_percent' => $incomplete->progress];
                    }
                }
            } elseif ($type === 'Time Spent') {
                $totalTime = $user->libraries()->sum('time_spent');
                $progress = ['time_spent' => $totalTime];
                $earned = $totalTime >= $criteriaAmount;
            }
    
            
            $wasEarnedBefore = isset($existing[$achievement->id]) && !empty($existing[$achievement->id]['earned_at']);
    
            
            if ($wasEarnedBefore && !$achievement->repeatable) {
                return;
            }
    
            $earnedAt = $earned ? now() : null;
    
            $user->achievements()->syncWithoutDetaching([
                $achievement->id => [
                    'earned_at'     => $earnedAt,
                    'progress_data' => json_encode($progress),
                ],
            ]);
    
         
            if ($earned && (!$wasEarnedBefore || $achievement->repeatable)) {
                $xpEarned = $achievement->xp_reward ?? 0;
                if ($xpEarned > 0) {
                    $user->xp += $xpEarned;
    
                    
                    $newRank = \App\Models\Rank::where('req_xp', '<=', $user->xp)
                        ->orderByDesc('req_xp')
                        ->first();
    
                    if ($newRank && $newRank->id !== $user->rank_id) {
                        $user->rank_id = $newRank->id;
                    }
    
                    $user->save();
                }
            }
        });
    }
    

    public function progress()
    {
        $user = Auth::user();

        $rank = $user->rank;
        $xp = $user->xp ?? 0;

        $nextRank = Rank::where('req_xp', '>', $xp)->orderBy('req_xp')->first();
        $progressToNextRank = $nextRank ? round(($xp / $nextRank->req_xp) * 100, 2) : 100;

        $achievements = Achievement::with(['users' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();

        return view('student.progress', compact('rank', 'xp', 'nextRank', 'progressToNextRank', 'achievements'));
    }
}
