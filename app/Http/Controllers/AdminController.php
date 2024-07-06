<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         if ($request->ajax()) {
             $data = User::where('role', 'admin');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->editColumn('ktp', function($row) {
                    if ($row->ktp) {
                        $url = asset('storage/' . $row->ktp);
                        return '<a class="" href="' . $url . '" target="_blank">link</a>';
                    } else {
                        return 'tidak ada';
                    }
                 })
                 ->editColumn('status', function($row) {
                     $badgeClasses = [
                         'active' => 'badge-success',
                         'inactive' => 'badge-danger',
                     ];
                     $badgeClass = $badgeClasses[$row->status] ?? 'badge-default';
                     return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                 })
                 ->addColumn('action', function($row) {
                     return '<a href="' . route('data-admin.edit', $row->id) . '" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>';
                 })
                 ->rawColumns(['status', 'action','ktp'])
                 ->make(true);
         }
 
         return view('admin.dataAdmin.index');
     }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dataAdmin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'ktp' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'role' => 'required|string|in:admin',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['name', 'email', 'phone', 'address', 'role', 'status']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('ktp')) {
            $data['ktp'] = $request->file('ktp')->store('ktp', 'public');
        }

        $user = User::create($data);

        return redirect()->route('data-admin.index')->with('success', 'Admin berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        return view('admin.dataAdmin.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:8',
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|string|max:255',
            'ktp' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'role' => 'required|string|in:admin',
            'status' => 'sometimes|required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['name', 'email', 'phone', 'address', 'role', 'status']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('ktp')) {
            if ($user->ktp) {
                Storage::disk('public')->delete($user->ktp);
            }
            $data['ktp'] = $request->file('ktp')->store('ktp', 'public');
        }

        $user->update($data);

        return redirect()->route('data-admin.index')->with('success', 'Admin berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
 
    }
}
