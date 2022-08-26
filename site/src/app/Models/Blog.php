<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * Average silent reading words per minute of an adult.
 * Source: https://thereadtime.com
 */
define("AVG_WPM", 238);

class Blog extends Model implements Feedable
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

  public function getDateStr(): string
  {
    return $this['blog_date']->toFormattedDateString();
  }

  /**
   * @return number of words in intro + content
   */
  public function wordCount(): int
  {
    $cnt = str_word_count($this->blog_content);
    if (!is_null($this->blog_intro)) {
      $cnt += str_word_count($this->blog_intro);
    }
    return $cnt;
  }

  /**
   * Returns the average silent reading time for the content.
   * Based on a paper by Marc Brysbaert (2019): https://www.sciencedirect.com/science/article/abs/pii/S0749596X19300786
   * @return the average reading time in minutes
   */
  public function readingTime(): int
  {
    return ceil($this->wordCount() / AVG_WPM);
  }

  public function toFeedItem(): FeedItem
  {
    return FeedItem::create()
      ->id($this->blog_id)
      ->title($this->blog_title)
      ->summary($this->blog_intro)
      ->updated($this->blog_date)
      ->link(route('blog', ['id' => $this->blog_id]))
      ->authorName('JoaoCostaIFG')
      ->authorEmail('joaocosta.work@posteo.net');
  }

  public static function getFeedItems()
  {
    return Blog::allOnlyVisible(true);
  }

  /**
   * Returns a (max) given number of **visible** Blog.
   * Authed users will also get **hidden** Blog.
   */
  public static function some($cnt)
  {
    if (Auth::check()) {
      return Blog::all()->reverse()->take($cnt);
    }
    return Blog::where('blog_visible', true)->orderByDesc('blog_date')->take($cnt)->get();
  }

  public static function allOnlyVisible($onlyVisible = true)
  {
    if ($onlyVisible) {
      return Blog::where('blog_visible', true)->orderByDesc('blog_date')->get();
    }
    return Blog::all()->reverse();
  }

  /**
   * Returns a all **visible** Blog.
   * Authed users will also get the **hidden** Blog.
   */
  public static function allAuth()
  {
    if (Auth::check()) {
      return Blog::allOnlyVisible(false);
    }
    return Blog::allOnlyVisible(true);
  }
}
