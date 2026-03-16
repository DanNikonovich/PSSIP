<?php
$title = 'FAQ — Admin E-RIDE';
$active = 'faq';
ob_start();
?>

<section class="card">
  <div class="card__head">
    <div>
      <div class="card__title">FAQ</div>
      <div class="card__sub">Добавление / редактирование / скрытие</div>
    </div>
  </div>

  <div class="split">
    <div>
      <h3 class="h3">Добавить вопрос</h3>
      <form class="form" method="post" action="/admin/faq/create">
        <label class="field">
          <span class="field__label">Вопрос</span>
          <span class="field__input"><input name="question" required></span>
        </label>

        <label class="field">
          <span class="field__label">Ответ</span>
          <span class="field__input"><textarea name="answer" rows="5" required></textarea></span>
        </label>

        <div class="row">
          <label class="field">
            <span class="field__label">Порядок</span>
            <span class="field__input"><input name="display_order" type="number" value="1"></span>
          </label>
          <label class="field">
            <span class="field__label">Видимость</span>
            <span class="field__input">
              <select name="visible">
                <option value="1">Показывать</option>
                <option value="0">Скрыть</option>
              </select>
            </span>
          </label>
        </div>

        <button class="btn btn--glow" type="submit">Добавить</button>
      </form>
    </div>

    <div>
      <h3 class="h3">Список</h3>

      <?php foreach (($items ?? []) as $f): ?>
        <div class="faq-item">
          <div class="faq-item__top">
            <div class="faq-item__q"><?= htmlspecialchars($f['question'] ?? '') ?></div>
            <div class="badge <?= ((int)($f['visible'] ?? 0)===1) ? 'badge--on' : 'badge--off' ?>">
              <?= ((int)($f['visible'] ?? 0)===1) ? 'Видно' : 'Скрыто' ?>
            </div>
          </div>

          <div class="faq-item__a"><?= nl2br(htmlspecialchars($f['answer'] ?? '')) ?></div>

          <div class="faq-item__actions">
            <form method="post" action="/admin/faq/toggle">
              <input type="hidden" name="id_faq" value="<?= (int)$f['id_faq'] ?>">
              <input type="hidden" name="visible" value="<?= ((int)($f['visible'] ?? 0)===1) ? 0 : 1 ?>">
              <button class="btn btn--mini" type="submit">
                <?= ((int)($f['visible'] ?? 0)===1) ? 'Скрыть' : 'Показать' ?>
              </button>
            </form>

            <details class="edit">
              <summary class="btn btn--mini">Редактировать</summary>
              <form class="form" method="post" action="/admin/faq/update">
                <input type="hidden" name="id_faq" value="<?= (int)$f['id_faq'] ?>">
                <label class="field">
                  <span class="field__label">Вопрос</span>
                  <span class="field__input"><input name="question" value="<?= htmlspecialchars($f['question'] ?? '') ?>" required></span>
                </label>
                <label class="field">
                  <span class="field__label">Ответ</span>
                  <span class="field__input"><textarea name="answer" rows="4" required><?= htmlspecialchars($f['answer'] ?? '') ?></textarea></span>
                </label>
                <label class="field">
                  <span class="field__label">Порядок</span>
                  <span class="field__input"><input name="display_order" type="number" value="<?= (int)($f['display_order'] ?? 0) ?>"></span>
                </label>
                <button class="btn btn--mini btn--ok" type="submit">Сохранить</button>
              </form>
            </details>

            <form method="post" action="/admin/faq/delete" onsubmit="return confirm('Удалить FAQ?')">
              <input type="hidden" name="id_faq" value="<?= (int)$f['id_faq'] ?>">
              <button class="btn btn--mini btn--danger" type="submit">Удалить</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/Views/admin/layout.php';