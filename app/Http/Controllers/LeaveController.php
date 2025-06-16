<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaves;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class LeaveController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Leaves::select('leaves.*', 'users.email', 'users.name')
                ->join('users', 'users.id', '=', 'leaves.user_id')
                ->orderBy('leaves.created_at', 'desc');

            if ($request->has('search')) {
                $query->where('users.email', 'like', '%' . $request->search . '%');
            }

            return response()->json($query->paginate(5));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch leaves',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $user = Leaves::findOrFail($id);
            $user->status = 1;
            $user->save();

            DB::commit();

            return response()->json(['message' => 'User approved successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Approval failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();

            $user = Leaves::findOrFail($id);
            $user->status = 2;
            $user->save();

            DB::commit();

            return response()->json(['message' => 'User rejected successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Rejection failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $overlapExists = Leaves::where('user_id', Auth::id())
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlapExists) {
            return response()->json([
                'message' => 'You have already applied for leave in this date range.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $leave = Leaves::create([
                'user_id' => Auth::id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'status' => 0,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Leave applied successfully',
                'data' => $leave
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to apply leave',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
