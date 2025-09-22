<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of team members
     */
    public function index()
    {
        $teamMembers = TeamMember::orderBy('sort_order', 'asc')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        return view('admin.team.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created team member
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/team');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $data['image'] = 'images/team/' . $filename;
        }

        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        TeamMember::create($data);

        return redirect()->route('admin.team.index')
                        ->with('success', 'Team member created successfully!');
    }

    /**
     * Display the specified team member
     */
    public function show(TeamMember $teamMember)
    {
        return view('admin.team.show', compact('teamMember'));
    }

    /**
     * Show the form for editing the specified team member
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team.edit', compact('teamMember'));
    }

    /**
     * Update the specified team member
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teamMember->image) {
                $oldImagePath = public_path($teamMember->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/team');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $data['image'] = 'images/team/' . $filename;
        }

        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? $teamMember->sort_order;

        $teamMember->update($data);

        return redirect()->route('admin.team.show', $teamMember)
                        ->with('success', 'Team member updated successfully!');
    }

    /**
     * Remove the specified team member
     */
    public function destroy(TeamMember $teamMember)
    {
        // Delete image if exists
        if ($teamMember->image) {
            $imagePath = public_path($teamMember->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $teamMember->delete();

        return redirect()->route('admin.team.index')
                        ->with('success', 'Team member deleted successfully!');
    }
}