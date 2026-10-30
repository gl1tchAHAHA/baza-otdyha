<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) redirect('/profile.php');
$pageTitle = 'Регистрация — Лесная гавань'; $errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $name=trim($_POST['full_name']??''); $email=trim($_POST['email']??''); $phone=trim($_POST['phone']??'');
    $password=$_POST['password']??''; $confirm=$_POST['password_confirm']??'';
    if ($name==='') $errors[]='Введите ФИО.';
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Введите корректный email.';
    if ($phone==='') $errors[]='Введите номер телефона.';
    if (strlen($password)<8) $errors[]='Пароль должен содержать не менее 8 символов.';
    if ($password!==$confirm) $errors[]='Пароли не совпадают.';
    if (!$errors) { $st=$pdo->prepare('SELECT id FROM users WHERE email=?');$st->execute([$email]);if($st->fetch())$errors[]='Пользователь с таким email уже зарегистрирован.'; }
    if (!$errors) { $hash=password_hash($password,PASSWORD_DEFAULT);$st=$pdo->prepare("INSERT INTO users(full_name,email,phone,password_hash,role) VALUES(?,?,?,?, 'user')");$st->execute([$name,$email,$phone,$hash]);session_regenerate_id(true);$_SESSION['user_id']=(int)$pdo->lastInsertId();set_flash('Регистрация прошла успешно. Добро пожаловать!');redirect('/profile.php'); }
}
include __DIR__.'/includes/header.php';
?>
<section class="auth-section container"><div class="auth-aside"><span class="eyebrow light-eyebrow">ДОБРО ПОЖАЛОВАТЬ</span><h1>Ваш отдых<br><em>начинается здесь</em></h1><p>Создайте аккаунт, чтобы отправлять заявки на проживание и следить за своими бронированиями.</p><div class="auth-decoration">⌂</div></div><div class="auth-card"><span class="eyebrow">НОВЫЙ АККАУНТ</span><h2>Регистрация</h2><?php if($errors): ?><div class="alert alert-danger"><?php foreach($errors as $error): ?><div><?= e($error) ?></div><?php endforeach; ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><label class="form-label">ФИО</label><input class="form-control mb-3" name="full_name" required value="<?= e($_POST['full_name']??'') ?>"><label class="form-label">Электронная почта</label><input class="form-control mb-3" type="email" name="email" required value="<?= e($_POST['email']??'') ?>"><label class="form-label">Телефон</label><input class="form-control mb-3" type="tel" name="phone" required value="<?= e($_POST['phone']??'') ?>"><label class="form-label">Пароль</label><input class="form-control mb-3" type="password" name="password" minlength="8" required><label class="form-label">Повторите пароль</label><input class="form-control mb-4" type="password" name="password_confirm" minlength="8" required><button class="btn btn-green w-100">Зарегистрироваться</button></form><p class="auth-switch">Уже есть аккаунт? <a href="/login.php">Войти</a></p></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
