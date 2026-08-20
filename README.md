# myvds.su

PHP-лендинг для `myvds.su`. Дизайн выдержан в близком к основному проекту стиле, но сайт остаётся самостоятельным брендом.

Тарифы VDS и GPU статически зашиты в `index.php`. Сайт не принимает заявки самостоятельно:

- карточки VDS ведут в `https://lk.ikubit.ru/services/vps`;
- карточки GPU открывают форму `https://ikubit.ru/contacts/` и передают выбранную конфигурацию через параметр `service`;
- старая точка `send.php` перенаправляет на форму основного сайта.

## Что находится в репозитории

- `index.php` — главная страница и статическая витрина тарифов;
- `send.php` — совместимый редирект старых запросов на основной сайт;
- `assets/` — стили, JavaScript и самостоятельная SVG-графика;
- `vds.php`, `gpu.php`, `about.php`, `contacts.php` — совместимые редиректы со старых адресов;
- `deploy/web-gw-update.sh` — обновление сайта на `web-GW-146` с резервной копией.

## Первая установка на сервер

```bash
mkdir -p /docker/web-gw/repos
git clone https://github.com/AlexanderGalchenko/myvds.su.git \
  /docker/web-gw/repos/myvds.su

cd /docker/web-gw/repos/myvds.su
bash deploy/web-gw-update.sh --dry-run
bash deploy/web-gw-update.sh

# Необязательно: короткая команда рядом с остальными gitpull-скриптами
ln -sfn /docker/web-gw/repos/myvds.su/deploy/web-gw-update.sh \
  /docker/web-gw/www/html/gitpull-myvds.su.sh
```

Скрипт:

1. обновляет ветку `main` через `git pull --ff-only`;
2. копирует текущий сайт в каталог `backup ` (в его имени есть пробел в конце);
3. синхронизирует файлы в `/docker/web-gw/www/html/myvds.su`;
4. не переносит `.git` в публичный каталог.

## Последующие обновления

```bash
cd /docker/web-gw/repos/myvds.su
bash deploy/web-gw-update.sh --dry-run
bash deploy/web-gw-update.sh

# Или через созданную ссылку:
/docker/web-gw/www/html/gitpull-myvds.su.sh --dry-run
/docker/web-gw/www/html/gitpull-myvds.su.sh
```

## Проверка

```bash
curl -fsS https://myvds.su/ | grep -F 'Сарьяна, 83/17'
curl -sSI https://myvds.su/vds.php | head
curl -sSI https://myvds.su/contacts.php | head
```
