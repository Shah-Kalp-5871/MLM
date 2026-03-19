<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&display=swap" rel="stylesheet"/>
<style>
    /* Scope everything to avoid breaking other styles, though these are mostly specific tag classes */
    #global-preloader {
      position: fixed; inset: 0; z-index: 99999;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      gap: 48px;
      background: #0a0f1d;
    }

    /* ── AMBIENT ORBS ── */
    #global-preloader .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(100px);
      pointer-events: none;
    }
    #global-preloader .orb-l {
      width: 50vmax; height: 50vmax;
      background: radial-gradient(circle, rgba(147,51,234,.3), transparent 65%);
      top: -20%; left: -20%;
      animation: drift 8s ease-in-out infinite alternate;
    }
    #global-preloader .orb-r {
      width: 45vmax; height: 45vmax;
      background: radial-gradient(circle, rgba(99,102,241,.25), transparent 65%);
      bottom: -20%; right: -20%;
      animation: drift 10s ease-in-out infinite alternate-reverse;
    }

    /* ── BRAND BLOCK ── */
    #global-preloader .brand {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0;
    }

    #global-preloader .wordmark {
      font-family: 'Orbitron', sans-serif;
      font-weight: 900;
      font-size: clamp(2.4rem, 8vw, 5.5rem);
      letter-spacing: .06em;
      line-height: 1;
      opacity: 0;
      animation: wordReveal 1s cubic-bezier(0.16,1,0.3,1) 0.4s forwards;
    }

    #global-preloader .elite {
      background: linear-gradient(110deg, #e2d9f3 0%, #c084fc 40%, #9333ea 100%);
      -webkit-background-clip: text; background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    #global-preloader .matrix {
      background: linear-gradient(110deg, #a5b4fc 0%, #6366f1 50%, #4f46e5 100%);
      -webkit-background-clip: text; background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    #global-preloader .pro-wrap {
      display: inline-block;
      position: relative;
    }
    #global-preloader .pro {
      background: linear-gradient(110deg, #34d399 0%, #10b981 60%, #059669 100%);
      -webkit-background-clip: text; background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    #global-preloader .pro-badge {
      position: absolute;
      top: .1em; right: -.55em;
      font-size: .22em;
      font-family: 'Orbitron', sans-serif;
      font-weight: 900;
      letter-spacing: .15em;
      color: #10b981;
      opacity: 0;
      animation: badgePop 0.5s cubic-bezier(0.34,1.56,0.64,1) 1.1s forwards;
    }

    #global-preloader .glow-bar {
      width: 0%;
      height: 2px;
      margin-top: 10px;
      background: linear-gradient(90deg, #9333ea, #6366f1, #10b981);
      border-radius: 999px;
      box-shadow: 0 0 14px rgba(147,51,234,.7), 0 0 28px rgba(99,102,241,.4);
      animation: barExpand 0.9s cubic-bezier(0.16,1,0.3,1) 0.9s forwards;
    }

    /* ── TAGLINE ── */
    #global-preloader .tagline {
      font-family: 'Orbitron', sans-serif;
      font-size: clamp(.55rem, 1.6vw, .8rem);
      font-weight: 400;
      letter-spacing: .38em;
      color: rgba(148,163,184,.5);
      text-transform: uppercase;
      opacity: 0;
      animation: fadeUp 0.8s ease-out 1.3s forwards;
    }

    /* ── LOADER DOTS ── */
    #global-preloader .dots {
      display: flex; gap: 10px;
      opacity: 0;
      animation: fadeUp 0.6s ease-out 1.6s forwards;
    }
    #global-preloader .dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: #6366f1;
    }
    #global-preloader .dot:nth-child(1) { animation: dotPulse 1.2s ease-in-out 1.7s infinite; }
    #global-preloader .dot:nth-child(2) { animation: dotPulse 1.2s ease-in-out 1.9s infinite; }
    #global-preloader .dot:nth-child(3) { animation: dotPulse 1.2s ease-in-out 2.1s infinite; }

    /* ═══════════ KEYFRAMES ═══════════ */
    @keyframes fadeOutPreloader {
      to { opacity: 0; visibility: hidden; pointer-events: none; }
    }
    @keyframes wordReveal {
      from { opacity: 0; transform: translateY(20px) scale(.97); filter: blur(8px); }
      to   { opacity: 1; transform: translateY(0)    scale(1);   filter: blur(0);  }
    }
    @keyframes badgePop {
      from { opacity: 0; transform: scale(.4) translateY(4px); }
      to   { opacity: 1; transform: scale(1)  translateY(0);   }
    }
    @keyframes barExpand {
      to { width: 100%; }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0);   }
    }
    @keyframes dotPulse {
      0%,100% { transform: scale(1);   opacity: .35; background: #6366f1; }
      50%     { transform: scale(1.6); opacity: 1;   background: #9333ea;
                box-shadow: 0 0 10px rgba(147,51,234,.8); }
    }
    @keyframes drift {
      from { transform: translate(0, 0); }
      to   { transform: translate(3%, 4%); }
    }
</style>

<div id="global-preloader">
  <div class="orb orb-l"></div>
  <div class="orb orb-r"></div>

  <div class="brand">
    <div class="wordmark">
      <span class="elite">Elite</span><span class="matrix">Matrix</span><span class="pro-wrap"><span class="pro">Pro</span><span class="pro-badge">™</span></span>
    </div>
    <div class="glow-bar"></div>
  </div>

  <p class="tagline">Premium Investment Network</p>

  <div class="dots">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>
</div>

<script>
    // Ensure the preloader fades out when the page is fully loaded or after 2.2s (to let the beautiful animation play out a bit)
    window.addEventListener('load', function() {
        setTimeout(() => {
            const preloader = document.getElementById('global-preloader');
            if (preloader) {
                preloader.style.animation = 'fadeOutPreloader 0.7s ease-in-out forwards';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 700);
            }
        }, 2200); // 2200ms minimum delay to show off the initial text animation if the page loads instantly
    });

    // Absolute fallback: If 'load' event doesn't fire, remove it after 6 seconds to prevent hanging
    setTimeout(() => {
        const preloader = document.getElementById('global-preloader');
        if (preloader && preloader.style.display !== 'none') {
            preloader.style.animation = 'fadeOutPreloader 0.7s ease-in-out forwards';
            setTimeout(() => preloader.style.display = 'none', 700);
        }
    }, 6000);
</script>
