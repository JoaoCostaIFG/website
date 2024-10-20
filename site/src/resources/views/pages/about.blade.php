@extends('layouts.layout', ['title' => 'About me'])

@section('content')
  <h1>Hello c|:D</h1>

  <div class="prose grid grid-cols-12 gap-4">
    <div class="col-span-12 sm:col-span-8">
      <p>
        I'm a twenty-something year old computer/informatics engineer. I finished by master's degree
        at <a href="https://fe.up.pt">Faculty of Engineering of the University of Porto</a> in 2023. I started this website
        so I could learn more about web development and have
        a place to share my experiences/thoughts (mostly) relating to informatics. This
        website passed through multiple changes and is now hosted on my personal home-server
        (alongside other self-hosted services I use).
      </p>
      <p>
        As part of both my academic, work, and personal experience, I've had the
        opportunity to deal with numerous programming languages. As of writing, my
        favorites are: <b>Bash/POSIX shell</b>, <b>C</b>, <b>C++</b>, <b>Java</b>,
        <b>Python3</b>, <b>Typescript</b>, <b>PHP</b> and <b>Zig</b>.
      </p>
      <p>
        In my free time, I enjoy working on personal projects, listening to music,
        playing games, and reading. Many of my personal projects revolve around
        customizing my Linux machines, be it the personal ones or the servers
        (<em>I use Arch BTW</em>).
      </p>
      <p>
        I enjoy contributing to open-source software and always try to release mine
        with open licenses (often the MIT license). Generally speaking, I don't like
        social media, so I try to stay as far away from it as possible. This isn't
        always possible/feasible (e.g. LinkedIn).
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
