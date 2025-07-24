<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Senior;
use App\Models\Junior;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SeniorsImport;
use App\Imports\JuniorsImport;
use App\Exports\RandomResultExport;

class AdminController extends Controller
{
    // แสดงหน้าจัดการพี่รหัส
    public function dash()
    {
        $totalJuniors = Junior::count();
        $totalSeniors = Senior::count();
        return view('admin.index', compact('totalJuniors', 'totalSeniors'));
    }
    
    public function seniors()
    {
        $seniors = Senior::all();
        return view('admin.seniors', compact('seniors'));
    }

    // เพิ่มพี่รหัสใหม่
    public function storeSenior(Request $request)
    {

        $data = $request->validate([
            'code' => 'required|unique:seniors,code',
            'name' => 'required',
            'max_juniors' => 'required|integer|min:1',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            // สร้างชื่อไฟล์แบบสุ่ม
            $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            // ย้ายไฟล์ไปที่ public/storage/uploads/seniors
            $request->file('photo')->move(public_path('storage/uploads/seniors'), $filename);

            // เก็บพาธแบบ URL (ตามที่คุณต้องการ)
            $data['photo'] = '/public/storage/uploads/seniors/' . $filename;
        }


        Senior::create($data);
        return back()->with('success', 'เพิ่มพี่รหัสสำเร็จ');
    }

    // แก้ไขข้อมูลพี่รหัส
    public function updateSenior(Request $request, $id)
    {
        $senior = Senior::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'max_juniors' => 'required|integer|min:1',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            // สร้างชื่อไฟล์แบบสุ่ม
            $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            // ย้ายไฟล์ไปที่ public/storage/uploads/seniors
            $request->file('photo')->move(public_path('storage/uploads/seniors'), $filename);

            // เก็บพาธแบบ URL (ตามที่คุณต้องการ)
            $data['photo'] = '/public/storage/uploads/seniors/' . $filename;
        }

        $senior->update($data);
        return back()->with('success', 'แก้ไขพี่รหัสสำเร็จ');
    }

    // ลบพี่รหัส
    public function deleteSenior($id)
    {
        $senior = Senior::findOrFail($id);
        $senior->delete();
        return back()->with('success', 'ลบพี่รหัสสำเร็จ');
    }

    // แสดงหน้าจัดการน้องรหัส
    public function juniors()
    {
        $juniors = Junior::with('senior')->get();
        return view('admin.juniors', compact('juniors'));
    }

    // เพิ่มน้องรหัสใหม่
    public function storeJunior(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:juniors,code',
            'name' => 'required',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            // สร้างชื่อไฟล์แบบสุ่ม
            $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            // ย้ายไฟล์ไปที่ public/storage/uploads/juniors
            $request->file('photo')->move(public_path('storage/uploads/juniors'), $filename);

            // เก็บพาธแบบ URL (ตามที่คุณต้องการ)
            $data['photo'] = '/public/storage/uploads/juniors/' . $filename;
        }

        Junior::create($data);
        return back()->with('success', 'เพิ่มน้องรหัสสำเร็จ');
    }

    // แก้ไขข้อมูลน้องรหัส
    public function updateJunior(Request $request, $id)
    {
        $junior = Junior::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            // สร้างชื่อไฟล์แบบสุ่ม
            $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

            // ย้ายไฟล์ไปที่ public/storage/uploads/juniors
            $request->file('photo')->move(public_path('storage/uploads/juniors'), $filename);

            // เก็บพาธแบบ URL (ตามที่คุณต้องการ)
            $data['photo'] = '/public/storage/uploads/juniors/' . $filename;
        }

        $junior->update($data);
        return back()->with('success', 'แก้ไขน้องรหัสสำเร็จ');
    }

    // ลบน้องรหัส
    public function deleteJunior($id)
    {
        $junior = Junior::findOrFail($id);
        $junior->delete();
        return back()->with('success', 'ลบน้องรหัสสำเร็จ');
    }

    // Import พี่รหัสจาก CSV
    public function importSeniors(Request $request)
    {
        // ตรวจสอบว่ารหัสนี้มีอยู่แล้วไหม
        if (Senior::where('code', $request->code)->exists()) {
            return back()->withErrors(['code' => 'รหัสนี้มีอยู่แล้ว']);
        }

        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        Excel::import(new SeniorsImport, $request->file('file'));
        return back()->with('success', 'Import พี่รหัสสำเร็จ');
    }

    // Import น้องรหัสจาก CSV
    public function importJuniors(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        Excel::import(new JuniorsImport, $request->file('file'));
        return back()->with('success', 'Import น้องรหัสสำเร็จ');
    }

    // Export Excel สรุปผลทั้งหมด
    public function exportResults()
    {
        return Excel::download(new RandomResultExport, 'random_results.xlsx');
    }
}
