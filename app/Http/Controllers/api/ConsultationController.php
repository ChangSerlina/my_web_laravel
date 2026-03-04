<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date_format:Y-m-d',
            'description' => 'required|string|max:5000',
        ]);

        try {
            Contact::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'date' => $validated['date'],
                'information' => $validated['description'],
            ]);

            return response()->json([
                'message' => '預約成功'
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => '預約失敗'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
