<?php
require_once __DIR__ . '/includes/functions.php';
$id = max(0, (int)($_GET['id'] ?? 0));
$stmt = $pdo->prepare("SELECT * FROM accommodations WHERE id = ? AND status = 'active'");
$stmt->execute([$id]); $item = $stmt->fetch();
if (!$item) { http_response_code(404); $pageTitle='Вариант не найден'; include __DIR__.'/includes/header.php'; echo '<section class="container section-block"><h1>Вариант не найден</h1><a href="/catalog.php">Вернуться в каталог</a></section>'; include __DIR__.'/includes/footer.php'; exit; }
$pageTitle = $item['title'] . ' — Лесная гавань';
include __DIR__ . '/includes/header.php';
?>
<section class="container room-page"><div class="room-visual visual-<?= (int)$item['id']%3 ?>"><span class="visual-badge"><?= e($item['type']) ?></span><span class="room-art">⌂</span><span class="visual-caption">ЛЕСНАЯ ГАВАНЬ</span></div><div class="room-content"><div class="room-main"><span class="eyebrow">ПОДРОБНОСТИ</span><h1><?= e($item['title']) ?></h1><p class="room-lead"><?= e($item['description']) ?></p><div class="room-facts"><span>♧ До <?= (int)$item['capacity'] ?> гостей</span><span>⌁ <?= e($item['type']) ?></span><span>✧ Удобства включены</span></div><h3>Удобства</h3><p><?= e($item['amenities']) ?></p><h3>О проживании</h3><p>Вариант подходит для спокойного отдыха на природе. Доступные даты и итоговую стоимость можно проверить на странице бронирования.</p></div><aside class="booking-card"><span class="eyebrow">СТОИМОСТЬ</span><div class="big-price"><?= number_format((float)$item['price_per_night'],0,',',' ') ?> ₽ <small>/ ночь</small></div><p>Максимум гостей: <?= (int)$item['capacity'] ?></p><a class="btn btn-green w-100" href="/booking.php?id=<?= (int)$item['id'] ?>">Забронировать</a><small class="muted-note">Оформление заявки займёт несколько минут.</small></aside></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
