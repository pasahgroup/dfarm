<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Palatial Experiences</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Raleway:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --accent: #6B8E23;        /* Terracotta red */
      --accent-hover: #6B8E23;  /* Olive green */
      /*--text: #2E2E2E;*/
      /*--text-muted: #7A7A7A;    /* Neutral gray */

      --text: #f7f8f5;

       --text-muted: #fff;    /* Neutral gray */
      --bg-light: #FAF3E0;      /* Sand beige background */
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Raleway', sans-serif;
      background: var(--bg-light);
      color: var(--text);
      min-height: 100vh;
      padding: 0;
      position: relative;
      overflow-x: hidden;
    }

    /* ---------------- BACKGROUND IMAGE LAYER ---------------- */
    .hero-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.9;

      /* ⭐ PLACE YOUR BACKGROUND IMAGE HERE ⭐ */
      background-image: url("upload/bgg.png");
    }

    /* ---------------- NAVIGATION / CONTACT ---------------- */
    .nav {
      width: 100%;
      padding: 1.2rem 2rem;
      display: flex;
      justify-content: center;
      position: absolute;
      top: 0;
      z-index: 10;
    }

    .nav-inner {
      width: min(1100px, 92vw);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-logo {
      font-family: 'Cinzel', serif;
      font-size: 1.4rem;
      color: var(--accent);
      text-decoration: none;
    }

    .nav-contacts {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      color: var(--text-muted);
      font-size: 0.95rem;
    }

    .contact-label {
      font-weight: 700;
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0.2rem;
      color: var(--accent);
    }

    /* ---------------- HERO ---------------- */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 4rem 1rem;
    }

    h1 {
      font-family: 'Cinzel', serif;
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--accent);
    }

    p {
      font-size: 1.2rem;
      max-width: 600px;
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    /* ---------------- BUTTONS ---------------- */
    .btn {
      font-family: 'Raleway', sans-serif;
      font-weight: 500;
      font-size: 1rem;
      padding: 0.4rem 2rem;
      margin: 0.5rem;
      border-radius: 12px;

      border: 2px solid var(--accent);
      /*background: transparent;*/
      color: var(--accent);

      transition: all 0.25s ease;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(164, 74, 63, 0.3);
    }

    .btn:hover {
      background-color: var(--accent-hover);
      color: #fff;
      transform: translateY(-3px);
    }

    .btn:active {
      transform: translateY(0);
    }

    .footer {
      margin-top: 3rem;
      font-size: 0.9rem;
      color: var(--text-muted);
      opacity: 0.7;
    }
  </style>
</head>

<body>

  <!-- BACKGROUND IMAGE LAYER -->
  <div class="hero-bg"></div>

  <!-- NAVIGATION WITH CONTACT -->
  <nav class="nav">
    <div class="nav-inner">
      <a href="#" class="nav-logo">Palatial</a>

      <div class="nav-contacts">
        <span class="contact-label">Contact</span>
        <span>Email: info@palatialtours.com</span>
        <span>Phone: +255 700 000 000</span>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <main class="hero">
    <h1>Palatial Coastal Escapes</h1>

    <p>
      Where Coastal Beauty Meets Palatial Luxury—crafted for unforgettable holidays,
      enriching tours, and moments of true togetherness.
    </p>

    <div>
      <button class="btn" onclick="location.href='{{ route('palatial') }}'">Palatial Holiday Entertainment</button>
      <button class="btn" onclick="location.href='https://palatialtours.com'">Palatial Tours</button>
    </div>

    <div class="footer">© 2026 Palatial Experiences. All rights reserved.</div>
  </main>

</body>
</html>