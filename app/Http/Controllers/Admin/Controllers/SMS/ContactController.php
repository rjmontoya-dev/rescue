<?php

namespace App\Http\Controllers\Admin\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
                $contacts = $request->validate([
                'name'=>'required|max:255',
                'phone_number'=>'required|max:255',
                'details'=>'required|max:255',
            ]);
        ContactInformation::create($contacts);
        DB::commit();
        return redirect()->back();
        }catch(Throwable $th){
            DB::rollback();
            return $th;
        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();
              $contacts = $request->validate([
                'name'=>'required|max:255',
                'phone_number'=>'required|max:255',
                'details'=>'required|max:255',
            ]);
            $find = ContactInformation::findOrFail($id);
            $find->update($contacts);
            DB::commit();
            return redirect()->back();
        }catch(Throwable $th){
            DB::rollback();
            return $th;
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $find = ContactInformation::findOrFail($id);
        $find->delete();
        return redirect()->back();
    }
}
