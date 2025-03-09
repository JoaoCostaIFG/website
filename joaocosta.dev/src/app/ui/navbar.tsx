import Image from 'next/image'
import Link from 'next/link'
import ThemeToggler from '@/app/ui/theme-toggler'

function NavbarLink(props: { title: string, href: string, selected: boolean }) {
  const { title, href, selected } = props;
  const classes = selected ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white";
  return <Link className={`${classes} block px-2 py-2 rounded-md text-sm`} href={href}>{title}</Link>
}

function NavbarIcon(props: { title: string, href: string, classes: string, icon: string, rel: string }) {
  const { title, href, classes, icon, rel } = props;
  return (
    <a className={`${classes} text-xl w-5 text-gray-400 hover:text-white`} title={title} href={href} rel={rel}>
      <i className={icon}></i>
    </a>
  )
}

export default function Navbar(props: { selectedTitle: string }) {
  const { selectedTitle: title } = props;

  function navlinks() {
    return (<>
      <NavbarLink href="/" title='Home' selected={'Home' === title} />
      <NavbarLink href='/blogs' title='Blog' selected={'Blog' === title} />
      <NavbarLink href='/projects' title='Projects' selected={'Projects' === title} />
      <NavbarLink href='/workshops' title='Workshops' selected={'Workshops' === title} />
      <NavbarLink href='/about' title='About/Contacts' selected={'About me' === title} />
    </>)
  }

  function navicons() {
    return (<>
      <NavbarIcon href="https://wiki.joaocosta.dev" title="My wiki" icon="fa-solid fa-file-pen" classes="hidden sm:inline-block" rel="" />
      <NavbarIcon href="https://github.com/JoaoCostaIFG" title="My GitHub profile" icon="fa-brands fa-github" classes="hidden sm:inline-block" rel="me" />
      <NavbarIcon href="mailto:me@joaocosta.dev" title="Email me" icon="fa-solid fa-envelope" classes="hidden sm:inline-block" rel="me" />
      <NavbarIcon href="/rss" title="My blog's RSS" icon="fa-solid fa-square-rss" classes="hidden sm:inline-block" rel="alternate" />
    </>)
  }

  return (
    <header id="header-container" className="w-full">
      <nav id="navbar" arial-label="primary navigation" className="bg-gray-800">
        <div className="container mx-auto px-2 sm:px-6 lg:px-8">
          <div className="relative flex items-center justify-between h-16">
            <button id="mobile-menu-btn" type="button" className="absolute left-0 sm:hidden py-2 px-3 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-white" aria-label="Open navbar menu" aria-controls="mobile-menu" aria-expanded="false">
              <i className="fa-solid fa-bars"></i>
            </button>

            <div className="flex flex-1 justify-center sm:justify-start">
              <Link className="shrink-0" title="Go home" href="/">
                <Image id="brand" className="shrink-0 h-8 w-auto" src="/irao.png" width={276} height={286} alt="My icon" />
              </Link>
              <div className="hidden sm:block sm:ml-2">
                <div className="flex gap-x-2">
                  {navlinks()}
                </div>
              </div>
            </div>

            <div className="absolute inset-y-0 right-0 mr-4 sm:mr-0 flex items-center gap-x-4">
              {navicons()}
              <ThemeToggler />
            </div>
          </div>
        </div>

        <div id="mobile-menu" className="hidden sm:hidden px-2 pb-2 flex flex-col gap-y-1">
          {navlinks()}
          <div className="flex flex-row justify-around flex-wrap gap-x-4">
            {navicons()}
          </div>
        </div>
      </nav>
    </header>
  )
}
