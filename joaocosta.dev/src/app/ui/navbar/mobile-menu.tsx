import clsx from 'clsx';

export default function MobileMenu({
  isOpen,
  children,
}: Readonly<{
  isOpen: boolean;
  children: React.ReactNode;
}>) {
  return (
    <div id="mobile-menu" className={clsx(
      "sm:hidden px-2 pb-2 flex flex-col gap-y-1",
      {
        "hidden": !isOpen,
      }
    )}>
      {children}
    </div>
  )
}
