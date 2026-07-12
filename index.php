<?php
declare(strict_types=1);

$siteName = 'Kainocor';
$tagline  = 'Novelty for Antiquity';

$navigation = [
    'Home' => 'index.php',
    'About' => [
        'About Kainocor'       => 'about.php',
        'Mission and Purpose'  => 'mission.php',
        'History'              => 'history.php',
    ],
    'Ancient World' => [
        'Ancient Greece' => 'greece.php',
        'Ancient Rome'   => 'rome.php',
        'Ancient Egypt'  => 'egypt.php',
    ],
    'Culture' => [
        'Literature' => 'literature.php',
        'Mythology'  => 'mythology.php',
        'Art'        => 'art.php',
    ],
    'Contact' => 'contact.php',
];

$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function isActivePage(string $url, string $currentPage): bool
{
    return basename($url) === $currentPage;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Kainocor: Novelty for Antiquity."
    >

    <title><?= escape($siteName) ?> | <?= escape($tagline) ?></title>

    <!-- Antique-style fonts. Remove these links if you want local fonts only. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --ink: #3f2418;
            --deep-ink: #27150f;
            --brown: #6f3b24;
            --brown-light: #9a6846;
            --parchment: #ddc797;
            --parchment-light: #f1e2b9;
            --parchment-dark: #b89b65;
            --sidebar-width: 280px;
            --border: rgba(76, 43, 27, 0.7);
            --shadow: rgba(32, 18, 11, 0.35);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Libre Baskerville", Georgia, serif;

            /*
             * Replace this path with your repeating parchment texture.
             * Example:
             * assets/images/parchment-repeat.jpg
             */
            background-color: var(--parchment);
            background-image: url("assets/images/parchment-repeat.jpg");
            background-repeat: repeat;
            background-position: top left;
            background-attachment: scroll;
        }

        a {
            color: inherit;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .site-shell {
            min-height: 100vh;
        }

        /* ---------------------------------------------------------
           HERO / BANNER
        --------------------------------------------------------- */

        .hero {
            position: relative;
            width: 100%;
            min-height: 430px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            overflow: hidden;

            /*
             * Replace with your wide parchment collage banner image.
             */
            background-color: #c8ad75;
            background-image: url("assets/images/kainocor-hero.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;

            border-bottom: 5px solid var(--deep-ink);
            box-shadow:
                inset 0 -18px 30px rgba(39, 21, 15, 0.14),
                0 4px 14px var(--shadow);
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(
                    to bottom,
                    rgba(255, 246, 221, 0.04),
                    rgba(72, 39, 23, 0.08)
                );
        }

        .logo-card {
            position: relative;
            z-index: 1;
            width: min(760px, 88%);
            min-height: 245px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 42px 56px;

            /*
             * Replace with a blank torn parchment image.
             * The text below will appear over it.
             */
            background-color: rgba(240, 221, 177, 0.96);
            background-image: url("assets/images/parchment-card.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100% 100%;

            filter: drop-shadow(0 12px 14px rgba(42, 23, 14, 0.34));
        }

        .site-title {
            margin: 0;
            color: #74391e;
            font-family: "Cinzel", Georgia, serif;
            font-size: clamp(3rem, 8vw, 6.5rem);
            font-weight: 500;
            letter-spacing: 0.02em;
            line-height: 0.95;
            text-shadow: 0 2px 1px rgba(255, 244, 215, 0.65);
        }

        .site-tagline {
            margin: 26px 0 0;
            color: #5b2e1c;
            font-family: "Cinzel", Georgia, serif;
            font-size: clamp(1rem, 2.4vw, 1.75rem);
            font-weight: 600;
            letter-spacing: 0.13em;
            text-transform: uppercase;
        }

        /* ---------------------------------------------------------
           MOBILE SIDEBAR BUTTON
        --------------------------------------------------------- */

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1200;
            width: 48px;
            height: 48px;
            border: 2px solid #e0c48d;
            border-radius: 4px;
            color: #f4e4bd;
            background: rgba(45, 24, 15, 0.94);
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
        }

        .sidebar-toggle span,
        .sidebar-toggle::before,
        .sidebar-toggle::after {
            content: "";
            display: block;
            width: 23px;
            height: 2px;
            margin: 5px auto;
            background: currentColor;
        }

        /* ---------------------------------------------------------
           MAIN LAYOUT
        --------------------------------------------------------- */

        .page-layout {
            display: grid;
            grid-template-columns: var(--sidebar-width) minmax(0, 1fr);
            align-items: stretch;
            width: min(1500px, 100%);
            margin: 0 auto;
        }

        /* ---------------------------------------------------------
           WIKI SIDEBAR
        --------------------------------------------------------- */

        .wiki-sidebar {
            position: relative;
            padding: 26px 18px 42px;
            color: #f3e4bf;
            background:
                linear-gradient(
                    rgba(40, 22, 15, 0.96),
                    rgba(53, 28, 18, 0.96)
                ),
                url("assets/images/dark-parchment.jpg");
            background-repeat: repeat;
            border-right: 4px double #9b7549;
            box-shadow: 7px 0 18px rgba(45, 24, 15, 0.2);
        }

        .sidebar-inner {
            position: sticky;
            top: 18px;
        }

        .sidebar-heading {
            margin: 0 0 20px;
            padding: 0 0 13px;
            color: #f2dca7;
            font-family: "Cinzel", Georgia, serif;
            font-size: 1.3rem;
            letter-spacing: 0.08em;
            text-align: center;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(226, 195, 137, 0.55);
        }

        .wiki-nav {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .wiki-nav > li {
            margin: 0 0 8px;
        }

        .wiki-nav a,
        .nav-section-button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 12px;
            color: #f3e3bc;
            text-decoration: none;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            text-align: left;
            transition:
                background-color 160ms ease,
                border-color 160ms ease,
                color 160ms ease;
        }

        .wiki-nav a:hover,
        .wiki-nav a:focus-visible,
        .nav-section-button:hover,
        .nav-section-button:focus-visible {
            color: #fff4d4;
            background: rgba(181, 128, 71, 0.18);
            border-color: rgba(227, 190, 125, 0.46);
            outline: none;
        }

        .wiki-nav a.active {
            color: #fff5d7;
            background: rgba(176, 113, 54, 0.3);
            border-color: rgba(232, 194, 124, 0.75);
        }

        .nav-section-button {
            font-weight: 700;
        }

        .nav-arrow {
            flex: 0 0 auto;
            font-size: 0.85rem;
            transition: transform 180ms ease;
        }

        .nav-section-button[aria-expanded="true"] .nav-arrow {
            transform: rotate(90deg);
        }

        .submenu {
            margin: 3px 0 9px 14px;
            padding: 4px 0 4px 9px;
            list-style: none;
            border-left: 1px solid rgba(220, 187, 129, 0.38);
        }

        .submenu[hidden] {
            display: none;
        }

        .submenu a {
            padding: 9px 10px;
            font-size: 0.91rem;
        }

        .sidebar-footer {
            margin-top: 34px;
            padding-top: 18px;
            font-size: 0.76rem;
            line-height: 1.6;
            text-align: center;
            color: rgba(243, 227, 188, 0.72);
            border-top: 1px solid rgba(226, 195, 137, 0.35);
        }

        /* ---------------------------------------------------------
           PAGE CONTENT
        --------------------------------------------------------- */

        .main-content {
            min-width: 0;
            padding: 48px clamp(24px, 5vw, 72px) 80px;

            /*
             * Same repeating background as the body.
             * This prevents any dark strip or gap from appearing.
             */
            background-color: transparent;
            background-image: none;
        }

        .content-card {
            width: min(970px, 100%);
            margin: 0 auto 32px;
            padding: clamp(26px, 5vw, 52px);
            background:
                linear-gradient(
                    rgba(244, 229, 191, 0.91),
                    rgba(228, 204, 154, 0.91)
                ),
                url("assets/images/parchment-card-texture.jpg");
            background-repeat: repeat;
            border: 1px solid rgba(92, 54, 32, 0.58);
            outline: 1px solid rgba(245, 226, 184, 0.72);
            outline-offset: -7px;
            box-shadow:
                0 12px 28px rgba(44, 25, 15, 0.24),
                inset 0 0 35px rgba(92, 54, 32, 0.1);
        }

        .content-card h2,
        .content-card h3 {
            font-family: "Cinzel", Georgia, serif;
            color: #5d2d1c;
        }

        .content-card h2 {
            margin-top: 0;
            font-size: clamp(1.75rem, 4vw, 2.8rem);
            text-align: center;
        }

        .content-card h2::after {
            content: "";
            display: block;
            width: 90px;
            height: 2px;
            margin: 17px auto 26px;
            background:
                linear-gradient(
                    to right,
                    transparent,
                    #7a462c,
                    transparent
                );
        }

        .content-card p {
            line-height: 1.85;
        }

        .antique-divider {
            width: min(470px, 80%);
            height: 18px;
            margin: 34px auto;
            position: relative;
        }

        .antique-divider::before,
        .antique-divider::after {
            content: "";
            position: absolute;
            top: 8px;
            width: calc(50% - 22px);
            height: 1px;
            background: var(--brown-light);
        }

        .antique-divider::before {
            left: 0;
        }

        .antique-divider::after {
            right: 0;
        }

        .antique-divider span {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            color: var(--brown);
            font-size: 1.25rem;
        }

        .link-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 30px;
        }

        .feature-link {
            display: block;
            min-height: 145px;
            padding: 24px 20px;
            text-align: center;
            text-decoration: none;
            background: rgba(244, 228, 187, 0.55);
            border: 1px solid rgba(106, 61, 36, 0.55);
            box-shadow: inset 0 0 22px rgba(92, 54, 32, 0.09);
            transition:
                transform 160ms ease,
                background-color 160ms ease,
                box-shadow 160ms ease;
        }

        .feature-link:hover,
        .feature-link:focus-visible {
            transform: translateY(-3px);
            background: rgba(250, 237, 205, 0.78);
            box-shadow:
                0 8px 16px rgba(52, 28, 17, 0.18),
                inset 0 0 22px rgba(92, 54, 32, 0.09);
            outline: none;
        }

        .feature-link strong {
            display: block;
            margin-bottom: 10px;
            font-family: "Cinzel", Georgia, serif;
            color: #65331f;
        }

        .feature-link span {
            font-size: 0.86rem;
            line-height: 1.5;
        }

        .site-footer {
            padding: 22px;
            text-align: center;
            color: #ead7ad;
            background: #341c13;
            border-top: 4px double #a17b4b;
            font-size: 0.82rem;
        }

        /* ---------------------------------------------------------
           SIDEBAR BACKDROP
        --------------------------------------------------------- */

        .sidebar-backdrop {
            display: none;
        }

        /* ---------------------------------------------------------
           RESPONSIVE
        --------------------------------------------------------- */

        @media (max-width: 950px) {
            .hero {
                min-height: 350px;
                padding: 42px 18px;
            }

            .logo-card {
                min-height: 210px;
                padding: 35px 30px;
            }

            .page-layout {
                grid-template-columns: 235px minmax(0, 1fr);
            }

            .link-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            body.sidebar-open {
                overflow: hidden;
            }

            .sidebar-toggle {
                display: block;
            }

            .hero {
                min-height: 300px;
                padding: 55px 14px 35px;
            }

            .logo-card {
                width: 96%;
                min-height: 180px;
                padding: 30px 18px;
            }

            .site-title {
                font-size: clamp(2.6rem, 15vw, 4.5rem);
            }

            .site-tagline {
                margin-top: 18px;
                font-size: 0.9rem;
            }

            .page-layout {
                display: block;
            }

            .wiki-sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 1100;
                width: min(310px, 86vw);
                overflow-y: auto;
                transform: translateX(-105%);
                transition: transform 220ms ease;
                border-right-width: 3px;
            }

            body.sidebar-open .wiki-sidebar {
                transform: translateX(0);
            }

            .sidebar-inner {
                position: static;
                padding-top: 50px;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                z-index: 1000;
                background: rgba(20, 11, 7, 0.65);
            }

            body.sidebar-open .sidebar-backdrop {
                display: block;
            }

            .main-content {
                padding: 34px 14px 60px;
            }

            .content-card {
                padding: 28px 22px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>
<div class="site-shell">

    <button
        class="sidebar-toggle"
        id="sidebarToggle"
        type="button"
        aria-label="Open navigation"
        aria-controls="wikiSidebar"
        aria-expanded="false"
    >
        <span></span>
    </button>

    <header class="hero">
        <div class="logo-card">
            <h1 class="site-title"><?= escape($siteName) ?></h1>
            <p class="site-tagline"><?= escape($tagline) ?></p>
        </div>
    </header>

    <div class="page-layout">

        <aside
            class="wiki-sidebar"
            id="wikiSidebar"
            aria-label="Site navigation"
        >
            <div class="sidebar-inner">

                <h2 class="sidebar-heading">Contents</h2>

                <nav aria-label="Kainocor pages">
                    <ul class="wiki-nav">

                        <?php foreach ($navigation as $label => $destination): ?>

                            <?php if (is_array($destination)): ?>

                                <?php
                                $sectionId = 'section-' . preg_replace(
                                    '/[^a-z0-9]+/i',
                                    '-',
                                    strtolower($label)
                                );
                                ?>

                                <li>
                                    <button
                                        class="nav-section-button"
                                        type="button"
                                        aria-expanded="true"
                                        aria-controls="<?= escape($sectionId) ?>"
                                    >
                                        <span><?= escape($label) ?></span>
                                        <span class="nav-arrow" aria-hidden="true">▶</span>
                                    </button>

                                    <ul
                                        class="submenu"
                                        id="<?= escape($sectionId) ?>"
                                    >
                                        <?php foreach ($destination as $childLabel => $childUrl): ?>
                                            <li>
                                                <a
                                                    href="<?= escape($childUrl) ?>"
                                                    class="<?= isActivePage($childUrl, $currentPage) ? 'active' : '' ?>"
                                                >
                                                    <?= escape($childLabel) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>

                            <?php else: ?>

                                <li>
                                    <a
                                        href="<?= escape($destination) ?>"
                                        class="<?= isActivePage($destination, $currentPage) ? 'active' : '' ?>"
                                    >
                                        <?= escape($label) ?>
                                    </a>
                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </nav>

                <div class="sidebar-footer">
                    <p>
                        An exploration of antiquity, memory,
                        language, literature, and culture.
                    </p>
                </div>

            </div>
        </aside>

        <main class="main-content">

            <section class="content-card">
                <h2>Welcome to Kainocor</h2>

                <p>
                    Kainocor is a digital space devoted to the ancient world
                    and its continuing presence in modern culture. The site
                    brings together history, mythology, literature, art,
                    language, and the reception of antiquity.
                </p>

                <p>
                    The name reflects a meeting of the old and the new:
                    novelty shaped through antiquity, and antiquity
                    rediscovered through modern eyes.
                </p>

                <div class="antique-divider" aria-hidden="true">
                    <span>◆</span>
                </div>

                <div class="link-grid">
                    <a class="feature-link" href="greece.php">
                        <strong>Ancient Greece</strong>
                        <span>
                            Explore Greek history, literature,
                            philosophy, mythology, and art.
                        </span>
                    </a>

                    <a class="feature-link" href="rome.php">
                        <strong>Ancient Rome</strong>
                        <span>
                            Discover Roman society, politics,
                            language, architecture, and legacy.
                        </span>
                    </a>

                    <a class="feature-link" href="mythology.php">
                        <strong>Mythology</strong>
                        <span>
                            Read about gods, heroes, monsters,
                            traditions, and reinterpretations.
                        </span>
                    </a>
                </div>
            </section>

        </main>

    </div>

    <footer class="site-footer">
        &copy; <?= date('Y') ?> <?= escape($siteName) ?>.
        All rights reserved.
    </footer>

</div>

<div
    class="sidebar-backdrop"
    id="sidebarBackdrop"
    aria-hidden="true"
></div>

<script>
    (() => {
        "use strict";

        const body = document.body;
        const toggle = document.getElementById("sidebarToggle");
        const backdrop = document.getElementById("sidebarBackdrop");
        const sectionButtons = document.querySelectorAll(".nav-section-button");

        const setSidebarState = (isOpen) => {
            body.classList.toggle("sidebar-open", isOpen);
            toggle.setAttribute("aria-expanded", String(isOpen));
            toggle.setAttribute(
                "aria-label",
                isOpen ? "Close navigation" : "Open navigation"
            );
        };

        toggle?.addEventListener("click", () => {
            setSidebarState(!body.classList.contains("sidebar-open"));
        });

        backdrop?.addEventListener("click", () => {
            setSidebarState(false);
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                setSidebarState(false);
            }
        });

        sectionButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const targetId = button.getAttribute("aria-controls");
                const submenu = document.getElementById(targetId);

                if (!submenu) {
                    return;
                }

                const isExpanded =
                    button.getAttribute("aria-expanded") === "true";

                button.setAttribute(
                    "aria-expanded",
                    String(!isExpanded)
                );

                submenu.hidden = isExpanded;
            });
        });
    })();
</script>

</body>
</html>
