@extends('layouts.layout', ['title' => 'About me'])

@section('content')
  <h1>Hello c|:D</h1>

  <div class="prose grid grid-cols-12 gap-4">
    <div class="col-span-12 sm:col-span-8">
      <p>
        I'm a twenty-something year old software engineer. I finished by master's degree
        at <a href="https://fe.up.pt">Faculty of Engineering of the University of Porto</a> in 2023.
        This website started as a place where I could learn more about web development. Now, it
        is somewhere where I try to share a bit of my experiences and thoughts (mostly) relating
        to informatics. There have been multiple iterations of the website over the years, so
        don't get too surprised if you come here one day and everything looks different. The
        website is now hosted on my personal home-server (alongside other self-hosted services I use).
      </p>
      <p>
        I usually write with little to no spell-checking tools, so I'm sure there are lots
        of spelling and grammar errors all over. My partner (who is probably my only reader)
        ends up pointing out most of the errors, so I can fix them. Still, feel free to shoot
        me an email if you thing something not quite right.
      </p>
      <p>
        Professionally, my main foxus has been on several parts of software development for
        embedded systems. I've started by working on tests for DO-178C (an aviation standard)
        certification of an OS (Operating System). Then, I've moved one to tooling,
        packaging, and releases: a sort of internal consulting at the companies where
        I worked. Now, I'm working as a software developer for Linux and baremetal drivers.
      </p>
      <p>
        In my free time, I enjoy working on personal projects, listening to music,
        playing games, and reading. Many of my personal projects revolve around
        customizing my Linux machines, be it the personal ones or the servers
        (<em>I use Arch BTW</em>), or automating stuff.
      </p>
      <p>
        In my work life, I've programmed in <b>Bash/POSIX shell</b>, <b>C</b>, <b>C++</b>,
        <b>JavaScript</b>, <b>Python</b>, and <b>Scala</b>. In my personal projects I mostly
        use <b>Bash/POSIX shell</b>, <b>JavaScript</b>, <b>Python</b>, and <b>PHP</b>. Now
        I'm trying to get more proficient in <b>Rust</b>.
      </p>
      <p>
        I enjoy contributing to open-source software and always try to release mine
        with open licenses (often the MIT license). Generally speaking, I don't like
        social media, so I try to stay as far away from it as possible. Still, I have
        a LinkedIn account for work reasons.
      </p>
      <p>
        The best/fastest way to contact me is through email at:
        <a href="mailto:joaocosta.work@posteo.net">joaocosta.work@posteo.net</a>
        <br>
        You can find my CV <a href="https://github.com/JoaoCostaIFG/cv/blob/master/JoaoCostaCV.pdf">here</a>.
      </p>
    </div>
    <figure class="col-span-12 flex max-w-xs flex-col sm:order-first sm:col-span-4 sm:max-w-full">
      <img class="inline self-center" src="{{ Vite::asset('resources/images/pfp.jpg') }}" alt="Me">
      <figcaption class="text-center">
        (This is the profile picture I usually use online. It was generated using
        my <a href="https://gitlab.com/JoaoCostaIFG/allrgb">AllRGB program</a>.)
      </figcaption>
    </figure>
  </div>
@endsection
