<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRulesRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::select()->paginate(PAGINATION_COUNTER);

        return response()->json([
            $category,
            'code'=> 200],
            200);
    }

    public function store(CategoryRulesRequest $request)
    { 
        // return $request;     
        $category = Category::create([
            'name'=>$request->name,
        ]);

        
        return response()->json([
            $category,
            'message' => __('messages.Added'),
            'code'=> 200],
            200);       
    }

    public function showBooks($id)
    {
        $books=Book::select()->where('category_id',$id)->paginate(PAGINATION_COUNTER);
        return response()->json([
            $books,
            'code'=> 200],
            200);
    }


    public function update(CategoryRulesRequest $request, $id)
    {
        if($category=Category::find($id))
        {
            $category->update([
            'name'=>$request->name,
            ]);

            return response()->json([
                $category,
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
        if($category=Category::find($id))
        {
            $category->delete();
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

}
