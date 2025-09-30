# joaocosta.dev Blog

This is the source code for my personal blog,
[joaocosta.dev](https://joaocosta.dev). It's a statically generated site built
with Next.js and styled with Tailwind CSS.

## Content Management

Blog posts are written and managed in Joplin. A GitHub Action runs periodically
to pull the latest content from Joplin and commit it to this repository.

## Tech Stack

- [Next.js](https://nextjs.org/) - Framework.
- [TypeScript](https://www.typescriptlang.org/) - Lang.
- [Tailwind CSS](https://tailwindcss.com/) - Styling framework.
- [gray-matter](https://github.com/jonschlinkert/gray-matter) - For parsing
  front-matter from markdown files.
- [react-markdown](https://github.com/remarkjs/react-markdown) - For rendering
  Markdown files.

## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

- [pnpm](https://pnpm.io/installation)

### Installation

1. Clone the repo:

   ```sh
   git clone https://github.com/JoaoCostaIFG/website.git
   ```

2. Install dependencies:

   ```sh
   pnpm install
   ```

### Running the Development Server

To view the site in development mode, run:

```bash
pnpm dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the
result.

## Building the Project

To build the site for production, run:

```bash
pnpm build
```

This will create a static, production-ready build in the `.next` directory.

## Docker

Deployments are made using docker. There's a action building the docker image
for this site.
