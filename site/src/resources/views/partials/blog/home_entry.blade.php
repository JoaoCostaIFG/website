<a class="max-w-xl p-2 rounded-md ring-inset
      bg-background-200 text-foreground-800 dark:bg-background-900 dark:text-foreground-200
      hover:bg-gray-300 dark:hover:bg-gray-900
      hover:ring-2 hover:ring-primary-500 dark:hover:ring-primary-600"
    href="{{ route('blog_post', ['id' => $b['blog_id']]) }}">
  <span class="font-semibold">
    {{ $b['blog_title'] }}
    @auth @if(!$b['blog_visible'])
      <span class="text-red-600 dark:text-red-400"> (hidden)</span>
    @endif @endauth
  </span>
  <br>
  <span class="muted">{{ $b->getDateStr() }}</span>
</a>
