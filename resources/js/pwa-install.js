let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e; // show your own “Install” button
  const btn = document.querySelector('[data-pwa-install]');
  if (btn) btn.style.display = 'inline-flex';
});

async function triggerInstall() {
  if (!deferredPrompt) return;
  deferredPrompt.prompt();
  const { outcome } = await deferredPrompt.userChoice;
  console.log('A2HS outcome:', outcome);
  deferredPrompt = null;
  const btn = document.querySelector('[data-pwa-install]');
  if (btn) btn.style.display = 'none';
}

window.addEventListener('load', () => {
  const btn = document.querySelector('[data-pwa-install]');
  if (btn) btn.addEventListener('click', triggerInstall);
});
