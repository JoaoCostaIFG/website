import { notFound } from "next/navigation"
import { prisma } from '@/lib/prisma';

function countWords(text: string) {
  return text.split(' ')
    .filter(function (n) { return n != '' })
    .length;
}

export default async function Blog({ params }: { params: Promise<{ id: string }> }) {
  const { id: idStr } = await params
  const id = parseInt(idStr, 10)
  if (isNaN(id)) {
    notFound()
  }

  const blog = await prisma.blog.findUnique({
    where: {
      id: id,
    }
  })
  if (!blog) {
    notFound()
  }

  function readingTime() {
    const AVG_WPM = 238
    if (!blog) {
      return 0
    }
    return Math.ceil(countWords(blog.content) / AVG_WPM)
  }

  return (
    <div className="w-full">
      <article className="m-auto relative prose blog line-numbers match-braces">
        <h1 className="mb-0">{blog.title}</h1>
        <em className="block muted mb-4">Avg. {readingTime()} minute(s) of reading</em>

        <div className="p-2 rounded-md bg-zinc-900">
          {blog.intro}
        </div>

        {blog.content}
      </article>
    </div>
  )
}
