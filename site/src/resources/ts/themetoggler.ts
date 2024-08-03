export default class ThemeToggler {
  btn: HTMLElement

  constructor(btn: HTMLElement) {
    this.btn = btn
    this.btn.onclick = this.toggle.bind(this)

    // placed inline on head to avoid FOUC
    this.initTheme();
  }

  setDarkTheme() {
    document.documentElement.classList.remove('light');
    // document.documentElement.classList.add('dark');
    localStorage.theme = 'dark';

    this.btn.setAttribute('aria-label', "Set light theme")
    this.btn.classList.remove("text-yellow-200", "hover:text-yellow-400")
    this.btn.classList.add("text-cyan-600", "hover:text-cyan-500")
    this.btn.innerHTML = '<i class="fa-solid fa-moon"></i>';
  }

  setLightTheme() {
    document.documentElement.classList.add('light');
    // document.documentElement.classList.remove('dark');
    localStorage.theme = 'light';

    this.btn.setAttribute('aria-label', "Set dark theme");
    this.btn.classList.remove("text-cyan-600", "hover:text-cyan-500")
    this.btn.classList.add("text-yellow-200", "hover:text-yellow-400")
    this.btn.innerHTML = '<i class="fa-solid fa-sun"></i>';
  }

  toggle() {
    if (localStorage.theme === "dark") {
      this.setLightTheme();
    } else {
      this.setDarkTheme();
    }
  }

  // call on page load and when changing themes (defaults to dark theme)
  initTheme() {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      this.setDarkTheme();
    } else {
      this.setLightTheme();
    }
  }
}
