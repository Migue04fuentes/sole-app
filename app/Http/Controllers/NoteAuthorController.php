<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Author;

class NoteAuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $author = Author::findOrFail($id);
        return response()->json(['author'=>$author,'notes'=>$author->note()->where('user_id','=',auth()->user()->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $author = Author::findOrFail($request->author['id']);
            $author->note()->create(['description'=>$request->description,'writing_date'=>$request->writing_date,'user_id'=>$request->user['id']]);
            return response()->json(['status'=>true,'message'=>'La nota del autor '.$author->full_name.' fue creado exitosamente']);
        } catch (\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al crear registro'. $exc]);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->description = $request->description;
            $note->writing_date = $request->writing_date;
            $note->save();
            return response()->json(['status'=>true,'message'=>'La nota del autor '.$request->author['full_name'].' fue actualizado exitosamente']);
        } catch (\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al editar el registro']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $note = Note::findOrFail($id);
            $note->delete();
            return response()->json(['status'=>true,'message'=>'La nota fue eliminada exitosamente.']);
        } catch (\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al eliminar el registro']);
        }
    }
}
