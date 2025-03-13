import { notFound } from "next/navigation"
import Markdown from 'react-markdown'
import { prisma } from '@/lib/prisma';
import { countWords } from '@/lib/word-utils';
import BlogMarkdown from "@/lib/blog/BlogMarkdown";


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
    const totalWords = countWords(blog.intro) + countWords(blog.content)
    return Math.ceil(totalWords / AVG_WPM)
  }

  return (
    <div className="w-full">
      <article className="m-auto relative prose prose-invert blog break-words">
        <h1 className="mb-0">{blog.title}</h1>
        <em className="block muted mb-4">Avg. {readingTime()} minute(s) of reading</em>

        <div className="p-2 rounded-md bg-zinc-900">
          <Markdown>{blog.intro}</Markdown>
        </div>

        <BlogMarkdown markdown={blog.content} />
      </article>
    </div>
  )
}
