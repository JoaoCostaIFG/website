'use client'

import Link from 'next/link'
import clsx from 'clsx'
import { usePathname } from 'next/navigation'

export default function NavbarLink(props: { title: string, href: string }) {
  const { title, href } = props;
  const selected = usePathname() === href;
  return (
    <Link className={clsx(
      "block px-2 py-2 rounded-md text-sm",
      {
        "bg-gray-900 text-white": selected,
        "text-gray-300 hover:bg-gray-700 hover:text-white": !selected,
      })} href={href} > {title}
    </Link >
  )
}
