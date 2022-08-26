<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    'blog_visible' => 'boolean',
  ];

  /**
   * Returns a (max) given number of **visible** Blog.
   * Authed users will also get **hidden** Blog.
   */
  public static function some($cnt, $columns = ['*'])
  {
    if (Auth::check()) {
      return Blog::all()->reverse()->take($cnt)->get($columns);
    }
    return Blog::where('blog_visible', true)->orderByDesc('blog_date')->take($cnt)->get($columns);
  }

  /**
   * Returns a all **visible** Blog.
   * Authed users will also get the **hidden** Blog.
   */
  public static function allAuth($columns = ['*'])
  {
    if (Auth::check()) {
      return Blog::all()->reverse()->get($columns);
    }
    return Blog::where('blog_visible', true)->orderByDesc('blog_date')->get($columns);
  }
}
