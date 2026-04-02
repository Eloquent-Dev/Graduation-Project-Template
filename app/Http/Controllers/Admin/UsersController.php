<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Category;

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
        $newRole = $validated['role'];
        if($oldRole === 'citizen'){
            Employee::firstOrCreate([
                'user_id' => $user->id
            ]);
        }else if( in_array($oldRole,['dispatcher','admin','supervisor','worker']) && $newRole === 'citizen'){
            $user->employee()->delete();
        }
        $user->update(['role' => $newRole]);

        return back()->with('success',"{$user->name}'s role has been updated from {$oldRole} to {$validated['role']}.");
    }

    public function updateDivision(Request $request,User $user){
        if(!in_array($user->role,['dispatcher','worker','supervisor','admin'])){
            return redirect()->route('admin.users.index')->with('error','Divisions can only be assigned to employees');
        }

        $validated = $request->validate([
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        $divisionId = $validated['division_id'] ?? null;

        $user->employee()->update(['division_id' => $divisionId]);

        if($divisionId){
            $divisionName = Division::find($divisionId)->name;
            $message = "{$user->name} has been successfully assigned to: {$divisionName}.";
        }else{
            $message = "{$user->name} has been successfully unassigned from all divisions.";
        }

        return redirect()->route('admin.users.index')->with('success',$message);
    }

    public function complaints(User $user){
        $categories = Category::all();
        $complaints = $user->complaint()->orderBy('id', 'asc')->paginate(15);

        return view('admin.users.complaints',compact('user','complaints','categories'));
    }

    public function updateDetails(Request $request, Complaint $complaint){

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:pending,under_review,approved,reopened,in_progress,resolved,rejected'
        ]);

        $complaint->update([
            'category_id' => $validated['category_id'],
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Complaint Details Updated Successfully.');
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
