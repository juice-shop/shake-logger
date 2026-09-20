<?php

$logger = "/tmp/logger.txt";

if (array_key_exists("input", $_REQUEST)) {
    file_put_contents($logger, 'IP: ' . $_SERVER['REMOTE_ADDR'] . ', Date: ' . date('Y-m-d H:i:s', time()) . ", Text: " . $_REQUEST['input'] . "\n", FILE_APPEND);
}

$raw   = @file_get_contents($logger) ?: '';
$lines = array_values(array_filter(explode("\n", $raw)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="5">
<title>[ SHAKE_LOGGER :: ACCESS MONITOR ]</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  html { overflow-x: hidden; }

  body {
    background: #000;
    color: #00ff41;
    font-family: 'Share Tech Mono', 'Courier New', monospace;
    font-size: 13px;
    min-height: 100vh;
    padding: 24px 20px;
    overflow-x: hidden;
  }

  /* Matrix rain canvas sits behind everything */
  #matrix-rain {
    position: fixed;
    inset: 0;
    z-index: 0;
    opacity: 0.12;
    pointer-events: none;
  }

  /* Subtle moving scanline */
  body::after {
    content: '';
    position: fixed;
    inset: 0;
    background: repeating-linear-gradient(
      0deg,
      transparent,
      transparent 2px,
      rgba(0, 0, 0, 0.08) 2px,
      rgba(0, 0, 0, 0.08) 4px
    );
    pointer-events: none;
    z-index: 100;
  }

  /* Slow horizontal sweep */
  body::before {
    content: '';
    position: fixed;
    left: 0; top: -4px;
    width: 100%; height: 4px;
    background: linear-gradient(transparent, rgba(0,255,65,0.18), transparent);
    animation: sweep 7s linear infinite;
    pointer-events: none;
    z-index: 101;
  }
  @keyframes sweep { to { top: 100vh; } }

  .terminal {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 960px;
    margin: 0 auto;
  }

  /* ── Header ─────────────────────────────────────────────── */
  .hdr {
    border: 1px solid #00ff41;
    box-shadow: 0 0 12px rgba(0,255,65,.25), inset 0 0 30px rgba(0,255,65,.03);
    padding: 16px 20px 12px;
    margin-bottom: 16px;
  }

  .hdr-label {
    font-size: 10px;
    letter-spacing: .15em;
    color: #007a1f;
    margin-bottom: 10px;
  }

  .hdr-title {
    font-size: 22px;
    letter-spacing: .08em;
    color: #00ff41;
    text-shadow: 0 0 12px #00ff41, 0 0 24px #00ff4166;
  }

/* ── Log table ───────────────────────────────────────────── */
  .log-box {
    border: 1px solid #003900;
    background: rgba(0, 15, 0, 0.45);
  }

  .log-title {
    background: #001200;
    border-bottom: 1px solid #003900;
    padding: 6px 14px;
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #00c830;
  }

  .dot-live {
    color: #00ff41;
    text-shadow: 0 0 6px #00ff41;
    animation: blink 1.1s step-end infinite;
  }
  @keyframes blink { 50% { opacity: 0; } }

  .log-entry {
    display: grid;
    grid-template-columns: 38px 14px minmax(0, 1fr);
    gap: 0 10px;
    align-items: baseline;
    padding: 5px 14px;
    border-bottom: 1px solid #001600;
    transition: background .15s;
  }
  .log-entry:last-child { border-bottom: none; }
  .log-entry:hover { background: rgba(0,255,65,.04); }

  .ln   { color: #1a4d1a; text-align: right; user-select: none; font-size: 11px; }
  .pmt  { color: #006614; }
  .row  { display: block; word-break: break-all; overflow-wrap: anywhere; min-width: 0; }

  .badge-ip   { color: #00ffcc; text-shadow: 0 0 5px #00ffcc88; white-space: nowrap; margin-right: 10px; }
  .badge-date { color: #007a33; white-space: nowrap; margin-right: 10px; }
  .badge-text { color: #00ff41; }

  .empty {
    padding: 28px;
    text-align: center;
    color: #003300;
    letter-spacing: .1em;
  }

  /* ── Footer ──────────────────────────────────────────────── */
  .foot {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #004d15;
  }
  .cursor::after { content: '_'; animation: blink 1s step-end infinite; }
</style>
</head>
<body>
<canvas id="matrix-rain"></canvas>

<div class="terminal">

  <div class="hdr">
    <div class="hdr-label">// INTRUSION CAPTURE SYSTEM :: BUILD 0x1A4F</div>
    <div class="hdr-title">[ SHAKE_LOGGER ]</div>
  </div>

  <div class="log-box">
    <div class="log-title">
      <span>&#9492;&#9472; ACCESS_LOG <?= $logger ?> [<?= count($lines) ?> entries]</span>
      <span class="dot-live">&#9632; LIVE</span>
    </div>

    <?php if (empty($lines)): ?>
      <div class="empty">-- NO DATA CAPTURED YET --</div>
    <?php else: ?>
      <?php foreach ($lines as $idx => $line):
        $n = $idx + 1;
        preg_match('/IP:\s*([\d.:a-f]+),\s*Date:\s*([\d\- :]+),\s*Text:\s*(.*)/i', $line, $m);
      ?>
      <div class="log-entry">
        <span class="ln"><?= str_pad($n, 3, '0', STR_PAD_LEFT) ?></span>
        <span class="pmt">&gt;</span>
        <span class="row">
          <?php if ($m): ?>
            <span class="badge-ip">IP:<?= htmlspecialchars($m[1]) ?></span>
            <span class="badge-date">[<?= htmlspecialchars(trim($m[2])) ?>]</span>
            <span class="badge-text">MSG:<?= htmlspecialchars($m[3]) ?></span>
          <?php else: ?>
            <span class="badge-text"><?= htmlspecialchars($line) ?></span>
          <?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="foot">
    <span><?= count($lines) ?> RECORD(S) &nbsp;|&nbsp; NEXT REFRESH IN 5s</span>
    <span class="cursor">MONITORING</span>
  </div>

</div>

<script>
(function () {
  const canvas = document.getElementById('matrix-rain');
  const ctx    = canvas.getContext('2d');
  const FONT   = 14;
  const CHARS  = 'アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホ' +
                 'マミムメモヤユヨラリルレロワヲン0123456789ABCDEF<>{}[]|/\\';

  let cols, drops;

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
    cols  = Math.floor(canvas.width / FONT);
    drops = Array.from({ length: cols }, () => Math.floor(Math.random() * -50));
  }

  function tick() {
    ctx.fillStyle = 'rgba(0,0,0,0.045)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.font = FONT + 'px monospace';
    for (let i = 0; i < cols; i++) {
      const ch = CHARS[Math.floor(Math.random() * CHARS.length)];
      const y  = drops[i] * FONT;
      ctx.fillStyle = drops[i] < 2 ? '#afffcf' : '#00ff41';
      ctx.fillText(ch, i * FONT, y);
      if (y > canvas.height && Math.random() > 0.975) drops[i] = 0;
      drops[i]++;
    }
  }

  resize();
  window.addEventListener('resize', resize);
  setInterval(tick, 45);
})();
</script>
</body>
</html>
