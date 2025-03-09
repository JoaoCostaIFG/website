"use client"

import Image from 'next/image'
import Link from 'next/link'
import { useState } from 'react'
import { BookOpenIcon, EnvelopeIcon, RssIcon } from '@heroicons/react/16/solid'
import GithunIcon from '@/app/ui/icons/github-icon'
import MobileMenu from '@/app/ui/navbar/mobile-menu';
import NavbarIcon from '@/app/ui/navbar/navbar-icon';
import NavbarLink from '@/app/ui/navbar/navbar-link';


export default function Navbar(props: { selectedTitle: string }) {
  const [isOpen, setIsOpen] = useState(false);
  const { selectedTitle: title } = props;

  function navlinks() {
    return (<>
      <NavbarLink href="/" title='Home' />
      <NavbarLink href='/blogs' title='Blog' />
      <NavbarLink href='/projects' title='Projects' />
      <NavbarLink href='/workshops' title='Workshops' />
      <NavbarLink href='/about' title='About' />
    </>)
  }

  function navicons() {
    return (<>
      <NavbarIcon href="https://wiki.joaocosta.dev" title="My wiki" rel="" >
        <BookOpenIcon />
      </NavbarIcon>
      <NavbarIcon href="https://github.com/JoaoCostaIFG" title="My GitHub profile" rel="me" >
        <GithunIcon />
      </NavbarIcon>
      <NavbarIcon href="mailto:me@joaocosta.dev" title="Email me" rel="me" >
        <EnvelopeIcon />
      </NavbarIcon >
      <NavbarIcon href="/rss" title="My blog's RSS" rel="alternate" >
        <RssIcon />
      </NavbarIcon >
    </>)
  }

  function handleMobileMenu() {
    setIsOpen(!isOpen);
  }

  return (
    <header id="header-container" className="w-full">
      <nav id="navbar" arial-label="primary navigation" className="bg-gray-800">
        <div className="container mx-auto px-2 sm:px-6 lg:px-8">
          <div className="relative flex items-center justify-between h-16">
            <button id="mobile-menu-btn" type="button"
              className="absolute left-0 sm:hidden py-2 px-3 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
              onClick={handleMobileMenu} aria-label="Open navbar menu" aria-controls="mobile-menu" aria-expanded={isOpen}>
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
            </div>
          </div>
        </div>

        <MobileMenu isOpen={isOpen}>
          {navlinks()}
          <div className="flex flex-row justify-around flex-wrap gap-x-4">
            {navicons()}
          </div>
        </MobileMenu>
      </nav>
    </header>
  )
}
