<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Category extends Model
{
    //use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * 
     */
    protected $table = 'category';

    protected $fillable = [
        'id',
        'name',
    ];
}
