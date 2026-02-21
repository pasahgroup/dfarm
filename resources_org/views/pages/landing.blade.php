<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Palatial Experiences</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Raleway:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-overlay: rgba(0, 0, 0, 0.35);
      --text: #fff;
      --accent: #f5e6c8;
      --accent-text: #4a321a;
      --btn-hover: #e9d7ae;
      --shadow: rgba(0, 0, 0, 0.35);
    }

    * { box-sizing: border-box; }
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Raleway', sans-serif;
      color: var(--text);
      background: #000;
    }

    /* ---------------- NAVIGATION ---------------- */
    .nav {
      position: absolute;
      top: 0;
      width: 100%;
      padding: 1.2rem 2rem;
      z-index: 10;
      display: flex;
      justify-content: center;
    }

    .nav-inner {
      width: min(1100px, 92vw);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      color: var(--accent);
      text-decoration: none;
      text-shadow: 0 2px 10px var(--shadow);
    }

    .nav-contacts {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 0.25rem;
      color: var(--accent);
      font-size: 0.95rem;
      text-shadow: 0 2px 10px var(--shadow);
    }

    .contact-label {
      font-weight: 700;
      font-size: 1rem;
      color: var(--accent);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0.2rem;
    }

    /* ---------------- HERO SECTION ---------------- */
    .hero {
      position: relative;
      min-height: 100vh;
      display: grid;
      place-items: center;
      overflow: hidden;
      isolation: isolate;
    }

    .content {
      width: min(1100px, 92vw);
      margin: 0 auto;
      text-align: center;
      padding: 4rem 1rem 3rem;
    }

    .brand {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.25rem, 2.5vw, 1.5rem);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--accent);
      text-shadow: 0 2px 10px var(--shadow);
      margin-bottom: 0.75rem;
    }

    .title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 6vw, 3.25rem);
      font-weight: 700;
      line-height: 1.1;
      margin: 0.25rem 0 1.25rem;
      text-shadow: 0 4px 18px var(--shadow);
    }

    .subtitle {
      font-size: clamp(1rem, 2.5vw, 1.25rem);
      opacity: 0.95;
      max-width: 60ch;
      margin: 0 auto 2rem;
      text-shadow: 0 2px 12px var(--shadow);
    }

    .cta {
      display: inline-flex;
      gap: 1rem;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      margin-top: 1rem;
      filter: drop-shadow(0 10px 24px var(--shadow));
    }

    /* ---------------- BUTTON WITH BORDER ---------------- */
    .btn {
      font-family: 'Raleway', sans-serif;
      font-weight: 700;
      padding: 0.95rem 1.35rem;
      border-radius: 14px;
      border: 2px solid var(--accent);
      background: transparent;
      color: var(--accent);
      font-size: clamp(0.95rem, 2.2vw, 1.05rem);
      transition: all 180ms ease;
      box-shadow: 0 10px 24px var(--shadow);
    }

    .btn:hover {
      background: rgba(245, 230, 200, 0.15);
      transform: translateY(-2px);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn:focus-visible {
      outline: 3px solid #fff;
      outline-offset: 3px;
    }

    .footnote {
      margin-top: 2rem;
      font-size: 0.95rem;
      opacity: 0.9;
      text-shadow: 0 2px 10px var(--shadow);
    }

    /* ---------------- BACKGROUND IMAGE ---------------- */
    body {
      background-image: url("upload/bgg.png");
      background-repeat: no-repeat;
      background-size: cover;     /* FULL WIDTH */
      background-position: center;
      background-color: #000;
    }

body {
  font-family: 'Raleway', sans-serif;
}

.title, .brand, .nav-logo {
  font-family: 'Cinzel', serif;
}
  </style>
</head>

<body class="body">

  <!-- NAVIGATION -->
  <nav class="nav">
    <div class="nav-inner">
      <a href="#" class="nav-logo">Palatial</a>

      <div class="nav-contacts">
        <span class="contact-label">Contact</span>
        <span>Email: info@palatialexperiences.com</span>
        <span>Phone: +255 700 000 000</span>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <main class="hero" role="main" aria-label="Palatial coastal sunset landing">
    <section class="content">
      <div class="brand">Palatial Experiences</div>

      <h1 class="title">Palatial Coastal Escapes</h1>

      <p class="subtitle">
        Where Coastal Beauty Meets Palatial Luxury—crafted for unforgettable holidays,
        enriching tours, and moments of true togetherness.
      </p>

      <div class="cta" aria-label="Primary actions">
        
         <a class="btn" type="submit" href="{{ route('palatial') }}">Palatial Holiday Entertainment</a>
        <button class="btn" type="button" onclick="location.href='https://palatialtours.com'">
          Palatial Tours
        </button>
      </div>

      <p class="footnote">
        A serene family moment by the coast—bathed in a golden sunset, framed by a softly swaying palm tree.
      </p>
    </section>
  </main>

</body>
</html>