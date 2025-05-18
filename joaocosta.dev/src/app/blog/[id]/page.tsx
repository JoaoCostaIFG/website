import { notFound } from "next/navigation"
import Markdown from 'react-markdown'
import { readingTime } from '@/lib/word-utils';
import BlogMarkdown from "@/lib/blog/BlogMarkdown";
import { getPostById, getSortedPostsData } from "@/lib/posts";

export async function generateStaticParams() {
  const posts = getSortedPostsData()

  return posts.map((post) => ({
    id: post.id,
  }))
}

export default async function Blog({ params }: { params: Promise<{ id: string }> }) {
  const { id } = await params

  const b = getPostById(id)
  if (!b) {
    notFound()
  }

  function getReadingTime() {
    return b ? readingTime(b.intro + b.content) : 0
  }

  return (
    <div className="w-full">
      <article className="m-auto relative prose prose-invert blog break-words">
        <h1 className="mb-0">{b.title}</h1>
        <em className="block muted mb-4">Avg. {getReadingTime()} minute(s) of reading</em>

        <div className="p-2 rounded-md bg-zinc-900">
          <Markdown>{b.intro}</Markdown>
        </div>

        <BlogMarkdown markdown={b.content} />
      </article>
    </div>
  )
}
