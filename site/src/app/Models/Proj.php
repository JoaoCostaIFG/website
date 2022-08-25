<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proj extends Model
{
  use HasFactory;

  protected $primaryKey = 'proj_id';
  public $timestamps = false;

  protected $fillable = [
    'proj_title',
    'proj_description',
    'proj_url',
    'proj_img',
  ];
}
