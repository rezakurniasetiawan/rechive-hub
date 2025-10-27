function bindAjaxLinks() {
  const mainContent = document.getElementById('main-content');
  const links = document.querySelectorAll('.ajax-link');
  console.log('[AJAX DEBUG] Found links total:', links.length);
//   console.log('[AJAX DEBUG] Sidebar HTML:', document.querySelector('.side-menu')?.innerHTML);

  links.forEach(link => {
    const newLink = link.cloneNode(true);
    link.parentNode.replaceChild(newLink, link);

    newLink.addEventListener('click', function (e) {
      e.preventDefault();
      const url = this.href;
      console.log('[AJAX DEBUG] Clicked:', url);

      document.querySelectorAll('.ajax-link').forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      mainContent.innerHTML = '<div style="padding:20px;text-align:center;">Loading...</div>';

      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => {
          if (!res.ok) throw new Error('Network response was not ok');
          return res.text();
        })
        .then(html => {
          console.log('[AJAX DEBUG] Response received from:', url);
          mainContent.innerHTML = html;
          window.history.pushState({}, '', url);
          bindAjaxLinks();
        })
        .catch(err => {
          console.error('[AJAX ERROR]', err);
          mainContent.innerHTML = '<div style="color:red;padding:20px;">Error loading page.</div>';
        });
    });
  });
}

document.addEventListener('DOMContentLoaded', function() {
  console.log('[AJAX DEBUG] DOM loaded, initializing bindAjaxLinks...');
  bindAjaxLinks();
});
