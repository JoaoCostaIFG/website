import ReactMarkdown from 'react-markdown';
import rangeParser from 'parse-numeric-range';
import { oneDark } from 'react-syntax-highlighter/dist/esm/styles/prism';
import { PrismLight as SyntaxHighlighter } from 'react-syntax-highlighter';
import tsx from 'react-syntax-highlighter/dist/esm/languages/prism/tsx';
import typescript from 'react-syntax-highlighter/dist/esm/languages/prism/typescript';
import bash from 'react-syntax-highlighter/dist/esm/languages/prism/bash';
import c from 'react-syntax-highlighter/dist/esm/languages/prism/c';
import cpp from 'react-syntax-highlighter/dist/esm/languages/prism/cpp';
import python from 'react-syntax-highlighter/dist/esm/languages/prism/python';
import yaml from 'react-syntax-highlighter/dist/esm/languages/prism/yaml';
import json from 'react-syntax-highlighter/dist/esm/languages/prism/json';

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
    code({ node, inline, className, children }: CustomCodeProps) {
      const hasLang = /language-(\w+)/.exec(className || '');
      const metaString = node?.data?.meta as string | undefined; // e.g., "{1,3-5}"

      let language = hasLang ? hasLang[1].toLowerCase() : '';
      // map langs that have no builtin renderer
      if (language === 'sh' || language === 'shell' || language === 'fish') {
        language = 'bash';
      }

      const applyHighlights: object = (applyHighlights: number) => {
        if (metaString) {
          const RE = /{([\d,-]+)}/;
          // Remove all whitespace from metastring and then try to match
          const cleanedMeta = metaString.replace(/\s/g, '');
          const metaMatch = RE.exec(cleanedMeta);
          const strlineNumbers = metaMatch ? metaMatch[1] : '0';
          const highlightLines = rangeParser(strlineNumbers);
          const highlight = highlightLines;
          if (highlight.includes(applyHighlights)) {
            return { 'highlight': true };
          }
        }
        return {};
      };

      // Convert children to string and remove a potential trailing newline
      const codeString = String(children).replace(/\n$/, '');

      if (inline) {
        // Handle inline code (e.g., `code`)
        return <code className={className}>{children}</code>;
      }

      return hasLang ? (
        <SyntaxHighlighter
          style={syntaxTheme}
          language={language}
          PreTag="div"
          className={className}
          showLineNumbers={true}
          wrapLines={!!metaString} // Only wrap lines if metaString (for highlighting) is present
          useInlineStyles={true}
          lineProps={applyHighlights}
        >
          {codeString}
        </SyntaxHighlighter>
      ) : (
        <code className={className}>
          {codeString}
        </code>
      );
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

