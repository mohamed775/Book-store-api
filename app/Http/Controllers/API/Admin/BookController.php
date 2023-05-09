<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRulesRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::select()->paginate(PAGINATION_COUNTER);

        return response()->json([
            $books,
            'code'=> 200],
            200);
    }

    public function store(BookRulesRequest $request)
    {
        $file_name = $this->getImage($request);

        $book = Book::create([
             'name'=>$request->name,
             'image'=>$file_name,
             'category_id'=>$request->category_id,
             'price'=>$request->price,
             'author'=>$request->author,
             
        ]);

        return response()->json([
            $book,
            'message' =>__('messages.Added'),
            'code'=> 200],
            200);       
    }

    public function update(BookRulesRequest $request, $id)
    {
        $file_name = $this->getImage($request);
        
        if($book=Book::find($id))
        {
            $book->update([
                'name'=>$request->name,
                'image'=>$file_name,
                'category_id'=>$request->category_id,
                'price'=>$request->price,
                'author'=>$request->author,
                
           ]);

           return response()->json([
            $book,
            'message' => __('messages.Updated'),
            'code'=> 200],
            200);  
        }

        else 
        {
            return response()->json([
                'message' => __('messages.updateFailed'),
                'code'=> 201],
                201); 
        }
    }

    public function delete($id)
    {
        if($book=Book::find($id))
        {
            $book->delete();
            return response()->json([
                'message' =>__('messages.Deleted'),
                'code'=> 200],
                200);  
        }  
        else 
        {
            return response()->json([
                'message' =>__('messages.deleteFailed'),
                'code'=> 201],
                201); 
        }
    }

    protected function getImage($request)
    {
        $image = $request->file('image');
        $file_extention = $image->getClientOriginalName();
        $file_name = \Str::random(30) . $file_extention;
        $path = 'images/books';
        $image->move($path, $file_name);
        return $file_name;
    }
}
