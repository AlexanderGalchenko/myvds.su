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
        group.hidden = group.dataset.planGroup !== type;
      });
    });
  });

  const serviceSelect = document.querySelector("#service-select");
  document.querySelectorAll("[data-plan]").forEach((button) => {
    button.addEventListener("click", () => {
      if (serviceSelect) {
        serviceSelect.value = button.dataset.plan || "";
      }
      document.querySelector("#request")?.scrollIntoView({ behavior: "smooth" });
    });
  });

  const form = document.querySelector("#lead-form");
  const status = document.querySelector("#form-status");
  const submit = form?.querySelector('button[type="submit"]');

  if (!form || !status || !submit || !window.fetch) {
    return;
  }

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    status.className = "form-status";
    status.textContent = "";
    submit.disabled = true;
    submit.textContent = "Отправляем…";

    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: {
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      });
      const payload = await response.json();

      if (!response.ok || !payload.ok) {
        throw new Error(payload.error || "Не удалось отправить заявку.");
      }

      status.className = "form-status success";
      status.textContent = `Заявка №${payload.id} принята. Мы свяжемся с вами по указанному контакту.`;
      form.reset();
      if (serviceSelect) {
        serviceSelect.value = "VDS Work — 1 500 ₽/мес.";
      }
    } catch (error) {
      status.className = "form-status error";
      status.textContent = error instanceof Error
        ? error.message
        : "Не удалось отправить заявку. Позвоните по номеру +7 (926) 000-02-03.";
    } finally {
      submit.disabled = false;
      submit.textContent = "Отправить заявку";
    }
  });
})();
