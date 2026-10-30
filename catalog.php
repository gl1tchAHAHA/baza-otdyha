<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Варианты проживания — Лесная гавань';
$type = trim($_GET['type'] ?? '');
$guests = max(1, (int)($_GET['guests'] ?? 1));
$sql = "SELECT * FROM accommodations WHERE status = 'active'";
$params = [];
if ($type !== '') { $sql .= ' AND type = ?'; $params[] = $type; }
$sql .= ' AND capacity >= ? ORDER BY price_per_night'; $params[] = $guests;
$stmt = $pdo->prepare($sql); $stmt->execute($params); $items = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><span class="eyebrow">ПРОЖИВАНИЕ</span><h1>Найдите свой<br><em>формат отдыха</em></h1><p>Выберите домик или номер, который подойдёт именно вашей поездке.</p></div></section>
<section class="container catalog-layout">
    <aside class="filter-panel"><h3>Подбор варианта</h3><form method="get"><label class="form-label">Тип проживания</label><select name="type" class="form-select mb-3"><option value="">Все варианты</option><?php foreach (['Домик','Коттедж','Номер','Глэмпинг'] as $option): ?><option value="<?= e($option) ?>" <?= $type === $option ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?></select><label class="form-label">Количество гостей</label><select name="guests" class="form-select mb-3"><?php for($i=1;$i<=8;$i++): ?><option value="<?= $i ?>" <?= $guests===$i?'selected':'' ?>><?= $i ?></option><?php endfor; ?></select><button class="btn btn-green w-100">Показать варианты</button><a href="/catalog.php" class="clear-link">Сбросить фильтры</a></form></aside>
    <div class="catalog-results"><div class="results-top"><span>Найдено вариантов: <strong><?= count($items) ?></strong></span><span>Цены указаны за одну ночь</span></div><div class="row g-4">
    <?php foreach($items as $item): ?><div class="col-md-6"><article class="stay-card"><a href="/room.php?id=<?= (int)$item['id'] ?>" class="stay-visual visual-<?= (int)$item['id']%3 ?>"><span class="visual-badge"><?= e($item['type']) ?></span><span class="stay-illustration">⌂</span><span class="visual-caption">ЛЕСНАЯ ГАВАНЬ</span></a><div class="stay-info"><div><h3><a href="/room.php?id=<?= (int)$item['id'] ?>"><?= e($item['title']) ?></a></h3><p>До <?= (int)$item['capacity'] ?> гостей · <?= e($item['amenities']) ?></p><a class="small-link" href="/room.php?id=<?= (int)$item['id'] ?>">Подробнее →</a></div><div class="stay-price"><strong><?= number_format((float)$item['price_per_night'],0,',',' ') ?> ₽</strong><small>за ночь</small></div></div></article></div><?php endforeach; ?>
    <?php if(!$items): ?><div class="col-12"><div class="empty-state"><span>⌂</span><h3>Варианты не найдены</h3><p>Измените фильтры или выберите другое количество гостей.</p><a class="btn btn-outline-green" href="/catalog.php">Показать все варианты</a></div></div><?php endif; ?>
    </div></div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
