<article class="relative p-3 rounded-lg max-w-xs flex flex-col text-center bg-background-200 hover:bg-background-300 dark:bg-background-900 hover:dark:bg-gray-900">
  @auth
  <a class="absolute -top-4 -right-4 z-10 icon-btn btn-edit" title="Edit project {{ $p->id }}" href="{{ route('project_edit', ['id' => $p->id]) }}">
    <i class="fa-solid fa-pen-to-square"></i>
  </a>
  @endauth

  <h2 class="line-clamp-1 mt-0">
    <a title="{{ $p->title }}" href="{{ $p->url }}">{{ $p->title }}</a>
  </h2>

  <div class="bg-contain bg-no-repeat bg-center w-full h-28" title="{{ $p->title }}"
      style="background-image: url({{ Storage::url('projects/'.$p->img) }})">
  </div>

  <hr class="border-1 w-full my-4 border-foreground-600 dark:border-foreground-500">
  <div class="prose">
    {!! Parsedown::instance()->line($p->description) !!}
  </div>
</article>
