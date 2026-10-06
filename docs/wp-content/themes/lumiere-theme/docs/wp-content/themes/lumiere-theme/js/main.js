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

/**
 * 営業カレンダー(.lumiere-calendar)の描画
 *
 * サーバー(PHP)側では「今月」を計算せず、休業日データを丸ごと
 * data-closures属性(JSON)としてHTMLに埋め込むだけにしてある。
 * ここで、閲覧者のブラウザの「現在日時」をもとに年月・日付のマス目を
 * 組み立てる。静的サイト(Simply Static書き出し)として公開していても、
 * ページを開くたびに常に「今月」のカレンダーが表示される。
 */
document.addEventListener('DOMContentLoaded', function () {
  var calendars = document.querySelectorAll('.lumiere-calendar');
  if (!calendars.length) return;

  var now = new Date();
  var year = now.getFullYear();
  var month = now.getMonth() + 1; // 1-12
  var today = now.getDate();
  var yearMonthKey = String(year) + String(month).padStart(2, '0'); // 例: "202610"

  var weekdayLabels = ['日', '月', '火', '水', '木', '金', '土'];
  var daysInMonth = new Date(year, month, 0).getDate();
  var startWeekday = new Date(year, month - 1, 1).getDay();

  calendars.forEach(function (calendar) {
    var closuresByDay = {};
    var raw = calendar.getAttribute('data-closures');

    if (raw) {
      try {
        JSON.parse(raw).forEach(function (item) {
          var dateStr = String(item.date || '');
          if (dateStr.length === 8 && dateStr.slice(0, 6) === yearMonthKey) {
            closuresByDay[parseInt(dateStr.slice(6, 8), 10)] = item.title || '';
          }
        });
      } catch (e) {
        closuresByDay = {};
      }
    }

    var heading = calendar.querySelector('.lumiere-calendar-heading');
    if (heading) {
      heading.textContent = year + '年' + month + '月の営業カレンダー';
    }

    var theadRow = calendar.querySelector('thead tr');
    if (theadRow) {
      theadRow.innerHTML = '';
      weekdayLabels.forEach(function (label) {
        var th = document.createElement('th');
        th.textContent = label;
        theadRow.appendChild(th);
      });
    }

    var tbody = calendar.querySelector('tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    var row = document.createElement('tr');

    for (var i = 0; i < startWeekday; i++) {
      var leadingEmpty = document.createElement('td');
      leadingEmpty.className = 'is-empty';
      row.appendChild(leadingEmpty);
    }

    var col = startWeekday;
    for (var day = 1; day <= daysInMonth; day++) {
      var td = document.createElement('td');
      var classes = [];
      var closureTitle = closuresByDay[day];

      if (closureTitle !== undefined) {
        classes.push('is-closed');
        td.title = closureTitle;
      }
      if (day === today) {
        classes.push('is-today');
      }

      td.className = classes.join(' ');
      td.textContent = String(day);
      row.appendChild(td);

      col++;
      if (col % 7 === 0 && day !== daysInMonth) {
        tbody.appendChild(row);
        row = document.createElement('tr');
      }
    }

    var remaining = (7 - (col % 7)) % 7;
    for (var j = 0; j < remaining; j++) {
      var trailingEmpty = document.createElement('td');
      trailingEmpty.className = 'is-empty';
      row.appendChild(trailingEmpty);
    }
    tbody.appendChild(row);
  });
});
