import Image from "next/image";
import Link from 'next/link'

function HomeEntry() {
  const title = "A blog title"
  const visible = true
  const date = "2021-09-01"
  return (
    <a className="max-w-xl p-2 rounded-md ring-inset
      bg-zinc-900 text-gray-200 hover:bg-gray-900
      hover:ring-2 hover:ring-teal-600"
      href="{{ route('blog', ['b' => $b]) }}">
      <span className="font-semibold">
        {title}
        {visible ? '' : <span className="text-red-400"> (hidden)</span>}
      </span>
      <br />
      <span className="muted">{date}</span>
    </a>
  )
}

export default function Home() {
  return (
    <>
      <h1>Welcome to my corner of the Internet!</h1>

      <div className="grid grid-cols-12 gap-x-4 gap-y-4">
        <section className="col-span-12 md:col-span-7">
          <h2>Recent posts</h2>
          <div className="mb-4 grid grid-cols-1 gap-y-1">
            <HomeEntry />
            <HomeEntry />
            <HomeEntry />
          </div>
          <div className="max-w-xl text-right">
            <Link className="btn btn-teal" href="/blogs">
              Older posts
            </Link>
          </div>
        </section>

        <section className="col-span-12 md:col-span-5">
          <h2>About</h2>
          <p className="mb-4">
            Hey! My name is João Costa and this is my personal corner of the internet.
            I'm interested in computer science and electronics, and I enjoy implementing my own solutions to
            problems/needs.
            This page's main focus is for me to share some ideas/processes behind projects that I've worked on.
          </p>
          <div className="text-right">
            <a className="btn btn-teal" href="/about">
              More About Me
            </a>
          </div>
        </section>

        <section className="col-span-12">
          <h2><a href="https://wiki.joaocosta.dev">Wiki</a></h2>
          <p>
            I manage a small <a className="anchor" href="https://wiki.joaocosta.dev">wiki</a> where I post small "cookbooks",
            "cheat-sheets" and other general guides/annotations. It's basically part of my notes that I decided to make public.
          </p>
        </section>

        <section className="col-span-12">
          <h2>My friends</h2>
          This is a list of my friends' websites. Pay them a visit sometime.
          <ul className="list-disc">
            <li><a href="https://educorreia932.dev">educorreia932</a></li>
            <li><a href="https://marceloborges.dev">jmarcelomb</a></li>
          </ul>
        </section>
      </div>
    </>
  );
}
