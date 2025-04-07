// toogle dark theme
const html = document.documentElement;

function setTheme(mode) {
  const modes = {
    light: () => {
      html.classList.remove('dark');
      localStorage.setItem('theme', 'light');
    },
    dark: () => {
      html.classList.add('dark');
      localStorage.setItem('theme', 'dark');
    },
    system: () => {
      localStorage.setItem('theme', 'system');
      if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.classList.add('dark');
      } else {
        html.classList.remove('dark');
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