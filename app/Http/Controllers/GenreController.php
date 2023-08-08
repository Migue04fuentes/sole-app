<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genre = Genre::orderBy('name','asc')->get();
        return response()->json($genre);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|max:75',
            'description'=>'required|max:255'
        ]);

        try{
            $genre = new Genre();
            $genre->name = $request->name;
            $genre->description = $request->description;
            $genre->save();
            return response()->json(['status'=>true,'message'=>'El género '.$genre->name.' fue creado exitosamente.']);
        } catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al crear un género. '.$exc]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::find($id);
        return response()->json($genre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'=>'required|max:75',
            'description'=>'required|max:255'
        ]);

        try{
            $genre = Genre::findOrFail($id);
            $genre->name = $request->name;
            $genre->description = $request->description;
            $genre->save();

            return response()->json(['status'=>true,'message'=>'El género '.$genre->name.' fue actualizado exitosamente.']);
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
            $genre = Genre::findOrFail($id);
            $genre->delete();
            return response()->json(['status'=>true,'message'=>'El género '.$genre->name.' fue eliminado exitosamente.']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al eliminar género. '.$exc]);
        }
    }
}
