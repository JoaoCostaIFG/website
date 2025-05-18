import { getSortedPostsData } from '@/lib/posts';
import RSS from 'rss';

function generateRssFeed(): RSS {
  const site_url = 'https://joaocosta.dev'
  const date = new Date()

  const feedOptions = {
    title: "JoaoCostaIFG's Blog",
    description: 'Blog posts from joaocosta.dev',
    site_url: site_url,
    feed_url: `${site_url}/rss`,
    image_url: `${site_url}/irao.png`,
    pubDate: date,
    copyright: `All rights reserved ${date.getFullYear()}`,
  }
  const feed = new RSS(feedOptions)

  const posts = getSortedPostsData()
  posts.map((post) => {
    feed.item({
      title: post.title,
      description: post.intro,
      url: `${site_url}/blog/${post.id}`,
      date: post.date,
    })
  })

  return feed
}

export async function GET() {
  const feed = generateRssFeed()
  return new Response(feed.xml(), { headers: { "Content-Type": "text/xml" } });
}
