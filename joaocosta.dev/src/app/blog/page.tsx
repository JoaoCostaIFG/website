import Link from 'next/link'
import { getSortedPostsData, PostData } from '@/lib/posts';

function BlogPageEntry(props: { b: PostData }) {
  const { b } = props
  return (
    <Link className="p-2 rounded-md bg-zinc-900 text-gray-200 hover:bg-gray-900 hover:ring-2 hover:ring-teal-600" href={`blog/${encodeURIComponent(b.id)}`}>
      <span className="font-semibold">{b.title}</span>
      <br />
      <span className="line-clamp-1 lg:line-clamp-2 ml-2 text-gray-400">
        {b.intro}
      </span>
      <span className="muted">{b.date.toDateString()}</span>
    </Link>
  )
}

export default async function Blogs() {
  const blogs = getSortedPostsData()
  return (
    <div className="relative max-w-prose m-auto">
      <h1>All of my blog posts</h1>

      <div className="grid grid-cols-1 gap-y-4">
        {blogs.map((b) => <BlogPageEntry key={b.id} b={b} />)}
      </div>
    </div>
  )
}
