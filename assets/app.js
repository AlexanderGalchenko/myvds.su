(() => {
  "use strict";

  const tabs = [...document.querySelectorAll("[data-plan-type]")];
  const groups = [...document.querySelectorAll("[data-plan-group]")];

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const type = tab.dataset.planType;

      tabs.forEach((item) => {
        const active = item === tab;
        item.classList.toggle("active", active);
        item.setAttribute("aria-selected", active ? "true" : "false");
      });

      groups.forEach((group) => {
        const active = group.dataset.planGroup === type;
        group.hidden = !active;
        group.setAttribute("aria-hidden", active ? "false" : "true");
      });
    });
  });
})();
