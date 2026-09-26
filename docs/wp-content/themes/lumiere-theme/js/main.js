document.addEventListener('DOMContentLoaded', function () {
  var btn = document.getElementById('hamburger-btn');
  var nav = document.getElementById('primary-nav');

  if (!btn || !nav) return;

  btn.addEventListener('click', function () {
    var isOpen = nav.classList.toggle('is-open');
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // ナビ内リンクをタップしたら自動的に閉じる
  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      nav.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
    });
  });
});
