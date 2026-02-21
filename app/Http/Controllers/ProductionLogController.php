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
        $productionLogs = ProductionLog::orderBy('created_at', 'desc')->get();
        return view('production-log', compact('productionLogs'));
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'date' => 'required|date',
            'product_type' => 'required|in:PACA,PACS,PACV,PACA_EXPORT,ACH,SCW',
            'total_good_product' => 'required|integer',
            'total_defect' => 'required|integer',
            // 'sg' => 'nullable',
        ]);

        try {

            // Normalisasi koma → titik lalu cast ke float
            $sg = str_replace(',', '.', $request->sg);
            $sg = floatval($sg);

            ProductionLog::create([
                'date' => $request->date,
                'product_type' => $request->product_type,
                'good_product' => $request->total_good_product,
                'total_defect' => $request->total_defect,
                // 'sg' => $sg,
                'user_name' => Auth::user()->name,
            ]);

            \Log::info('User name: ' . Auth::user()->name);

            return response()->json(['status' => 'success', 'message' => 'Data submitted successfully!']);

        } catch (\Exception $e) {
            \Log::error('Store Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred. Please try again']);
        }
    }

    // Data untuk DataTable
    public function getData(Request $request)
    {
        try {
            $productionLogs = ProductionLog::query();

            return DataTables::of($productionLogs)->make(true);

        } catch (\Exception $e) {
            \Log::error('DataTables Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while fetching data'], 500);
        }
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'product_type' => 'required|in:PACA,PACS,PACV,PACA_EXPORT,ACH,SCW',
            'total_good_product' => 'required|integer',
            'total_defect' => 'required|integer',
            // 'sg' => 'required',
        ]);

        try {

            // Normalisasi
            // $sg = str_replace(',', '.', $request->sg);
            // $sg = floatval($sg);

            $productionLog = ProductionLog::findOrFail($id);
            $productionLog->date = $request->date;
            $productionLog->product_type = $request->product_type;
            $productionLog->good_product = $request->total_good_product;
            $productionLog->total_defect = $request->total_defect;
            // $productionLog->sg = $sg;
            $productionLog->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully!']);

        } catch (\Exception $e) {
            \Log::error('Update Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred. Please try again']);
        }
    }
}
