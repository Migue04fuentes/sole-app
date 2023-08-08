<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;


class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publisher = Publisher::orderBy('name','asc')->get();
        return response()->json($publisher);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|max:75',
            'country'=>'required|max:35',
            'website'=>'nullable|max:75',
            'email'=>'email|max:75',
            'description'=>'nullable|max:100'
        ]);

        try{
            $publisher = new Publisher();
            $publisher->name = $request->name;
            $publisher->country = $request->country;
            $publisher->website = $request->website;
            $publisher->email = $request->email;
            $publisher->description = $request->description;
            $publisher->save();
            return response()->json(['status'=>true,'message'=>'La creación de la editorial '.$publisher->name.' fue creada exitosamente']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al crear editorial '.$exc]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publisher = Publisher::findOrFail($id);
        return response()->json($publisher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'=>'required|max:75',
            'country'=>'required|max:75',
            'website'=>'required|max:100',
            'email'=>'email|max:75',
            'description'=>'nullable|max:100'
        ]);

         try{
            $publisher = Publisher::findOrFail($id);
            $publisher->name = $request->name;
            $publisher->country = $request->country;
            $publisher->website = $request->website;
            $publisher->email = $request->email;
            $publisher->description = $request->description;
            $publisher->save();
            return response()->json(['status'=>true,'message'=>'La editora '.$publisher->name.' ha sido actualizado exitosamente.']);
         }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al actualizar. '.$exc]);
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $publisher = Publisher::findOrFail($id);
            $publisher->delete();
            return response()->json(['status'=>true,'message'=>'La editora '.$publisher->name.' fue eliminada exitosamente.']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al intenter eliminar editora '.$exc]);
        }
    }
}
