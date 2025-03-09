export default function Footer() {
  return (
    <footer className="container sticky top-[100vh] mb-4 p-0">
      <hr className="border-1 border-foreground-600 dark:border-foreground-500 my-4 w-full" />
      <p className="muted text-sm">
        Copyright <a className="anchor" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons</a>
        <i className="fa-solid fa-copyright"></i> <b>João Costa</b>
      </p>
    </footer>
  )
}
