<?php

namespace App\Http\Controllers;

use App\Models\hakakses;
use Illuminate\Http\Request;

class HakaksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data['hakakses'] = hakakses::where('name', 'like', "%{$search}%")->get();
        } else {
            $data['hakakses'] = hakakses::all();
        }
        return view('layouts.admin.hakakses.index', $data);
    }

    /**
     * Display the specified resource..
     */
    public function show(hakakses $hakakses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $hakakses = hakakses::find($id);
        return view('layouts.admin.hakakses.edit', compact('hakakses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, hakakses $hakakses, $id)
    {
        //
        $hakakses = hakakses::find($id);
        $hakakses->role = $request->role;
        $hakakses->save();
        return redirect()->route('hakakses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $hakakses = hakakses::find($id);
        $hakakses->delete();
        return redirect()->route('hakakses.index');
    }
}
