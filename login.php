<?php
require_once __DIR__ . '/includes/functions.php';
if(is_logged_in()) redirect('/profile.php');
$pageTitle='Вход — Лесная гавань';$error='';
if($_SERVER['REQUEST_METHOD']==='POST') { verify_csrf();$email=trim($_POST['email']??'');$password=$_POST['password']??'';$st=$pdo->prepare('SELECT id,password_hash FROM users WHERE email=?');$st->execute([$email]);$user=$st->fetch();if($user&&password_verify($password,$user['password_hash'])){session_regenerate_id(true);$_SESSION['user_id']=(int)$user['id'];set_flash('Вы успешно вошли в систему.');redirect('/profile.php');}else{$error='Неверный email или пароль.';} }
include __DIR__.'/includes/header.php';
?>
<section class="auth-section container"><div class="auth-aside"><span class="eyebrow light-eyebrow">СНОВА РАДЫ ВАС ВИДЕТЬ</span><h1>Вернитесь<br><em>к планам на отдых</em></h1><p>Войдите в аккаунт, чтобы посмотреть свои заявки и продолжить бронирование.</p><div class="auth-decoration">✧</div></div><div class="auth-card auth-card-short"><span class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span><h2>Вход</h2><?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><label class="form-label">Электронная почта</label><input class="form-control mb-3" type="email" name="email" required value="<?= e($_POST['email']??'') ?>"><label class="form-label">Пароль</label><input class="form-control mb-4" type="password" name="password" required><button class="btn btn-green w-100">Войти</button></form><p class="auth-switch">Нет аккаунта? <a href="/register.php">Зарегистрироваться</a></p><p class="demo-hint">Учебный администратор: admin@lesnaya-gavan.ru / password</p></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
