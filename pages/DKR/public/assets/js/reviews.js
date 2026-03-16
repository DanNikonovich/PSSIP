(() => {
  const form = document.querySelector('[data-review-form]');
  if (!form) return;

  const rate = form.querySelector('[data-rate]');
  const stars = Array.from(rate.querySelectorAll('[data-star]'));
  const input = form.querySelector('[data-rating-value]');

  const set = (n) => {
    input.value = String(n);
    stars.forEach(btn => {
      const v = Number(btn.dataset.star);
      const img = btn.querySelector('img');
      if (!img) return;
      img.src = (v <= n)
        ? '/assets/components/svg/star_fill.svg'
        : '/assets/components/svg/star_stroke.svg';
    });
  };

  stars.forEach(btn => {
    btn.addEventListener('click', () => set(Number(btn.dataset.star)));
  });

  // восстановление если было в сессии
  const initial = Number(input.value || 0);
  if (initial > 0) set(initial);
})();