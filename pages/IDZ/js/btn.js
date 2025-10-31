document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('youtubeBtn');

  // Устанавливаем ссылку на видео YouTube
  btn.setAttribute('href', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'); // замени на нужное видео
  btn.setAttribute('target', '_blank'); // чтобы открывалось в новой вкладке

  // Добавляем всплывающую подсказку
  btn.setAttribute('title', 'Видео на YouTube');
});
