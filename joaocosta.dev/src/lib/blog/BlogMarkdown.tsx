import ReactMarkdown from 'react-markdown';
import rangeParser from 'parse-numeric-range';
import { oneDark } from 'react-syntax-highlighter/dist/cjs/styles/prism';
import { PrismLight as SyntaxHighlighter } from 'react-syntax-highlighter';
import tsx from 'react-syntax-highlighter/dist/cjs/languages/prism/tsx';
import typescript from 'react-syntax-highlighter/dist/cjs/languages/prism/typescript';
import bash from 'react-syntax-highlighter/dist/cjs/languages/prism/bash';
import c from 'react-syntax-highlighter/dist/cjs/languages/prism/c';
import cpp from 'react-syntax-highlighter/dist/cjs/languages/prism/cpp';
import python from 'react-syntax-highlighter/dist/cjs/languages/prism/python';
import yaml from 'react-syntax-highlighter/dist/cjs/languages/prism/yaml';
import json from 'react-syntax-highlighter/dist/cjs/languages/prism/json';


SyntaxHighlighter.registerLanguage('tsx', tsx);
SyntaxHighlighter.registerLanguage('typescript', typescript);
SyntaxHighlighter.registerLanguage('bash', bash);
SyntaxHighlighter.registerLanguage('c', c);
SyntaxHighlighter.registerLanguage('cpp', cpp);
SyntaxHighlighter.registerLanguage('python', python);
SyntaxHighlighter.registerLanguage('json', json);
SyntaxHighlighter.registerLanguage('yaml', yaml);

interface CustomCodeProps {
  node?: any;
  inline?: boolean;
  className?: string;
  children: string | string[];
  [key: string]: unknown; // Allow other props
}

export default function BlogMarkdown({ markdown }: { markdown: string }) {
  const syntaxTheme = oneDark;

  const MarkdownComponents: object = {
    code({ node, className, ...props }: CustomCodeProps) {
      const hasLang = /language-(\w+)/.exec(className || '');
      const metaString = node?.data?.meta as string | undefined; // e.g., "{1,3-5}"


      const applyHighlights: object = (applyHighlights: number) => {
        if (metaString) {
          const RE = /{([\d,-]+)}/;
          // Remove all whitespace from metastring and then try to match
          const cleanedMeta = metaString.replace(/\s/g, '');
          const metaMatch = RE.exec(cleanedMeta);
          const strlineNumbers = metaMatch ? metaMatch[1] : '0';
          const highlightLines = rangeParser(strlineNumbers);
          const highlight = highlightLines;
          const data = highlight.includes(applyHighlights)
            ? 'highlight'
            : null;
          return { data };
        } else {
          return {};
        }
      };

      return hasLang ? (
        <SyntaxHighlighter
          style={syntaxTheme}
          language={hasLang[1]}
          PreTag="div"
          className="codeStyle"
          showLineNumbers={true}
          wrapLines={!!metaString}
          useInlineStyles={true}
          lineProps={applyHighlights}
        >
          {props.children}
        </SyntaxHighlighter>
      ) : (
        <code className={className} {...props} />
      )
    },
  }

  return (
    <ReactMarkdown
      components={MarkdownComponents}
    >
      {markdown}
    </ReactMarkdown>
  )
}

