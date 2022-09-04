export default class MobileMenu {
  controlled: HTMLElement

  constructor(controller: HTMLElement, controlled: HTMLElement) {
    this.controlled = controlled;
    controller.onclick = this.toggle.bind(this);
  }

  toggle() {
    if (this.controlled.classList.contains("hidden")) {
      this.controlled.classList.remove("hidden");
    } else {
      this.controlled.classList.add("hidden");
    }
  }
}
