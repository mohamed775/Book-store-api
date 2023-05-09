<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table='carts';
    protected $fillable=['user_id','book_id','created_at','updated_at'];
    protected $hidden=['created_at','updated_at'];

    public function book()
    {
        return $this->belongsTo(Book::class,'book_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
