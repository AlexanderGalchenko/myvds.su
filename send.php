<?php
declare(strict_types=1);

session_start();

$wantsJson = strpos((string) ($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json') !== false
    || strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';

function respond(bool $ok, string $message, int $status, string $id = '')
{
    global $wantsJson;

    http_response_code($status);
    if ($wantsJson) {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-store');
        echo json_encode(
            ['ok' => $ok, 'id' => $id, $ok ? 'message' : 'error' => $message],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        exit;
    }

    $query = $ok
        ? http_build_query(['sent' => '1', 'id' => $id])
        : http_build_query(['error' => '1']);
    header('Location: /?' . $query . '#request', true, 303);
    exit;
}

function input_text(string $key, int $maxLength): string
{
    $value = trim((string) ($_POST[$key] ?? ''));
    $value = str_replace(["\0", "\r"], '', $value);

    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $maxLength, 'UTF-8');
    }

    return substr($value, 0, $maxLength);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: /#request', true, 303);
    exit;
}

$honeypot = input_text('website', 200);
if ($honeypot !== '') {
    respond(true, 'Заявка принята.', 201, 'accepted');
}

$sessionToken = (string) ($_SESSION['myvds_csrf'] ?? '');
$requestToken = (string) ($_POST['csrf'] ?? '');
if ($sessionToken === '' || $requestToken === '' || !hash_equals($sessionToken, $requestToken)) {
    respond(false, 'Страница устарела. Обновите её и повторите отправку.', 419);
}

$lastLeadAt = (int) ($_SESSION['myvds_last_lead_at'] ?? 0);
if ($lastLeadAt > 0 && time() - $lastLeadAt < 15) {
    respond(false, 'Заявка уже отправлялась. Подождите несколько секунд.', 429);
}

$name = input_text('name', 120);
$contact = input_text('contact', 160);
$service = input_text('service', 160);
$message = input_text('message', 2000);
$consent = (string) ($_POST['consent'] ?? '') === '1';

if (strlen($name) < 2) {
    respond(false, 'Укажите имя.', 422);
}
if (strlen($contact) < 3 || !preg_match('/[0-9@+]/u', $contact)) {
    respond(false, 'Укажите телефон или email.', 422);
}
if (strpos($contact, '@') !== false && filter_var($contact, FILTER_VALIDATE_EMAIL) === false) {
    respond(false, 'Проверьте адрес электронной почты.', 422);
}
if ($service === '') {
    respond(false, 'Выберите конфигурацию.', 422);
}
if (!$consent) {
    respond(false, 'Нужно согласие на обработку персональных данных.', 422);
}

try {
    $leadId = date('Ymd-His') . '-' . bin2hex(random_bytes(3));
} catch (Throwable $error) {
    $leadId = date('Ymd-His') . '-' . substr(hash('sha256', uniqid('', true)), 0, 6);
}

$record = [
    'id' => $leadId,
    'created_at' => date(DATE_ATOM),
    'status' => 'new',
    'source' => 'myvds.su',
    'name' => $name,
    'contact' => $contact,
    'service' => $service,
    'message' => $message,
    'ip' => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
    'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500),
];

$configuredLog = trim((string) getenv('MYVDS_LEADS_FILE'));
$logFile = $configuredLog !== ''
    ? $configuredLog
    : dirname(__DIR__) . '/storage/myvds-leads.ndjson';

$logLine = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($logLine === false || file_put_contents($logFile, $logLine . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
    error_log('myvds.su: lead write failed: ' . $leadId . ' -> ' . $logFile);
    respond(false, 'Заявка не сохранилась. Позвоните по номеру +7 (926) 000-02-03.', 500);
}

$_SESSION['myvds_last_lead_at'] = time();

$mailBody = implode("\n", [
    'Новая заявка myvds.su',
    'Номер: ' . $leadId,
    'Дата: ' . $record['created_at'],
    'Имя: ' . $name,
    'Контакт: ' . $contact,
    'Конфигурация: ' . $service,
    '',
    'Задача:',
    $message !== '' ? $message : 'Не указана',
]);

$subject = '=?UTF-8?B?' . base64_encode('Новая заявка myvds.su №' . $leadId) . '?=';
$headers = [
    'From: myvds.su <no-reply@myvds.su>',
    'Content-Type: text/plain; charset=UTF-8',
    'MIME-Version: 1.0',
];
if (filter_var($contact, FILTER_VALIDATE_EMAIL) !== false) {
    $headers[] = 'Reply-To: ' . $contact;
}

if (function_exists('mail')) {
    @mail('ag@nxss.ru', $subject, $mailBody, implode("\r\n", $headers));
}

respond(true, 'Заявка принята.', 201, $leadId);
