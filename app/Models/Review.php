<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Review extends Model
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * 
     */
    protected $table = 'review';

    protected $fillable = [
    
        'id_user',
        'id_book',
        'comment',
        'qualification',
        'review_date',
    ];
}
