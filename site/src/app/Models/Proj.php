<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proj extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'title',
    'description',
    'url',
    'img',
  ];
}
