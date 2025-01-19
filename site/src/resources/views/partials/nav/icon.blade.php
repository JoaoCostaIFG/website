<a @class(array_merge(["text-xl", "w-5", "text-navbar-400", "hover:text-white"], $classes ?? []))
    title="{{ $title }}" href="{{ $href }}" rel="{{ $rel }}">
  <i class="{{ $icon }}"></i>
</a>
