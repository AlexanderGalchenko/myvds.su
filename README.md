# myvds.su

PHP-лендинг для `myvds.su`. Дизайн выдержан в близком к основному проекту стиле, но сайт остаётся самостоятельным брендом.

## Что находится в репозитории

- `index.php` — главная страница и форма заявки;
- `send.php` — обработчик формы с CSRF, honeypot и ограничением частоты;
- `assets/` — стили, JavaScript и самостоятельная SVG-графика;
- `vds.php`, `gpu.php`, `about.php`, `contacts.php` — совместимые редиректы со старых адресов;
- `deploy/web-gw-update.sh` — обновление сайта на `web-GW-146` с резервной копией.

Заявки не хранятся в Git. По умолчанию обработчик пишет их в:

`/docker/web-gw/www/html/storage/myvds-leads.ndjson`

Также выполняется попытка отправить уведомление на `ag@nxss.ru` через PHP `mail()`.

## Первая установка на сервер

```bash
mkdir -p /docker/web-gw/repos
git clone https://github.com/AlexanderGalchenko/myvds.su.git \
  /docker/web-gw/repos/myvds.su

cd /docker/web-gw/repos/myvds.su
bash deploy/web-gw-update.sh --dry-run
bash deploy/web-gw-update.sh
```

Скрипт:

1. обновляет ветку `main` через `git pull --ff-only`;
2. копирует текущий сайт в каталог `backup ` (в его имени есть пробел в конце);
3. синхронизирует файлы в `/docker/web-gw/www/html/myvds.su`;
4. не затрагивает заявки и не переносит `.git` в публичный каталог.

## Последующие обновления

```bash
cd /docker/web-gw/repos/myvds.su
bash deploy/web-gw-update.sh --dry-run
bash deploy/web-gw-update.sh
```

## Подготовка файла заявок

Создайте файл один раз и назначьте владельцем UID/GID процесса PHP-FPM. Для стандартного `www-data` это обычно `33:33`:

```bash
mkdir -p /docker/web-gw/www/html/storage
touch /docker/web-gw/www/html/storage/myvds-leads.ndjson
chown 33:33 /docker/web-gw/www/html/storage/myvds-leads.ndjson
chmod 0660 /docker/web-gw/www/html/storage/myvds-leads.ndjson
```

Если PHP-FPM работает под другим пользователем, подставьте его UID/GID.

## Проверка

```bash
curl -fsS https://myvds.su/ | grep -F 'без лишнего слоя'
curl -sSI https://myvds.su/vds.php | head
curl -sSI https://myvds.su/contacts.php | head
tail -n 3 /docker/web-gw/www/html/storage/myvds-leads.ndjson
```
