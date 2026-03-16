(() => {
  const root = document.querySelector('[data-booking]');
  if (!root) return;

  const RATE = 80;
  const MAX_BIKES = 4;

  // refs
  const dateInput = root.querySelector('[data-date]');
  const slotsWrap = root.querySelector('[data-slots]');
  const bikeBtns = Array.from(root.querySelectorAll('[data-bike]'));
  const payWrap = root.querySelector('[data-pay]');
  const payRadios = Array.from(payWrap.querySelectorAll('input[name="pay"]'));

  const elRate = root.querySelector('[data-rate]');
  const elBikesCount = root.querySelector('[data-bikes-count]');
  const elHourSum = root.querySelector('[data-hour-sum]');
  const elHours = root.querySelector('[data-hours]');
  const elStart = root.querySelector('[data-start]');
  const elEnd = root.querySelector('[data-end]');

  const elPayFull = root.querySelector('[data-pay-full]');
  const elPayPart = root.querySelector('[data-pay-part]');
  const elPayNone = root.querySelector('[data-pay-none]');
  const elPayNow = root.querySelector('[data-pay-now]');

  // hidden inputs
  const formDate = root.querySelector('#formDate');
  const formTime = root.querySelector('#formTime');
  const formBikes = root.querySelector('#formBikes');
  const formPayment = root.querySelector('#formPayment');

  // state
  let bikes = 1;
  let payMode = 'full';

  // slots state
  let slotsData = [];      // [{time, available_bikes, is_full, taken?}]
  let selectedStart = null; // "11:00"
  let selectedEnd = null;   // "12:00"

  const money = (n) => Math.round(n);

  const payPercent = (mode) => {
    if (mode === 'full') return 1;
    if (mode === 'part') return 0.30;
    return 0;
  };

  const timeToMin = (t) => {
    // "11:00" -> 660
    const [h, m] = t.split(':').map(Number);
    return h * 60 + m;
  };

  const sortTimes = (arr) => [...arr].sort((a,b) => timeToMin(a) - timeToMin(b));

  const getSlotByTime = (t) => slotsData.find(s => s.time === t);

  const getAllTimes = () => slotsData.map(s => s.time);

  const getRangeTimes = (a, b) => {
    const times = getAllTimes();
    const mins = sortTimes([a,b]);
    const start = mins[0];
    const end = mins[1];

    const startIdx = times.indexOf(start);
    const endIdx = times.indexOf(end);
    if (startIdx < 0 || endIdx < 0) return [];

    const lo = Math.min(startIdx, endIdx);
    const hi = Math.max(startIdx, endIdx);
    return times.slice(lo, hi + 1);
  };

  const rangeIsAllowed = (timesRange) => {
    // запрещаем, если внутри есть is_full или available_bikes < выбранных байков
    for (const t of timesRange) {
      const s = getSlotByTime(t);
      if (!s) return false;
      if (s.is_full) return false;
      if (s.available_bikes < bikes) return false;
    }
    return true;
  };

  const getSelectedTimes = () => {
    if (!selectedStart || !selectedEnd) return [];
    return getRangeTimes(selectedStart, selectedEnd);
  };

  const setBikes = (n) => {
    bikes = Math.max(1, Math.min(MAX_BIKES, n));

    // если текущий выбранный диапазон стал недоступен — сбрасываем выбор
    const selected = getSelectedTimes();
    if (selected.length && !rangeIsAllowed(selected)) {
      selectedStart = null;
      selectedEnd = null;
    }

    renderBikes();
    renderSlotsState();
    render();
  };

  const renderBikes = () => {
    // “звёздочки”: подсвечиваем 1..bikes
    bikeBtns.forEach(btn => {
      const v = Number(btn.dataset.bike);
      btn.classList.toggle('is-on', v <= bikes);
    });
  };

  const renderSlots = () => {
    slotsWrap.innerHTML = '';

    slotsData.forEach(s => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'slot';
      btn.dataset.slot = '';
      btn.dataset.time = s.time;

      // базовая доступность
      const notEnough = s.available_bikes < bikes;
      const busy = s.is_full || notEnough;

      if (busy) {
        btn.classList.add('is-busy');
        btn.disabled = true;
        btn.dataset.status = 'busy';
        btn.innerHTML = `${s.time} <span class="slot__busy">Занято</span>`;
      } else {
        btn.dataset.status = 'free';
        btn.textContent = s.time;
      }

      btn.addEventListener('click', () => onSlotClick(s.time));
      slotsWrap.appendChild(btn);
    });

    // после создания — подсветим выбранные
    renderSlotsState();
  };

  const renderSlotsState = () => {
    const selected = new Set(getSelectedTimes());

    root.querySelectorAll('[data-slot]').forEach(btn => {
      const t = btn.dataset.time;
      btn.classList.toggle('is-selected', selected.has(t));
    });

    // подсказка
    const selectedTimes = getSelectedTimes();
    elHours.textContent = Math.max(1, selectedTimes.length || 1);

    if (selectedTimes.length) {
      const sorted = sortTimes(selectedTimes);
      const start = sorted[0];
      const end = sorted[sorted.length - 1];          
      elStart.textContent = start;
      // делаем конец часа :59
      const endHour = end.split(':')[0];
      elEnd.textContent = endHour + ':59';
    } else {
      elStart.textContent = '—';
      elEnd.textContent = '—';
    }
  };

  const onSlotClick = (time) => {
    // Логика диапазона:
    // 1 клик — старт
    // 2 клик — конец (строим диапазон)
    // 3 клик — перезапуск (новый старт)
    if (!selectedStart) {
      selectedStart = time;
      selectedEnd = time;
      renderSlotsState();
      render();
      return;
    }

    // если кликнули тот же слот — оставляем 1 час
    if (selectedStart === time && selectedEnd === time) {
      renderSlotsState();
      render();
      return;
    }

    // если уже выбран диапазон и кликают снова — считаем, что это новый конец
    // (можно поменять логику, но так удобнее)
    selectedEnd = time;

    const range = getSelectedTimes();
    if (!range.length || !rangeIsAllowed(range)) {
      // запрещаем “дырки” и пересечения занятых
      // откат: делаем 1 час на новом слоте
      selectedStart = time;
      selectedEnd = time;
    }

    renderSlotsState();
    render();
  };

  const render = () => {
    // hours
    const selectedTimes = getSelectedTimes();
    const hours = Math.max(1, selectedTimes.length || 1);

    // totals
    const total = RATE * bikes * hours;
    const hourSum = RATE * bikes;

    elRate.textContent = RATE;
    elBikesCount.textContent = bikes;
    elHourSum.textContent = money(hourSum);

    elPayFull.textContent = money(total);
    elPayPart.textContent = money(total * 0.30);
    elPayNone.textContent = money(0);

    elPayNow.textContent = money(total * payPercent(payMode));

    // active pay style
    const labels = Array.from(payWrap.querySelectorAll('.payopt'));
    labels.forEach(l => l.classList.remove('is-active'));
    const checked = payWrap.querySelector(`input[name="pay"][value="${payMode}"]`);
    if (checked) checked.closest('.payopt')?.classList.add('is-active');

    // hidden inputs
    const dateVal = dateInput?.value || '';
    formDate && (formDate.value = dateVal);

    // time_booking: "11:00,12:00"
    formTime && (formTime.value = selectedTimes.length ? sortTimes(selectedTimes).join(',') : '');
    formBikes && (formBikes.value = String(bikes));
    formPayment && (formPayment.value = payMode);
  };

  const loadSlots = async () => {
    const dateVal = dateInput.value; // YYYY-MM-DD
    if (!dateVal) return;

    const res = await fetch(`/booking/slots?date=${encodeURIComponent(dateVal)}`);
    const data = await res.json();

    slotsData = Array.isArray(data) ? data : [];

    // сброс выбора при смене даты
    selectedStart = null;
    selectedEnd = null;

    renderSlots();
    render();
  };

  // events
  bikeBtns.forEach(btn => btn.addEventListener('click', () => setBikes(Number(btn.dataset.bike))));

  payRadios.forEach(r => {
    r.addEventListener('change', () => {
      payMode = r.value;
      render();
    });
  });

  dateInput?.addEventListener('change', loadSlots);

  // init
  setBikes(1);
  renderBikes();

  // если дата уже стоит — сразу грузим
  if (dateInput?.value) loadSlots();
})();