// toogle dark theme
const imgLogo = document.getElementById('img-logo');
const htmldocument = document.documentElement;

function setTheme(mode) {

  const modes = {
    light: () => {
      htmldocument.classList.remove('dark');
      localStorage.setItem('theme', 'light');
      imgLogo && (imgLogo.src = '/assets/logo-black.png');
    },
    dark: () => {
      htmldocument.classList.add('dark');
      localStorage.setItem('theme', 'dark');
      imgLogo && (imgLogo.src = '/assets/logo-white.png');
    },
    system: () => {
      localStorage.setItem('theme', 'system');
      if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        htmldocument.classList.add('dark');
        imgLogo && (imgLogo.src = '/assets/logo-white.png');
      } else {
        htmldocument.classList.remove('dark');
        imgLogo && (imgLogo.src = '/assets/logo-black.png');
      }
    }
  }

  const inputElement = document.getElementById('input-' + mode);
  if (inputElement) {
    inputElement.checked = true;
  }

  // Si el modo es 'light', 'dark' o 'system'
  if (modes[mode]) {
    modes[mode]();
  } else {
    console.error('Modo no válido. Usa "light", "dark" o "system".');
    return;
  }
}

// Al iniciar la app
(function () {
  const saved = localStorage.getItem('theme');

  if (saved === 'light') setTheme('light');
  else if (saved === 'dark') setTheme('dark');
  else setTheme('system');
})();


window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
  if (localStorage.getItem('theme') === 'system') {
    setTheme('system');
  }
});

document.getElementById('logout-button')?.addEventListener('click', function() {
  fetch('/api/logout', {
      method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        window.location.href = '/login'; // Redirigir al login
      } else {
        alert(data.message);
      }
    })
    .catch(err => {
      console.error('Error al cerrar sesión:', err);
      alert('Error al cerrar sesión. Por favor, intenta de nuevo.');
    });
});