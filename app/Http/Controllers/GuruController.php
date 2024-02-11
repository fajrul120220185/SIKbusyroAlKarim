<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MasterGuru;
// use Illuminate\Database\Connection;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;

use App\Models\MGuru;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function Main()
    {
        $data['title'] = 'Master Guru';
        
        $data['guru'] = MGuru::orderBy('name', 'asc')->get();

        return view('master.guru.main')->with($data);
    }

    public function Store(Request $request)
    {
        $guru = MGuru::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'gaji' => $request->gaji,
        ]);

        return response()->json(['success' => true ,'message' => 'updated successfully!','data'    => $guru,]);
    }

    public function Edit ($id)
    {
        $guru = MGuru::where('id', $id)->first();
        if ($guru) {
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'  => $guru,]);
        }else {
            return response()->json(['success' => false ,'message' => 'data tidak ditmukan']);
        }
    }

    public function Update(Request $request)
    {
        $id = $request->id;

        $guru = MGuru::where('id', $id)->first();
        if ($guru) {
            $guru->update([
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'gaji' => $request->gaji,
            ]);
            
        return response()->json(['success' => true ,'message' => 'updated successfully!','data'    => $guru,]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function Delete($id)
    {
        $guru = MGuru::where('id', $id)->first();
        if ($guru) {
            $guru->delete();

            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function Excel(Request $request)
    {
        $path = $request->file('file');
        Excel::import(new MasterGuru, $path->getRealPath(), null, 'Xls');

        return redirect()->back()->with('success', 'Data berhasil diimpor.');


    }

}
