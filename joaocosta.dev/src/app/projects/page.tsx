import Link from 'next/link'
import Prisma from '@prisma/client'
import Markdown from 'react-markdown'
import { prisma } from '@/lib/prisma';

function ProjEntry(props: { p: Prisma.Proj }) {
  const { p } = props
  return (
    <article className="relative p-3 rounded-lg max-w-xs flex flex-col text-center bg-zinc-900 hover:bg-gray-900">
      <h2 className="line-clamp-1 mt-0">
        <a href={p.url}>{p.title}</a>
      </h2>

      <div className="bg-contain bg-no-repeat bg-center w-full h-28" title={p.title} style={{ backgroundImage: `url(${p.img})` }}>
      </div>

      <hr className="border-1 w-full my-4 border-foreground-600 dark:border-foreground-500" />
      <div className="prose">
        <Markdown>{p.description}</Markdown>
      </div>
    </article >
  )
}

export default async function Projects() {
  const projs = await prisma.proj.findMany()

  return (
    <div className="relative">
      <h1>Projects</h1>

      <p>
        The following are some projects I've created/worked on that I feel proud of.
      </p>

      <section id="projs-container" className="mt-4 flex flex-row gap-6 flex-wrap justify-center">
        {projs.map((p) => <ProjEntry key={p.id} p={p} />)}
      </section>
    </div>
  )
}
