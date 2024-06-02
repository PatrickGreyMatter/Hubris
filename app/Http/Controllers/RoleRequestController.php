<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    protected $maxRequests = 1; // Maximum number of pending requests allowed per user

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if the user has reached the maximum number of pending requests
        $pendingRequestsCount = RoleRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingRequestsCount >= $this->maxRequests) {
            return redirect()->back()->with('status', 'Vous avez atteint la limite de demandes de changement de rôles en attente.');
        }

        $request->validate([
            'role' => 'required|string',
            'reason' => 'required|string',
        ]);

        RoleRequest::create([
            'user_id' => $user->id,
            'role' => $request->role,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('status', 'Votre demande a été envoyée.');
    }

    public function approve(Request $request, $id)
    {
        $roleRequest = RoleRequest::findOrFail($id);
        $roleRequest->status = $request->status;

        if ($request->status == 'approved') {
            $roleRequest->user->update(['role' => $roleRequest->role]);
        }

        $roleRequest->delete();

        return redirect()->back()->with('status', 'La demande a été traitée.');
    }
}
