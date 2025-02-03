<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionLog;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class ProductionLogController extends Controller
{

    // Menampilkan form beserta data produk
    public function showForm()
    {
        // Mengambil semua data dari tabel production_log, disorting berdasarkan created_at
        $productionLogs = ProductionLog::orderBy('created_at', 'desc')->get();

        // Mengirim data ke view 'production-log'
        return view('production-log', compact('productionLogs'));
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'date' => 'required|date',
            'product_type' => 'required|in:PACA,PACS,PACV,PACA_EXPORT',
            'total_good_product' => 'required|integer',
            'total_defect' => 'required|integer',
        ]);
    
        try {
            // Menyimpan data form ke dalam tabel production_log dengan menambahkan nama user
            ProductionLog::create([
                'date' => $request->date,
                'product_type' => $request->product_type,
                'good_product' => $request->total_good_product,
                'total_defect' => $request->total_defect,
                'user_name' => Auth::user()->name,  // Menyimpan nama user yang login
            ]);
            \Log::info('User name: ' . Auth::user()->name);
    
            return response()->json(['status' => 'success', 'message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred. Please try again']);
        }
    }
    

    // Mendapatkan data produk untuk DataTable
    public function getData(Request $request)
    {
        try {
            $productionLogs = ProductionLog::query();

            // Menggunakan DataTables untuk mengembalikan data produk dalam format JSON
            return DataTables::of($productionLogs)
                ->make(true);

        } catch (\Exception $e) {
            // Jika terjadi kesalahan, log error dan kirimkan respons error
            \Log::error('DataTables Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while fetching data'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'product_type' => 'required|in:PACA,PACS,PACV,PACA_EXPORT',
            'total_good_product' => 'required|integer',
            'total_defect' => 'required|integer',
        ]);
    
        try {
            $productionLog = ProductionLog::findOrFail($id);
            $productionLog->date = $request->date;
            $productionLog->product_type = $request->product_type;
            $productionLog->good_product = $request->total_good_product;
            $productionLog->total_defect = $request->total_defect;
            $productionLog->save();
    
            return response()->json(['status' => 'success', 'message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred. Please try again']);
        }
    }
}
