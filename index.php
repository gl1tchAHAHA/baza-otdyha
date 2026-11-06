<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Лесная гавань — отдых на природе';
$stmt = $pdo->query("SELECT * FROM accommodations WHERE status = 'active' ORDER BY id LIMIT 3");
$featured = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="hero-section">
    <div class="hero-orb hero-orb-one"></div><div class="hero-orb hero-orb-two"></div>
    <div class="container hero-content">
        <div class="hero-copy">
            <span class="eyebrow light-eyebrow">ОТДЫХ СРЕДИ ПРИРОДЫ</span>
            <h1>Пауза, которая<br><em>вам необходима</em></h1>
            <p>Уютные домики, свежий воздух и спокойствие вдали от городской суеты. Выбирайте свой формат отдыха.</p>
            <div class="hero-actions"><a class="btn btn-sand btn-lg" href="<?= BASE_URL ?>/catalog.php">Выбрать проживание <span>↗</span></a><span class="hero-caption">Комфортно в любое время года</span></div>
        </div>
        <div class="hero-art" aria-label="Иллюстрация домика в лесу" role="img">
            <div class="sun"></div><div class="mountain mountain-back"></div><div class="mountain mountain-front"></div>
            <div class="tree tree-a">♠</div><div class="tree tree-b">♠</div><div class="tree tree-c">♠</div>
            <div class="cabin"><div class="roof"></div><div class="cabin-body"><div class="window"></div><div class="door"></div></div></div>
            <div class="art-label">ТИШИНА · ЛЕС · ОТДЫХ</div>
        </div>
    </div>
    <div class="container hero-bottom"><span>Самарская область</span><span>01 / 04</span></div>
</section>
<section class="search-strip container">
    <div><span class="search-label">ПЛАНИРУЕТЕ ОТДЫХ?</span><strong>Найдите подходящее место</strong></div>
    <form action="<?= BASE_URL ?>/catalog.php" method="get" class="search-form">
        <label>Заезд<input type="date" name="from" min="<?= e(date('Y-m-d')) ?>"></label>
        <label>Выезд<input type="date" name="to" min="<?= e(date('Y-m-d', strtotime('+1 day'))) ?>"></label>
        <label>Гостей<select name="guests"><option value="1">1 гость</option><option value="2" selected>2 гостя</option><option value="3">3 гостя</option><option value="4">4 гостя</option><option value="5">5 гостей</option><option value="6">6 гостей</option></select></label>
        <button class="btn btn-green" type="submit">Найти вариант</button>
    </form>
</section>
<section class="section-block container" id="about">
    <div class="section-head"><div><span class="eyebrow">МЕСТО ДЛЯ ВАС</span><h2>Отдых начинается<br>с правильного места</h2></div><p>«Лесная гавань» — пространство для спокойных выходных, семейных поездок и коротких путешествий. Здесь всё создано для отдыха без спешки.</p></div>
    <div class="feature-grid"><article class="feature-card"><span class="feature-icon">⌁</span><h3>Ближе к природе</h3><p>Зелёная территория, прогулки и чистый воздух.</p></article><article class="feature-card"><span class="feature-icon">⌂</span><h3>Уютное проживание</h3><p>Домики и номера с необходимыми удобствами.</p></article><article class="feature-card"><span class="feature-icon">♡</span><h3>Для разных компаний</h3><p>Варианты для пары, семьи или небольшой компании.</p></article><article class="feature-card"><span class="feature-icon">✧</span><h3>Простое бронирование</h3><p>Выберите даты и оформите заявку онлайн.</p></article></div>
</section>
<section class="accommodation-section">
    <div class="container"><div class="section-head"><div><span class="eyebrow">НАШИ ВАРИАНТЫ</span><h2>Выберите свой<br>уютный уголок</h2></div><a class="text-link" href="<?= BASE_URL ?>/catalog.php">Весь каталог <span>→</span></a></div>
    <div class="row g-4">
    <?php foreach ($featured as $item): ?>
        <div class="col-md-4"><article class="stay-card"><a href="<?= BASE_URL ?>/room.php?id=<?= (int)$item['id'] ?>" class="stay-visual visual-<?= (int)$item['id'] % 3 ?>"><span class="visual-badge"><?= e($item['type']) ?></span><img class="stay-photo" src="<?= BASE_URL ?>/assets/img/<?= e($item['image']) ?>" alt="<?= e($item['title']) ?>"><span class="visual-caption">ЛЕСНАЯ ГАВАНЬ</span></a><div class="stay-info"><div><h3><a href="<?= BASE_URL ?>/room.php?id=<?= (int)$item['id'] ?>"><?= e($item['title']) ?></a></h3><p><?= (int)$item['capacity'] ?> гостей · <?= e($item['amenities']) ?></p></div><div class="stay-price"><strong><?= number_format((float)$item['price_per_night'], 0, ',', ' ') ?> ₽</strong><small>за ночь</small></div></div></article></div>
    <?php endforeach; ?>
    <?php if (!$featured): ?><div class="col-12"><p>Варианты проживания скоро появятся в каталоге.</p></div><?php endif; ?>
    </div></div>
</section>
<section class="services-section container" id="services"><div class="section-head"><div><span class="eyebrow">ЧЕМ ЗАНЯТЬСЯ</span><h2>Всё для хорошего<br>отдыха</h2></div><p>Можно посвятить время прогулкам, провести вечер в приятной компании или просто отдохнуть в тишине.</p></div><div class="service-list"><div><span>01</span><strong>Прогулки по территории</strong><small>Природа и свежий воздух</small></div><div><span>02</span><strong>Зона отдыха</strong><small>Время с близкими</small></div><div><span>03</span><strong>Семейный отдых</strong><small>Пространство для всей семьи</small></div></div></section>
<section class="cta-section"><div class="container cta-inner"><span class="eyebrow light-eyebrow">ВАШ ОТДЫХ УЖЕ БЛИЖЕ</span><h2>Пора сменить ритм</h2><p>Выберите даты, найдите подходящий домик и оставьте заявку на бронирование.</p><a href="<?= BASE_URL ?>/catalog.php" class="btn btn-sand">Перейти в каталог ↗</a></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
