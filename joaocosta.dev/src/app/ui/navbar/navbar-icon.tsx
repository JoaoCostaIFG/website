export default function NavbarIcon(props: { title: string, href: string, rel: string, children: React.ReactNode }) {
  const { title, href, rel, children } = props;
  return (
    <a className="hidden sm:inline-block text-xl w-5 text-gray-400 hover:text-white" title={title} href={href} rel={rel}>
      {children}
    </a>
  )
}
