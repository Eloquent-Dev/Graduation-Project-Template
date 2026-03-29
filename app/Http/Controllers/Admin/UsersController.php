<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;

class UsersController extends Controller
{
    public function index(Request $request){
        $query = User::with('employee');

        if($request->filled('search')){
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm){
                $q->where('name', 'like', $searchTerm)
                ->orWhere('email', 'like',$searchTerm)
                ->orWhere('national_no', 'like', $searchTerm);
            });
        }

        if($request->filled('role')) $query->where('role', $request->role);

        $users = $query->orderBy('created_at','asc')->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role','admin')->count(),
            'dispatchers' => User::where('role','dispatcher')->count(),
            'supervisors' => User::where('role','supervisor')->count(),
            'workers' => User::where('role','worker')->count(),
            'citizens' => User::where('role','citizen')->count()
        ];

        $divisions = Division::orderBy('name')->get();

        return view('admin.users.index', compact('users','stats','divisions'));
    }

    public function updateRole(Request $request,User $user){
        if($user->id === auth()->id()){
            return back()->with('error','Critical Error: You can\'t demote your own Admin account.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,supervisor,worker,dispatcher,citizen'
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $validated['role']]);

        return back()->with('success',"{$user->name}'s role has been updated from {$oldRole} to {$validated['role']}.");
    }

    public function updateDivision(Request $request,User $user){
        if(!in_array($user->role,['dispatcher','worker','supervisor','admin'])){
            return back()->with('error','Divisions can only be assigned to employees');
        }

        $validated = $request->validate([
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        $user->employee()->update(['division_id' => $validated['division_id']]);

        $divisionName = Division::find($validated['division_id'])->name;

        return back()->with('success',"{$user->name} has been successfully assigned to: {$divisionName}.");
    }

    public function destroy(User $user){
        if($user->id === auth()->id()){
            return back()->with('error','Critical Error: You can\'t delete your own Admin account.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User {$userName} has been permanently deleted from the system.");
    }
}
