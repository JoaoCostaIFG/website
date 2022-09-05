import "./bootstrap";

import "../css/style.css";
import "../css/fontawesome.css";
import "../css/print.css";
import.meta.glob(["../images/**"]);

import ThemeToggler from "../ts/themetoggler";

new ThemeToggler(document.getElementById("theme-toggler"));

const mobileMenu = document.getElementById("mobile-menu");
Livewire.on("toggleMobileMenu", function () {
  if (mobileMenu.classList.contains("hidden")) {
    mobileMenu.classList.remove("hidden");
  } else {
    mobileMenu.classList.add("hidden");
  }
});
