<?php
$title = 'Комментарии — Admin E-RIDE';
$active = 'comments';
ob_start();
?>

<section class="card">
  <div class="card__head">
    <div>
      <div class="card__title">Комментарии</div>
      <div class="card__sub">Одобрение новых и удаление нежелательных</div>
    </div>
  </div>

  <h3 class="h3">На модерации (<?= count($pending ?? []) ?>)</h3>

  <div class="table">
    <div class="tr th">
      <div>#</div><div>Автор</div><div>Дата</div><div>Оценка</div><div>Текст</div><div>Действия</div>
    </div>

    <?php foreach (($pending ?? []) as $c): ?>
      <div class="tr">
        <div><?= (int)$c['id_comment'] ?></div>
        <div><?= htmlspecialchars($c['author_name'] ?? '') ?></div>
        <div><?= htmlspecialchars($c['date_created'] ?? '') ?></div>
        <div><?= (int)($c['rating'] ?? 0) ?></div>
        <div class="text"><?= nl2br(htmlspecialchars($c['text_review'] ?? '')) ?></div>
        <div class="actions">
          <form method="post" action="/admin/comments/approve">
            <input type="hidden" name="id_comment" value="<?= (int)$c['id_comment'] ?>">
            <button class="btn btn--mini btn--ok" type="submit">Одобрить</button>
          </form>
          <form method="post" action="/admin/comments/delete" onsubmit="return confirm('Удалить комментарий?')">
            <input type="hidden" name="id_comment" value="<?= (int)$c['id_comment'] ?>">
            <button class="btn btn--mini btn--danger" type="submit">Удалить</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="sp"></div>

  <h3 class="h3">Опубликованные</h3>
  <div class="table">
    <div class="tr th">
      <div>#</div><div>Автор</div><div>Дата</div><div>Оценка</div><div>Текст</div><div>Действия</div>
    </div>

    <?php foreach (($published ?? []) as $c): ?>
      <div class="tr">
        <div><?= (int)$c['id_comment'] ?></div>
        <div><?= htmlspecialchars($c['author_name'] ?? '') ?></div>
        <div><?= htmlspecialchars($c['date_created'] ?? '') ?></div>
        <div><?= (int)($c['rating'] ?? 0) ?></div>
        <div class="text"><?= nl2br(htmlspecialchars($c['text_review'] ?? '')) ?></div>
        <div class="actions">
          <form method="post" action="/admin/comments/delete" onsubmit="return confirm('Удалить комментарий?')">
            <input type="hidden" name="id_comment" value="<?= (int)$c['id_comment'] ?>">
            <button class="btn btn--mini btn--danger" type="submit">Удалить</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/Views/admin/layout.php';