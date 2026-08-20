<?php
declare(strict_types=1);

session_start();

if (empty($_SESSION['myvds_csrf'])) {
    $_SESSION['myvds_csrf'] = bin2hex(random_bytes(32));
}

$csrf = (string) $_SESSION['myvds_csrf'];
$sent = isset($_GET['sent']) && $_GET['sent'] === '1';
$failed = isset($_GET['error']) && $_GET['error'] === '1';
$leadId = isset($_GET['id']) ? preg_replace('/[^a-zA-Z0-9-]/', '', (string) $_GET['id']) : '';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VDS и GPU-серверы — myvds.su</title>
  <meta name="description" content="Промо-конфигурации VDS, GPU и выделенных серверов с размещением в РФ.">
  <meta name="theme-color" content="#06101c">
  <link rel="icon" href="/assets/mark.svg" type="image/svg+xml">
  <link rel="stylesheet" href="/assets/style.css?v=20260819">
  <script src="/assets/app.js?v=20260819" defer></script>
</head>
<body>
  <div class="site-shell">
    <a class="skip-link" href="#main">К содержанию</a>

    <header class="topbar">
      <a class="brand" href="#top" aria-label="myvds.su — на главную">
        <img src="/assets/mark.svg" alt="" width="52" height="52">
        <span><strong>myvds.su</strong><small>VDS / GPU</small></span>
      </a>
      <nav class="nav" aria-label="Основная навигация">
        <a href="#plans">Тарифы</a>
        <a href="#advantages">Возможности</a>
        <a href="#request">Заявка</a>
        <a class="nav-login" href="https://lk.ikubit.ru" target="_blank" rel="noreferrer">Личный кабинет ↗</a>
      </nav>
    </header>

    <?php if ($sent): ?>
      <div class="server-message" role="status">Заявка <?= $leadId !== '' ? '№' . htmlspecialchars($leadId, ENT_QUOTES, 'UTF-8') . ' ' : '' ?>принята.</div>
    <?php elseif ($failed): ?>
      <div class="server-message error" role="alert">Заявка не сохранилась. Позвоните по номеру +7 (926) 000-02-03.</div>
    <?php endif; ?>

    <main id="main">
      <section class="hero" id="top">
        <div class="hero-pattern" aria-hidden="true"></div>
        <div class="hero-copy">
          <div class="eyebrow"><span></span> Промо-витрина серверов</div>
          <h1>VDS и GPU<br>без лишнего слоя</h1>
          <p>Выберите готовую конфигурацию для сайта, 1С, базы данных, AI/ML или тестового стенда. Российская инфраструктура, выделенный IPv4 и понятный путь от тарифа до запуска.</p>
          <div class="hero-actions">
            <a class="button primary" href="#plans">Выбрать сервер</a>
            <a class="button secondary" href="#request">Обсудить задачу</a>
          </div>
          <div class="hero-note"><span class="signal"></span> Приём заявок круглосуточно</div>
        </div>

        <aside class="promo-card" aria-label="Условия акции">
          <div class="promo-top"><span>Промокод</span><strong>СКИДОЧКА</strong></div>
          <div class="promo-value">−25%</div>
          <p>на VDS дороже 500 ₽</p>
          <dl>
            <div><dt>Срок</dt><dd>до 31.12.2027</dd></div>
            <div><dt>Размещение</dt><dd>Россия</dd></div>
            <div><dt>Подключение</dt><dd>после согласования</dd></div>
          </dl>
        </aside>
      </section>

      <section class="metrics" aria-label="Ключевые преимущества">
        <div><strong>200 Мбит/с</strong><span>порт безлимит</span></div>
        <div><strong>1 IPv4</strong><span>входит в VDS</span></div>
        <div><strong>NVMe</strong><span>быстрые диски</span></div>
        <div><strong>Backup</strong><span>резервные копии</span></div>
      </section>

      <section class="section plans-section" id="plans">
        <div class="section-heading">
          <div>
            <div class="eyebrow"><span></span> Конфигурации</div>
            <h2>Сервер под задачу, а не наоборот</h2>
          </div>
          <div class="plan-tabs" role="tablist" aria-label="Тип сервера">
            <button type="button" role="tab" aria-selected="true" class="active" data-plan-type="VDS">VDS / VPS</button>
            <button type="button" role="tab" aria-selected="false" data-plan-type="GPU">GPU VDS</button>
          </div>
        </div>

        <div class="plan-grid plan-group" data-plan-group="VDS">
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">VDS</span><span class="plan-badge">Старт</span></div>
            <h3>VDS Start</h3>
            <div class="price"><strong>350 ₽</strong><span>/ месяц</span></div>
            <ul><li>1 vCPU</li><li>1 ГБ RAM</li><li>32 ГБ NVMe</li><li>100 Мбит/с + IPv4</li></ul>
            <p>Мониторинг, небольшой сайт, VPN или тестовый сервер.</p>
            <button type="button" class="plan-action" data-plan="VDS Start — 350 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">VDS</span><span class="plan-badge">Популярный</span></div>
            <h3>VDS Work</h3>
            <div class="price"><del>2 000 ₽</del><strong>1 500 ₽</strong><span>/ месяц</span></div>
            <ul><li>2 vCPU</li><li>4 ГБ RAM</li><li>64 ГБ NVMe</li><li>200 Мбит/с + IPv4</li></ul>
            <p>Интернет-магазин, backend API, 1С-Битрикс или MySQL.</p>
            <button type="button" class="plan-action" data-plan="VDS Work — 1 500 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">VDS</span></div>
            <h3>VDS Pro</h3>
            <div class="price"><del>5 000 ₽</del><strong>3 750 ₽</strong><span>/ месяц</span></div>
            <ul><li>8 vCPU</li><li>16 ГБ RAM</li><li>256 ГБ NVMe</li><li>200 Мбит/с + IPv4</li></ul>
            <p>Highload backend, виртуальная АТС, биллинг или базы данных.</p>
            <button type="button" class="plan-action" data-plan="VDS Pro — 3 750 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">VDS</span></div>
            <h3>VDS Max</h3>
            <div class="price"><del>20 000 ₽</del><strong>15 000 ₽</strong><span>/ месяц</span></div>
            <ul><li>16 vCPU</li><li>64 ГБ RAM</li><li>1 ТБ NVMe</li><li>200 Мбит/с + IPv4</li></ul>
            <p>Kubernetes, крупные базы, аналитика и тяжёлые сервисы.</p>
            <button type="button" class="plan-action" data-plan="VDS Max — 15 000 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
        </div>

        <div class="plan-grid plan-group" data-plan-group="GPU" hidden>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">GPU</span><span class="plan-badge">GPU</span></div>
            <h3>RTX A5000</h3>
            <div class="price"><strong>20 000 ₽</strong><span>/ месяц</span></div>
            <ul><li>24 ГБ ECC</li><li>16 vCPU</li><li>128 ГБ RAM</li><li>512 ГБ NVMe</li></ul>
            <p>Инференс, YOLO, CV/NLP, AI-боты и тестовые ML-стенды.</p>
            <button type="button" class="plan-action" data-plan="RTX A5000 — 20 000 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">GPU</span><span class="plan-badge">Популярный</span></div>
            <h3>RTX 4090</h3>
            <div class="price"><strong>25 000 ₽</strong><span>/ месяц</span></div>
            <ul><li>24 ГБ VRAM</li><li>16 vCPU</li><li>128 ГБ RAM</li><li>512 ГБ NVMe</li></ul>
            <p>ComfyUI, Stable Diffusion, обучение и быстрый инференс.</p>
            <button type="button" class="plan-action" data-plan="RTX 4090 — 25 000 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">GPU</span></div>
            <h3>RTX 4090 48 GB</h3>
            <div class="price"><strong>30 000 ₽</strong><span>/ месяц</span></div>
            <ul><li>48 ГБ VRAM</li><li>16 vCPU</li><li>128 ГБ RAM</li><li>512 ГБ NVMe</li></ul>
            <p>LLM-инференс, fine-tuning и задачи с повышенным объёмом VRAM.</p>
            <button type="button" class="plan-action" data-plan="RTX 4090 48 GB — 30 000 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
          <article class="plan-card">
            <div class="plan-card-head"><span class="plan-index">GPU</span><span class="plan-badge">Новый</span></div>
            <h3>RTX 5090</h3>
            <div class="price"><strong>35 000 ₽</strong><span>/ месяц</span></div>
            <ul><li>32 ГБ VRAM</li><li>16 vCPU</li><li>128 ГБ RAM</li><li>512 ГБ NVMe</li></ul>
            <p>LLM 30B+, AI-сервисы, генерация изображений и CUDA-задачи.</p>
            <button type="button" class="plan-action" data-plan="RTX 5090 — 35 000 ₽/мес.">Выбрать конфигурацию <span>→</span></button>
          </article>
        </div>

        <p class="plans-footnote">Нужны другие CPU, RAM, диск, трафик или несколько GPU? Оставьте параметры в заявке — соберём индивидуальную конфигурацию.</p>
      </section>

      <section class="section advantages" id="advantages">
        <div class="advantages-intro">
          <div class="eyebrow"><span></span> Инфраструктура</div>
          <h2>Надёжная база для рабочих сервисов</h2>
          <p>От небольшого VDS до GPU-узла и физического сервера — без переезда между случайными площадками по мере роста проекта.</p>
        </div>
        <div class="advantage-grid">
          <article><span>01</span><h3>Ресурсы без оверселла</h3><p>Конфигурация фиксируется на весь срок аренды, параметры понятны до запуска.</p></article>
          <article><span>02</span><h3>Данные в РФ</h3><p>Серверы размещаются на российской инфраструктуре с контролируемым доступом.</p></article>
          <article><span>03</span><h3>От VDS до bare-metal</h3><p>Можно начать с виртуальной машины и перейти на GPU или выделенный сервер.</p></article>
          <article><span>04</span><h3>Инженерная эксплуатация</h3><p>Питание, охлаждение, наблюдение и техническая поддержка работают круглосуточно.</p></article>
        </div>
      </section>

      <section class="section request-section" id="request">
        <div class="request-copy">
          <div class="eyebrow"><span></span> Заявка</div>
          <h2>Расскажите, что нужно запустить</h2>
          <p>Ответим по конфигурации и сроку подключения. Если готовый тариф избыточен — предложим меньше. Если не хватает ресурсов — сразу посчитаем индивидуальный вариант.</p>
          <div class="direct-contact">
            <span>Можно связаться напрямую</span>
            <a href="tel:+79260000203">+7 (926) 000-02-03</a>
            <a href="mailto:ag@nxss.ru">ag@nxss.ru</a>
          </div>
        </div>

        <form class="lead-form" id="lead-form" action="/send.php" method="post" accept-charset="UTF-8">
          <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
          <div class="field-row">
            <label><span>Ваше имя</span><input name="name" autocomplete="name" minlength="2" maxlength="120" required placeholder="Александр"></label>
            <label><span>Телефон или email</span><input name="contact" autocomplete="email" minlength="3" maxlength="160" required placeholder="+7 900 000-00-00"></label>
          </div>
          <label>
            <span>Конфигурация</span>
            <select name="service" id="service-select">
              <option>VDS Start — 350 ₽/мес.</option>
              <option selected>VDS Work — 1 500 ₽/мес.</option>
              <option>VDS Pro — 3 750 ₽/мес.</option>
              <option>VDS Max — 15 000 ₽/мес.</option>
              <option>RTX A5000 — 20 000 ₽/мес.</option>
              <option>RTX 4090 — 25 000 ₽/мес.</option>
              <option>RTX 4090 48 GB — 30 000 ₽/мес.</option>
              <option>RTX 5090 — 35 000 ₽/мес.</option>
              <option>Выделенный сервер — индивидуально</option>
              <option>Другая задача — нужна консультация</option>
            </select>
          </label>
          <label><span>Задача или дополнительные параметры</span><textarea name="message" maxlength="2000" rows="5" placeholder="Например: 1С на 20 пользователей, нужна ежедневная резервная копия…"></textarea></label>
          <label class="honeypot" aria-hidden="true">Сайт<input name="website" tabindex="-1" autocomplete="off"></label>
          <label class="consent">
            <input type="checkbox" name="consent" value="1" required>
            <span>Я согласен на обработку персональных данных согласно <a href="https://ikubit.ru/policy/" target="_blank" rel="noreferrer">политике</a>.</span>
          </label>
          <button class="button primary submit-button" type="submit">Отправить заявку</button>
          <div class="form-status" id="form-status" role="status" aria-live="polite"></div>
        </form>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-brand">
        <img src="/assets/mark.svg" alt="" width="44" height="44">
        <div><strong>myvds.su</strong><span>Серверы для рабочих задач</span></div>
      </div>
      <p>Самостоятельная промо-витрина VDS, GPU и выделенных серверов.</p>
      <div class="footer-links">
        <a href="https://ikubit.ru/policy/" target="_blank" rel="noreferrer">Обработка данных</a>
        <a href="https://ikubit.ru/offer/" target="_blank" rel="noreferrer">Публичная оферта</a>
        <a href="https://lk.ikubit.ru" target="_blank" rel="noreferrer">Личный кабинет</a>
      </div>
      <small>© 2026 myvds.su · Оператор услуг ООО «ЦОД»</small>
    </footer>
  </div>
</body>
</html>
