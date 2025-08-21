if ('serviceWorker' in navigator) {
  window.addEventListener('load', async () => {
    try {
      const reg = await navigator.serviceWorker.register('/sw.js', { scope: '/' });
      // optional: listen for updates
      if (reg.waiting) reg.waiting.postMessage({ type: 'SKIP_WAITING' });
      reg.addEventListener('updatefound', () => {
        const sw = reg.installing;
        if (!sw) return;
        sw.addEventListener('statechange', () => {
          if (sw.state === 'installed' && navigator.serviceWorker.controller) {
            // app updated — you can toast a “Refresh to update” here
            console.log('PWA updated. Refresh for the latest version.');
          }
        });
      });
    } catch (e) {
      console.warn('SW registration failed', e);
    }
  });
}
