<?php
require_once __DIR__ . '/functions.php';
$user = current_user();
$flash = get_flash();
$pageTitle = $pageTitle ?? 'База отдыха «Лесная гавань»';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Отдых на природе в уютных домиках и коттеджах базы отдыха «Лесная гавань».">
    <title><?= e($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <nav class="navbar navbar-expand-lg container py-3">
        <a class="navbar-brand brand" href="<?= BASE_URL ?>/"><span class="brand-mark">ЛГ</span><span>Лесная гавань<small>БАЗА ОТДЫХА</small></span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Открыть меню"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/catalog.php">Проживание</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/#services">Услуги</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/#about">О базе</a></li>
                <?php if ($user): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/profile.php">Личный кабинет</a></li>
                    <?php if ($user['role'] === 'admin'): ?><li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/">Администрирование</a></li><?php endif; ?>
                    <li class="nav-item"><form method="post" action="<?= BASE_URL ?>/logout.php" class="nav-logout-form"> <?= csrf_field() ?><button class="btn btn-outline-green btn-sm" type="submit">Выйти</button></form></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/login.php">Войти</a></li>
                    <li class="nav-item"><a class="btn btn-green btn-sm" href="<?= BASE_URL ?>/register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<main>
<?php if ($flash): ?>
    <div class="container flash-wrap"><div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert"><?= e($flash['message']) ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button></div></div>
<?php endif; ?>
