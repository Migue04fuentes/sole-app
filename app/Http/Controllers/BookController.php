<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::orderBy('title','asc')->get();
        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|max:75',
            'subtitle'=>'required|max:250',
            'language'=>'required|max:35',
            'page'=>'required|digits_between:2,4|integer',
            'published'=>'date|date_format:Y-m-d',
            'description'=>'required|max:255',
            'image'=>'nullable|sometimes|image',
            'genre_id'=>'required|integer|exists:genres,id',
            'publisher_id'=>'required|integer|exists:publishers,id',
            'authors' => 'required|array'
        ]);

        try{
            $book = new Book();
            $book->title = $request->title;
            $book->subtitle = $request->subtitle;
            $book->language = $request->language;
            $book->page = $request->page;
            $book->published = $request->published;
            $book->description = $request->description;
            $book->genre_id = $request->genre_id;
            $book->publisher_id = $request->publisher_id;
            $book->save();
            foreach ($request->authors as $author) {
                $book->authors()->attach($author);
            }
            $image_name = $this->loadImage($request);
            if($image_name != ''){
                $book->image()->create(['url'=>'images/'.$image_name]);
            }
            return response()->json(['status'=>true,'message'=>'Se ha creado el libro '.$book->title.' exitosamente.']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al crear libro. '.$exc]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        $image = null;
        if($book->image){
            $image = Storage::url($book->image['url']);
        }
        return response()->json(['Book'=>$book,'Image'=>$image]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'=>'required|max:75',
            'subtitle'=>'required|max:250',
            'language'=>'required|max:35',
            'page'=>'required|integer',
            'published'=>'date|date_format:Y-m-d',
            'description'=>'required|max:255',
            'genre_id'=>'required|integer|exists:genres,id',
            'publisher_id'=>'required|integer|exists:publishers,id',
            'authors'=>'required|array'
        ]);

        try{
            $book = Book::findOrFail($id);
            $book->title = $request->title;
            $book->subtitle = $request->subtitle;
            $book->language = $request->language;
            $book->page = $request->page;
            $book->published = $request->published;
            $book->description = $request->description;
            $book->genre_id = $request->genre_id;
            $book->publisher_id = $request->publisher_id;
            $book->save();
            foreach($request->authors as $author){
                $book->authors()->attach($author);
            }

            $image_name = $this->loadImage($request);
            if($image_name != ''){
                $book->image()->update(['url'=>'images/'.$image_name]);
            }
            return response()->json(['status'=>true,'message'=>'Actualización de '.$book->title.' Exitosa']);
        }catch(\Exception $exc){
            return response()->json(['status'=>false,'message'=>'Error al actualizar '.$exc]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            if($book->image()){
                $book->image()->delete();
            }
            return response()->json(['status'=>true,'message'=>'El libro '.$book->title.' han sido eliminado exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'message'=>' Error al eliminar '.$th]);
        }
    }

    //Save image
    public function loadImage($request){
        $image_name = '';
        if($request->hasFile('image')){
            $destination_path = 'public/images';
            $image = $request->file('image');
            $image_name = time().'_'.$image->getClientOriginalName();
            $request->file('image')->storeAs($destination_path,$image_name);
        }
        return $image_name;
    }
}
