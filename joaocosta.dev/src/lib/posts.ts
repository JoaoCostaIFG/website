import fs from 'fs';
import path from 'path';
import matter from 'gray-matter';

const postsDirectory = path.join(process.cwd(), 'posts');

// Base interface for known frontmatter properties.
// Additional, unknown properties are allowed via the index signature.
interface BaseFrontMatter {
  title: string;
  date: Date;
  [key: string]: unknown; // Allows for any other properties, but their type is unknown
}

// This is the shape of the data after processing and validation.
export interface PostData extends BaseFrontMatter {
  id: string;
  content: string; // All paragraphs except the first
  intro: string;   // The first paragraph
}

// Interface for the raw data parsed by gray-matter before validation/conversion.
// Properties are initially unknown and then validated.
interface RawFrontMatterData {
  title?: unknown;
  date?: unknown;
  [key: string]: unknown; // Catches any other properties from the frontmatter
}

export function getPostById(id: string): PostData | null {
  const fileName: string = `${id}.md`;
  const fullPath: string = path.join(postsDirectory, fileName);
  let fileContents: string;

  if (!fs.existsSync(fullPath)) {
    console.warn(`[getPostById] File not found for post id "${id}": ${fullPath}. Skipping.`);
    return null;
  }

  try {
    fileContents = fs.readFileSync(fullPath, 'utf8');
  } catch (error) {
    console.error(`[getPostById] Error reading file ${fullPath} for post id "${id}": ${(error as Error).message}`);
    return null;
  }

  try {
    const matterResult = matter(fileContents);
    const fullMarkdownContent: string = matterResult.content.trim();

    // Cast the parsed frontmatter data to our RawFrontMatterData interface.
    // gray-matter's `data` property is typically Record<string, any>.
    const rawData = matterResult.data as RawFrontMatterData;

    // Validate title
    if (typeof rawData.title !== 'string' || !rawData.title.trim()) {
      console.warn(`[getPostById] Post with id "${id}" is missing a valid title. Skipping.`);
      return null;
    }
    const title: string = rawData.title;

    // Validate and convert date
    if (rawData.date === undefined || rawData.date === null) {
      console.warn(`[getPostById] Post with id "${id}" is missing a date. Skipping.`);
      return null;
    }

    // new Date() can accept string, number (timestamp), or Date object.
    // We perform an assertion here as we expect a type compatible with new Date().
    const postDate = new Date(rawData.date as string | number | Date);
    if (isNaN(postDate.getTime())) {
      console.warn(`[getPostById] Post with id "${id}" has an invalid date: "${String(rawData.date)}". Skipping.`);
      return null;
    }

    const paragraphs: string[] = fullMarkdownContent.split(/\n\s*\n/);
    const intro: string = paragraphs.length > 0 ? paragraphs[0].trim() : '';
    const remainingContent: string = paragraphs.length > 1 ? paragraphs.slice(1).join('\n\n').trim() : '';

    // Construct the frontmatter object with validated and typed properties.
    // Other properties from rawData are spread in and will have type 'unknown'.
    const processedFrontMatter: BaseFrontMatter = {
      ...rawData, // Spread other properties from rawData (these will be `unknown`)
      title: title,    // Overwrite with validated title (string)
      date: postDate,  // Overwrite with validated and converted Date object
    };

    return {
      id: id,
      content: remainingContent,
      intro: intro,
      ...processedFrontMatter, // Spread the processed frontmatter
    };

  } catch (error) {
    console.error(`[getPostById] Error processing markdown or frontmatter for post "${id}": ${(error as Error).message}`);
    return null;
  }
}

export function getSortedPostsData(): PostData[] {
  if (!fs.existsSync(postsDirectory)) {
    console.error(`[getSortedPostsData] Posts directory not found: ${postsDirectory}`);
    return [];
  }

  let fileNamesInDir: string[];
  try {
    fileNamesInDir = fs.readdirSync(postsDirectory);
  } catch (error) {
    console.error(`[getSortedPostsData] Error reading posts directory ${postsDirectory}: ${(error as Error).message}`);
    return [];
  }

  const mdFileNames = fileNamesInDir.filter(fileName => fileName.endsWith('.md'));

  if (mdFileNames.length === 0) {
    if (fileNamesInDir.length > 0) {
      console.warn(`[getSortedPostsData] No markdown files (.md) found in ${postsDirectory}. Files found: ${fileNamesInDir.join(', ')}`);
    } else {
      console.warn(`[getSortedPostsData] No files found in ${postsDirectory}.`);
    }
  }

  const allPostsData: PostData[] = mdFileNames
    .map((fileName: string) => {
      const id: string = fileName.replace(/\.md$/, '');
      return getPostById(id);
    })
    .filter((post): post is PostData => post !== null); // Type guard to filter out nulls and narrow type

  // Sort posts by date (descending - newest first)
  return allPostsData.sort((a: PostData, b: PostData) => {
    // a.date and b.date are guaranteed to be Date objects by getPostById
    if (a.date < b.date) {
      return 1;
    } else if (a.date > b.date) {
      return -1;
    } else {
      return 0;
    }
  });
}
