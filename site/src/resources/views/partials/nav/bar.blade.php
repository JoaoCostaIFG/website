  <header id="header-container" class="w-full">
    <nav id="navbar" arial-label="primary navigation" class="bg-navbar-800">
      <!-- navbar contents -->
      <div class="container mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
          <!-- Mobile menu button-->
          <button id="mobile-menu-btn" type="button" class="absolute left-0 sm:hidden py-2 px-3 rounded-md text-navbar-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-white" aria-label="Open navbar menu" aria-controls="mobile-menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
          </button>

          <div class="flex flex-1 justify-center sm:justify-start">
            <a class="shrink-0" title="Go home" href="{{ route('home') }}">
              <img id="brand" class="aspect-square shrink-0 h-8 w-auto" src="{{ Vite::asset('resources/images/irao.png') }}" alt="My icon">
            </a>
            <div class="hidden sm:block sm:ml-2">
              <div class="flex gap-x-2">
                @include('partials.nav.link', ['href' => route('home'), 'title' => 'Home', 'selected' => 'Home' === $title])
                @include('partials.nav.link', ['href' => route('blogs'), 'title' => 'Blog', 'selected' => 'Blog' === $title])
                @include('partials.nav.link', ['href' => route('projects'), 'title' => 'Projects', 'selected' => 'Projects' === $title])
                @include('partials.nav.link', ['href' => route('workshops'), 'title' => 'Workshops', 'selected' => 'Workshops' === $title])
                @include('partials.nav.link', ['href' => route('about'), 'title' => 'About/Contacts', 'selected' => 'About me' === $title])
              </div>
            </div>
          </div>

          <div class="absolute inset-y-0 right-0 mr-4 sm:mr-0 flex items-center gap-x-4">
            @include('partials.nav.icon', ['href' => 'https://wiki.joaocosta.dev', 'title' => 'My wiki', 'icon' => 'fa-solid fa-file-pen', 'classes' => ['hidden', 'sm:inline-block'], 'rel' => ''])
            @include('partials.nav.icon', ['href' => 'https://github.com/JoaoCostaIFG', 'title' => 'My GitHub page', 'icon' => 'fa-brands fa-github', 'classes' => ['hidden', 'sm:inline-block'], 'rel' => 'me'])
            @include('partials.nav.icon', ['href' => 'mailto:me@joaocosta.dev', 'title' => 'Email me', 'icon' => 'fa-solid fa-envelope', 'classes' => ['hidden', 'sm:inline-block'], 'rel' => 'me'])
            @include('partials.nav.icon', ['href' => route('feeds.rss'), 'title' => "My blog's RSS", 'icon' => 'fa-solid fa-square-rss', 'classes' => ['hidden', 'sm:inline-block'], 'rel' => 'alternate'])
            @if (Auth::check())
            <a class="text-xl w-5 text-red-200 hover:text-red-400" title="logout" href="{{ route('logout') }}">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
            {{--
            @else
            <a class="text-xl w-5 text-green-200 hover:text-green-400" title="login" href="{{ route('login') }}">
              <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </a>
            --}}
            @endif
            <button id="theme-toggler" class="text-xl w-5 text-yellow-200 hover:text-yellow-400" aria-label="Set light theme">
              <i class="fa-solid fa-sun"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- mobile menu (show/hide based on menu state) -->
      <div id="mobile-menu" class="hidden sm:hidden px-2 pb-2 flex flex-col gap-y-1">
        @include('partials.nav.link', ['href' => route('home'), 'title' => '<i class="fa-solid fa-house w-6"></i> Home', 'selected' => 'Home' === $title])
        @include('partials.nav.link', ['href' => route('blogs'), 'title' => '<i class="fa-solid fa-blog w-6"></i> Blog', 'selected' => 'Blog' === $title])
        @include('partials.nav.link', ['href' => route('projects'), 'title' => '<i class="fa-solid fa-lightbulb w-6"></i> Projects', 'selected' => 'Projects' === $title])
        @include('partials.nav.link', ['href' => route('workshops'), 'title' => '<i class="fa-solid fa-chalkboard-user w-6"></i> Workshops', 'selected' => 'Workshops' === $title])
        @include('partials.nav.link', ['href' => route('about'), 'title' => '<i class="fa-solid fa-address-card w-6"></i> About/Contacts', 'selected' => 'About me' === $title])
        <div class="flex flex-row justify-around flex-wrap gap-x-4">
          @include('partials.nav.icon', ['href' => 'https://wiki.joaocosta.dev', 'title' => 'My wiki', 'icon' => 'fa-solid fa-file-pen', 'rel' => ''])
          @include('partials.nav.icon', ['href' => 'https://github.com/JoaoCostaIFG', 'title' => 'My GitHub page', 'icon' => 'fa-brands fa-github', 'rel' => 'me'])
          @include('partials.nav.icon', ['href' => 'mailto:me@joaocosta.dev', 'title' => 'Email me', 'icon' => 'fa-solid fa-envelope', 'rel' => 'me'])
          @include('partials.nav.icon', ['href' => route('feeds.rss'), 'title' => "My blog's RSS", 'icon' => 'fa-solid fa-square-rss', 'rel' => 'alternate'])
        </div>
      </div>
    </nav>
  </header>
