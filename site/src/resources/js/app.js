import "../css/style.css";
import "../css/fontawesome.css";
import "../css/print.css";

import "./bootstrap";

import.meta.glob(["../images/**"]);

import MobileMenu from "../ts/mobilemenu";
import ThemeToggler from "../ts/themetoggler";

new MobileMenu(
  document.getElementById("mobile-menu-btn"),
  document.getElementById("mobile-menu")
);

new ThemeToggler(document.getElementById("theme-toggler"))
