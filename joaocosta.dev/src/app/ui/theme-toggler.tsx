"use client"

import clsx from 'clsx';
import { useState, useEffect } from 'react';

function useLocalStorage<T>(key: string, fallbackValue: T) {
  const [value, setValue] = useState(fallbackValue);
  useEffect(() => {
    const stored = localStorage.getItem(key);
    setValue(stored ? JSON.parse(stored) : fallbackValue);
  }, [fallbackValue, key]);

  useEffect(() => {
    localStorage.setItem(key, JSON.stringify(value));
  }, [key, value]);

  return [value, setValue] as const;
}

enum Theme {
  Light = 'light',
  Dark = 'dark'
}

function useTheme() {
  const [theme, setTheme] = useLocalStorage<Theme>('theme', Theme.Dark);
  if (theme === Theme.Dark) {
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
  }
  return [theme, setTheme];
}

export default function ThemeToggler() {
  const [theme, setTheme] = useState(Theme.Dark);
  useEffect(() => {
    if (typeof window !== 'undefined' && window.localStorage) {
      let theme = JSON.parse(localStorage.getItem('theme') || 'dark');
      if (theme === Theme.Dark) {
        document.documentElement.classList.add("dark");
      }
      setTheme(theme);
    }
  }, []);
  const isLight = theme === Theme.Light;

  function handleToggleTheme() {
    const newTheme = isLight ? Theme.Dark : Theme.Light;
    if (typeof window !== 'undefined' && window.localStorage) {
      localStorage.setItem("theme", JSON.stringify(newTheme));
    }
    if (newTheme === Theme.Dark) {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
    setTheme(newTheme);
  }

  const icon = isLight ? "fa-sun" : "fa-moon"
  const ariaLabel = isLight ? "Set dark theme" : "Set light theme";
  return (
    <button id="theme-toggler" onClick={handleToggleTheme} aria-label={ariaLabel} className={clsx(
      "text-xl w-5",
      {
        "text-yellow-200 hover:text-yellow-400": isLight,
        "text-cyan-600 hover:text-cyan-500": !isLight
      }
    )} >
      <i className={`fa-solid ${icon}`}></i>
    </button>
  )
}
