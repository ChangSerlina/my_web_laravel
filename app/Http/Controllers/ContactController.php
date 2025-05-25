<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\service\db_common;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function report_show($page_chose_1 = 'contact')
    {
        $articles = db_common::select_by_route($page_chose_1);
        return view('contact', compact('page_chose_1', 'articles'));
    }

    public function reporting(Request $request)
    {
        try {
            contact::create([
                'name' => $request->name ?? null,
                'email' => $request->email ?? null,
                'phone' => $request->phone ?? null,
                'information' => $request->information ?? null,
            ]);

            return redirect()->route('report_show')->with('success', '送出成功');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
