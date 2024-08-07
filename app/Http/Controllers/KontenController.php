<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Konten::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editUrl = route('konten.edit', $row->id);
                    $deleteUrl = route('konten.destroy', $row->id);
    
                    return [
                        'edit_url' => $editUrl,
                        'delete_url' => $deleteUrl,
                        'id' => $row->id
                    ];
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('admin.konten.index');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.konten.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_konten' => 'required|string|max:255',
            'jadwal_post' => 'required',
            'jadwal_end' => 'required',
            'url' => 'required|string',
            'type' => 'required|string',
        ]);
        $data = $request->only(['nama_konten', 'jadwal_post','jadwal_end', 'url','type']);
        $konten = Konten::create($data);
        return redirect()->route('konten.index')->with('success', 'Konten berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Konten::findOrFail($id);
        return view('admin.konten.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $konten = Konten::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_konten' => 'required|string|max:255',
            'jadwal_post' => 'required',
            'jadwal_end' => 'required',
            'url' => 'required|string',
            'type' => 'required|string',
        ]);

        $data = $request->only(['nama_konten', 'jadwal_post','jadwal_end', 'url','type']);
        $konten->update($data);
        return redirect()->route('konten.index')->with('success', 'Konten berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $konten->delete();
    
        return redirect()->route('konten.index')->with('success', 'Konten berhasil di delete.');
    }
    
}
