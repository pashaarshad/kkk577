// Mobile & Desktop Responsive REM Scaler with strict desktop viewport capping
(function flexible(window, document) {
  const docEl = document.documentElement

  function setRemUnit() {
    let clientWidth = docEl.clientWidth || window.innerWidth
    if (!clientWidth) return

    // Cap the scaling on desktop / wide screens to standard mobile device width (414px)
    // This prevents gigantic elements on desktop monitors (1920px, 1440px)
    if (clientWidth > 540) {
      clientWidth = 414
    }

    // Standard 10-column rem system (matches rootValue: 41 in vite.config.js)
    const rem = clientWidth / 10
    docEl.style.fontSize = rem + 'px'
  }

  setRemUnit()

  // Recalculate on window resize and page orientation change
  window.addEventListener('resize', setRemUnit)
  window.addEventListener('orientationchange', setRemUnit)
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
      setRemUnit()
    }
  })
})(window, document)
