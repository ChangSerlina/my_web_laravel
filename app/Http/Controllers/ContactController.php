<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function report_show()
    {
        return view('contact');
    }

    public function reporting(Request $request)
    {
        try {
            contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'information' => $request->information,
            ]);

            return redirect()->route('contact')->with('success', '送出成功');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
