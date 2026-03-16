(() => {
  const root = document.querySelector('[data-events]');
  if (!root) return;

  const tabs = Array.from(root.querySelectorAll('.event-tab'));
  const img = root.querySelector('[data-events-img]');
  const label = root.querySelector('[data-events-label]');
  const list = root.querySelector('[data-events-list]');
  const bookingLink = root.querySelector('[data-booking-link]');

  const eventsArr = Array.isArray(window.EVENTS) ? window.EVENTS : [];
  if (!tabs.length || !eventsArr.length) return;

  // Собираем данные из БД по id_event
  const byId = {};
  for (const e of eventsArr) {
    byId[String(e.id_event)] = {
      title: e.title || '',
      img: e.image || '', // ожидаем путь вида "/assets/..."
      items: String(e.program_points || '')
        .split('\n')
        .map(s => s.trim())
        .filter(Boolean),
    };
  }

  const renderEvent = (eventId) => {
    const cfg = byId[String(eventId)];
    if (!cfg) return;

    // картинка + подпись
    if (img) {
      img.src = cfg.img;
      img.alt = cfg.title;
    }
    if (label) label.textContent = cfg.title;

    // список
    if (list) {
      list.innerHTML = cfg.items
        .map((t, i) => {
          const num = String(i + 1).padStart(2, '0');
          return `<li><span class="num">${num}</span><span class="txt">${t}</span></li>`;
        })
        .join('');
    }
  };

  const setActive = (eventId) => {
    // 1) активность табов + иконки
    tabs.forEach((btn) => {
      const isActive = btn.dataset.eventId === String(eventId);
      btn.classList.toggle('is-active', isActive);
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false');

      const ico = btn.querySelector('.event-tab__ico');
      const src = isActive ? btn.dataset.iconAct : btn.dataset.icon;
      if (ico && src) ico.src = src;
    });

    // 2) обновляем ссылку бронирования
    if (bookingLink) {
      bookingLink.href = `/booking?event_id=${encodeURIComponent(eventId)}`;
    }

    // 3) обновляем контент из БД
    renderEvent(eventId);
  };

  // клики по табам
  tabs.forEach((btn) => {
    btn.addEventListener('click', () => setActive(btn.dataset.eventId));
  });

  // активируем первый таб (или первый event из window.EVENTS)
  const firstId = tabs[0]?.dataset.eventId || eventsArr[0]?.id_event;
  if (firstId) setActive(firstId);
})();