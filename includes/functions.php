<?php
require_once __DIR__ . '/../config.php';

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $url): never {
    // Все внутренние адреса, начинающиеся с /, дополняем адресом папки проекта.
    if (str_starts_with($url, '/') && !str_starts_with($url, '//')) {
        $url = BASE_URL . $url;
    }
    header('Location: ' . $url);
    exit;
}

function set_flash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array {
    if (!isset($_SESSION['flash'])) return null;
    $message = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $message;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void {
    $sent = $_POST['csrf_token'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(400);
        exit('Некорректный запрос. Обновите страницу и повторите действие.');
    }
}

function current_user(): ?array {
    global $pdo;
    if (empty($_SESSION['user_id'])) return null;
    $stmt = $pdo->prepare('SELECT id, full_name, email, phone, role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (!$user) unset($_SESSION['user_id']);
    return $user ?: null;
}

function is_logged_in(): bool {
    return current_user() !== null;
}

function is_admin(): bool {
    $user = current_user();
    return $user && $user['role'] === 'admin';
}

function require_login(): void {
    if (!is_logged_in()) {
        set_flash('Для продолжения войдите в личный кабинет.', 'warning');
        redirect('/login.php');
    }
}

function require_admin(): void {
    if (!is_admin()) {
        set_flash('Раздел доступен только администратору.', 'danger');
        redirect('/');
    }
}

function nights_count(string $from, string $to): int {
    $start = DateTime::createFromFormat('!Y-m-d', $from);
    $startErrors = DateTime::getLastErrors();
    $end = DateTime::createFromFormat('!Y-m-d', $to);
    $endErrors = DateTime::getLastErrors();
    if (!$start || !$end || $start->format('Y-m-d') !== $from || $end->format('Y-m-d') !== $to) return 0;
    if (($startErrors && ($startErrors['warning_count'] || $startErrors['error_count'])) || ($endErrors && ($endErrors['warning_count'] || $endErrors['error_count']))) return 0;
    if ($end <= $start) return 0;
    return (int)$start->diff($end)->days;
}

function booking_status_label(string $status): string {
    $labels = [
        'pending' => 'Ожидает подтверждения',
        'confirmed' => 'Подтверждена',
        'completed' => 'Завершена',
        'cancelled' => 'Отменена'
    ];
    return $labels[$status] ?? $status;
}

function booking_status_class(string $status): string {
    $classes = [
        'pending' => 'status-pending',
        'confirmed' => 'status-confirmed',
        'completed' => 'status-completed',
        'cancelled' => 'status-cancelled'
    ];
    return $classes[$status] ?? 'status-cancelled';
}
