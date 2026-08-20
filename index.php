<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$vdsPlans = [
    ['name' => '1 CPU / 1 GB RAM', 'disk' => '32 GB NVME', 'price' => '350 ₽', 'description' => 'NMS сервер, мониторинг, небольшой сайт или тестовый сервер.'],
    ['name' => '1 CPU / 2 GB RAM', 'disk' => '32 GB NVME', 'price' => '900 ₽', 'description' => 'WordPress, Telegram-бот, веб-приложение, небольшая база.'],
    ['name' => '2 CPU / 2 GB RAM', 'disk' => '64 GB NVME', 'price' => '1 500 ₽', 'description' => 'Корпоративный сайт, CRM, Docker с 1–2 сервисами.'],
    ['name' => '2 CPU / 4 GB RAM', 'disk' => '64 GB NVME', 'price' => '2 000 ₽', 'description' => 'Интернет-магазин, backend API, 1С-Битрикс, MySQL.'],
    ['name' => '4 CPU / 8 GB RAM', 'disk' => '128 GB NVME', 'price' => '3 000 ₽', 'description' => 'Нагруженные сайты, PostgreSQL, Redis, очереди.'],
    ['name' => '6 CPU / 12 GB RAM', 'disk' => '160 GB NVME', 'price' => '4 000 ₽', 'description' => 'Интернет-магазины, CRM, backend + база данных.'],
    ['name' => '8 CPU / 16 GB RAM', 'disk' => '256 GB NVME', 'price' => '5 000 ₽', 'description' => 'Highload backend, виртуальные АТС, биллинг.'],
    ['name' => '8 CPU / 32 GB RAM', 'disk' => '256 GB NVME', 'price' => '7 000 ₽', 'description' => 'Базы данных, ERP, CRM, n8n, очереди.'],
    ['name' => '8 CPU / 32 GB RAM', 'disk' => '512 GB NVME', 'price' => '10 000 ₽', 'description' => 'Тяжёлые БД, файловые сервисы, несколько проектов.'],
    ['name' => '16 CPU / 64 GB RAM', 'disk' => '1024 GB NVME', 'price' => '20 000 ₽', 'description' => 'Highload, Kubernetes, крупные БД, аналитика.'],
    ['name' => '24 CPU / 96 GB RAM', 'disk' => '1500 GB NVME', 'price' => '28 000 ₽', 'description' => '1 выделенный IPv4, 1 Гбит/с, 50 TB трафика.'],
    ['name' => 'Индивидуальная конфигурация', 'disk' => 'CPU / RAM / NVME / сеть', 'price' => 'По запросу', 'description' => 'IPv4, порт и параметры сервера — по запросу.'],
];

$gpuPlans = [
    ['name' => 'RTX 5090 32GB', 'cpu' => '32 CPU', 'ram' => '64 GB DDR5', 'disk' => '1024 GB NVMe', 'gpu' => '1 × RTX 5090', 'vram' => '32 GB DDR7', 'network' => '1 Гбит/с · 100 TB трафика', 'price' => '50 000 ₽', 'description' => 'LLM 30B+, обучение и AI-сервисы.'],
    ['name' => '2× RTX 5090 32GB', 'cpu' => '32 CPU', 'ram' => '128 GB RAM', 'disk' => '1024 GB NVMe', 'gpu' => '2 × RTX 5090', 'vram' => '32 GB DDR7', 'network' => '1 Гбит/с · 100 TB трафика', 'price' => '95 000 ₽', 'description' => 'LLM 30B+, обучение и параллельные AI-задачи.'],
    ['name' => 'RTX 4090 48GB', 'cpu' => 'AMD EPYC 7702', 'ram' => '128 GB RAM', 'disk' => '1024 GB NVMe', 'gpu' => '1 × RTX 4090', 'vram' => '48 GB', 'network' => '1 Гбит/с · 100 TB трафика', 'price' => '45 000 ₽', 'description' => 'Инференс LLM, ComfyUI и fine-tuning.'],
];

$vdsCabinetUrl = 'https://lk.ikubit.ru/services/vps';
$mainRequestUrl = 'https://ikubit.ru/contacts/';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VDS и GPU-серверы в Ростове-на-Дону — myvds.su</title>
  <meta name="description" content="VDS/VPS и выделенные GPU-серверы с размещением в дата-центре в Ростове-на-Дону по адресу Сарьяна, 83/17.">
  <meta name="theme-color" content="#06101c">
  <link rel="icon" href="/assets/mark.svg" type="image/svg+xml">
  <link rel="stylesheet" href="/assets/style.css?v=20260820">
  <script src="/assets/app.js?v=20260820" defer></script>
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
        <a href="#datacenter">Дата-центр</a>
        <a href="#request">GPU-заявка</a>
        <a class="nav-login" href="<?= e($vdsCabinetUrl) ?>">Личный кабинет ↗</a>
      </nav>
    </header>

    <main id="main">
      <section class="hero" id="top">
        <div class="hero-pattern" aria-hidden="true"></div>
        <div class="hero-copy">
          <div class="eyebrow"><span></span> Серверы в российском дата-центре</div>
          <h1>VDS и GPU<br>в Ростове-на-Дону</h1>
          <p>Виртуальные и выделенные GPU-серверы размещаются на собственной площадке в Ростове-на-Дону по адресу ул. Сарьяна, 83/17. Питание, охлаждение, сеть и состояние оборудования находятся под круглосуточным контролем.</p>
          <div class="hero-actions">
            <a class="button primary" href="#plans">Выбрать сервер</a>
            <a class="button secondary" href="<?= e($mainRequestUrl) ?>">Обсудить задачу</a>
          </div>
          <div class="hero-note"><span class="signal"></span> Ростов-на-Дону, ул. Сарьяна, 83/17</div>
        </div>

        <aside class="promo-card" aria-label="О дата-центре">
          <div class="promo-top"><span>Дата-центр</span><strong>Ростов-на-Дону</strong></div>
          <div class="promo-value">24/7</div>
          <p>инженерный контроль серверной инфраструктуры</p>
          <dl>
            <div><dt>Адрес</dt><dd>Сарьяна, 83/17</dd></div>
            <div><dt>Питание</dt><dd>через систему ИБП</dd></div>
            <div><dt>Контроль</dt><dd>климат и оборудование</dd></div>
          </dl>
          <a class="promo-link" href="#datacenter">Подробнее о площадке <span>→</span></a>
        </aside>
      </section>

      <section class="metrics" aria-label="Ключевые преимущества">
        <div><strong>200 Мбит/с</strong><span>безлимитный порт VDS</span></div>
        <div><strong>1 IPv4</strong><span>входит в VDS</span></div>
        <div><strong>NVMe</strong><span>быстрые диски</span></div>
        <div><strong>24 / 7</strong><span>контроль площадки</span></div>
      </section>

      <section class="section plans-section" id="plans">
        <div class="section-heading">
          <div>
            <div class="eyebrow"><span></span> Тарифы на услуги</div>
            <h2>Конфигурации VDS и GPU</h2>
          </div>
          <div class="plan-tabs" role="tablist" aria-label="Тип сервера">
            <button type="button" role="tab" aria-selected="true" aria-controls="vds-plans" id="vds-tab" class="active" data-plan-type="VDS">VDS / VPS</button>
            <button type="button" role="tab" aria-selected="false" aria-controls="gpu-plans" id="gpu-tab" data-plan-type="GPU">GPU-серверы</button>
          </div>
        </div>

        <div class="plan-grid plan-group" id="vds-plans" role="tabpanel" aria-labelledby="vds-tab" data-plan-group="VDS">
          <?php foreach ($vdsPlans as $index => $plan): ?>
            <a class="plan-card" href="<?= e($vdsCabinetUrl) ?>" aria-label="<?= e($plan['name'] . ', ' . $plan['price'] . ' в месяц — перейти в личный кабинет') ?>">
              <div class="plan-card-head">
                <span class="plan-index">VDS <?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <?php if ($index === 3): ?><span class="plan-badge">Популярный</span><?php endif; ?>
              </div>
              <h3><?= e($plan['name']) ?></h3>
              <div class="price"><strong><?= e($plan['price']) ?></strong><?php if ($plan['price'] !== 'По запросу'): ?><span>/ месяц</span><?php endif; ?></div>
              <ul>
                <li><?= e($plan['disk']) ?></li>
                <li>1 выделенный IPv4</li>
                <li>Порт 200 Мбит/с</li>
                <li>Размещение данных в РФ</li>
              </ul>
              <p><?= e($plan['description']) ?></p>
              <span class="plan-action">Перейти в личный кабинет <span>→</span></span>
            </a>
          <?php endforeach; ?>
        </div>

        <div class="plan-grid plan-group" id="gpu-plans" role="tabpanel" aria-labelledby="gpu-tab" data-plan-group="GPU" hidden>
          <?php foreach ($gpuPlans as $index => $plan): ?>
            <?php
              $service = sprintf(
                  'GPU сервер: %s / %s %s / %s / %s / %s / %s — %s/мес',
                  $plan['name'],
                  $plan['gpu'],
                  $plan['vram'],
                  $plan['cpu'],
                  $plan['ram'],
                  $plan['disk'],
                  $plan['network'],
                  $plan['price']
              );
              $gpuRequestUrl = $mainRequestUrl . '?service=' . rawurlencode($service);
            ?>
            <a class="plan-card" href="<?= e($gpuRequestUrl) ?>" aria-label="<?= e($plan['name'] . ', ' . $plan['price'] . ' в месяц — заполнить заявку') ?>">
              <div class="plan-card-head">
                <span class="plan-index">GPU <?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <?php if ($index === 0): ?><span class="plan-badge">Высокая скорость</span><?php endif; ?>
              </div>
              <h3><?= e($plan['name']) ?></h3>
              <div class="price"><strong><?= e($plan['price']) ?></strong><span>/ месяц</span></div>
              <ul>
                <li><?= e($plan['gpu'] . ' · ' . $plan['vram']) ?></li>
                <li><?= e($plan['cpu'] . ' · ' . $plan['ram']) ?></li>
                <li><?= e($plan['disk']) ?></li>
                <li><?= e($plan['network']) ?></li>
              </ul>
              <p><?= e($plan['description']) ?></p>
              <span class="plan-action">Заполнить заявку <span>→</span></span>
            </a>
          <?php endforeach; ?>
        </div>

        <p class="plans-footnote">VDS/VPS оформляются в личном кабинете. Заявка требуется только для GPU-серверов: выбранная конфигурация автоматически переносится в форму основного сайта.</p>
      </section>

      <section class="section advantages" id="datacenter">
        <div class="advantages-intro">
          <div class="eyebrow"><span></span> Площадка в Ростове-на-Дону</div>
          <h2>Дата-центр на Сарьяна, 83/17</h2>
          <p>Мы размещаем серверы в собственной инфраструктуре и сами отвечаем за её эксплуатацию. Это сокращает путь от обращения до технического решения: сеть, питание и оборудование контролирует одна инженерная команда.</p>
          <a class="text-link" href="https://ikubit.ru/contacts/">Контакты и заявка на основном сайте <span>→</span></a>
        </div>
        <div class="advantage-grid">
          <article><span>01</span><h3>Бесперебойное питание</h3><p>Серверная нагрузка подключена к системе бесперебойного питания, а состояние электроснабжения контролируется круглосуточно.</p></article>
          <article><span>02</span><h3>Контроль климата</h3><p>Температура и работа систем охлаждения постоянно отслеживаются инженерной автоматикой.</p></article>
          <article><span>03</span><h3>Сеть и IPv4</h3><p>VDS получают выделенный IPv4 и сетевой порт согласно выбранному тарифу.</p></article>
          <article><span>04</span><h3>Техническая поддержка</h3><p>Инженеры сопровождают инфраструктуру и принимают обращения через чат личного кабинета.</p></article>
        </div>
      </section>

      <section class="section handoff-section" id="request">
        <div class="handoff-copy">
          <div class="eyebrow"><span></span> Оформление услуги</div>
          <h2>Продолжите на основном сайте</h2>
          <p>VDS оформляется через личный кабинет без заявки. Для GPU-серверов откроется форма основного сайта, где выбранная конфигурация уже будет указана для инженеров.</p>
        </div>
        <div class="handoff-card">
          <a class="handoff-option" href="<?= e($vdsCabinetUrl) ?>">
            <span>VDS / VPS</span>
            <strong>Перейти в личный кабинет</strong>
            <small>Выбор тарифа и управление услугой</small>
            <b aria-hidden="true">→</b>
          </a>
          <a class="handoff-option" href="<?= e($mainRequestUrl) ?>">
            <span>GPU-серверы</span>
            <strong>Оставить GPU-заявку</strong>
            <small>Выбранная конфигурация заполнится автоматически</small>
            <b aria-hidden="true">→</b>
          </a>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-brand">
        <img src="/assets/mark.svg" alt="" width="44" height="44">
        <div><strong>myvds.su</strong><span>Серверы для рабочих задач</span></div>
      </div>
      <p>VDS и GPU-серверы с размещением в Ростове-на-Дону.</p>
      <div class="footer-links">
        <a href="https://ikubit.ru/policy/">Обработка данных</a>
        <a href="https://ikubit.ru/offer/">Публичная оферта</a>
        <a href="https://lk.ikubit.ru">Личный кабинет</a>
      </div>
      <small>© 2026 myvds.su · Оператор услуг ООО «ЦОД»</small>
    </footer>
  </div>
</body>
</html>
