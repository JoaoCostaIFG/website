<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;

  protected $primaryKey = 'blog_id';
  public $timestamps = false;

  protected $fillable = [
    'blog_date',
    'blog_title',
    'blog_intro',
    'blog_content',
    'blog_visible',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'blog_date' => 'datetime',
  ];
}
