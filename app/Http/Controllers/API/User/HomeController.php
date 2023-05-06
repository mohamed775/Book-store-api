<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function books($id)
    {
        $books = Book::select()->where('category_id',$id)->paginate(PAGINATION_COUNTER);
            return response()->json([
                $books,
                'code'=> 200],
                200);
       
    }

    public function allBooks()
    {
        $books = Book::select()->paginate(PAGINATION_COUNTER);
        return response()->json([
            $books,
            'code'=> 200],
            200);
    }

    public function search()
    {
        $search = request('book');
        $book = Book::select()->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->paginate(PAGINATION_COUNTER);
        return response()->json([
            $book,
            'code'=> 200],
            200);
    }
}
