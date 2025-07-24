<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Junior;
use App\Models\Senior;

class RandomController extends Controller
{
    public function index()
    {
        return view('random.index');
    }

    public function random(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:juniors,code',
        ]);

        // หา Junior ที่กรอกรหัสมา
        $junior = Junior::where('code', $request->code)->first();

        if ($junior->is_random) {
            return back()->with('error', 'คุณได้ทำการสุ่มไปแล้ว ไม่สามารถสุ่มซ้ำได้');
        }

        // หา Senior ที่ยังรับน้องได้
        $availableSeniors = Senior::where('status', 'available')->get();

        if ($availableSeniors->isEmpty()) {
            return back()->with('error', 'ขณะนี้ไม่มีพี่รหัสว่างสำหรับสุ่ม');
        }

        // สุ่ม Senior แบบสุ่มธรรมดา
        $senior = $availableSeniors->random();

        // เพิ่มน้องรหัสที่เลือกพี่แล้ว
        $junior->senior_id = $senior->id;
        $junior->is_random = true;
        $junior->save();

        // อัปเดตจำนวน current_juniors ของพี่รหัส
        $senior->current_juniors++;
        if ($senior->current_juniors >= $senior->max_juniors) {
            $senior->status = 'full';
        }
        $senior->save();

        return view('random.result', [
            'junior' => $junior,
            'senior' => $senior,
        ]);
    }
}
