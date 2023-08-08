<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Note;

class NoteBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $book = Book::findOrFail($id);
        return response()->json(['Book'=>$book,'Notes'=>$book->note()->where('user_id','=',auth()->user()->id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'=>'required|min:5',
            'writing_date'=>'date|date_format:Y-m-d',
            'book.id'=>'required|integer|exists:books,id',
            'user.id'=>'required|integer|exists:users,id'
        ]);

        try{
            $book = Book::findOrFail($request->book['id']);
            $book->note()->create(['description'=>$request->description,'writing_date'=>$request->writing_date,'user_id'=>$request->user['id']]);
            return response()->json(['status'=>true,'message'=>'La nota del libro '.$book->title.' fue creado exitosamente.']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error el crear nota. '.$exc]);
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
        $validated = $request->validate([
            'description'=>'required|min:5',
            'writing_date'=>'date|date_format:Y-m-d',
            'book.id'=>'required|integer|exists:books,id',
            'user.id'=>'required|integer|exists:users,id',
        ]);

        try {
            $note = Note::findOrFail($id);
            $note->description = $request->description;
            $note->writing_date = $request->writing_date;
            $note->save();
            return response()->json(['status'=>true,'message'=>'La nota del autor '.$request->book['title'].' fue actualizado exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'message'=>'Error al editar la nota del libro. '.$th]);
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
        }catch(\Throwable $th){
            return response()->json(['status'=>false,'message'=>'Error al eliminar registro.']);
        }
    }
}
