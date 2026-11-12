@php
    $customHtml = \App\Models\SiteSetting::valueFor('home_html');
    $customCss = \App\Models\SiteSetting::valueFor('home_css');
@endphp

@if($customHtml && !config('app.editor_mode'))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            html, body { overscroll-behavior-y: none; }
            {!! $customCss !!}
        </style>
        
        <!-- We need the basic styles for the partials to look correct if the user uses them in GrapesJS -->
        <style>
            .badge { padding: 0.65rem 0.9rem; border-radius: 999px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1); color: #f5efe6; text-decoration: none; }
            .flex-badge { display: inline-flex; align-items: center; gap: 0.5rem; }
            .badge-row { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
            .social-icon { display: block; width: 1rem; height: 1rem; }
            
            .card { padding: 2rem; border-radius: 24px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); }
            .card-date { display: flex; flex-direction: column; align-items: center; justify-content: center; width: 4.5rem; height: 4.5rem; border-radius: 16px; background: rgba(209, 95, 47, 0.1); color: #d15f2f; }
            .card-date .month { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }
            .card-date .day { font-size: 1.5rem; font-weight: 700; line-height: 1; margin-top: 0.125rem; }
            .shows-list { display: flex; flex-direction: column; gap: 1rem; }
            .shows-list .card { display: flex; gap: 2rem; padding: 1.5rem; align-items: center; border-radius: 20px; transition: all 0.2s ease; }
            .card-details { flex: 1; }
            .card-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem; }
            .card-header h3 { font-size: 1.25rem; font-weight: 600; margin: 0; color: #fff; }
            .card-meta { display: flex; gap: 0.75rem; color: rgba(247, 239, 231, 0.6); font-size: 0.9rem; align-items: center; }
            .card-desc { margin: 0.75rem 0 0; font-size: 0.95rem; color: rgba(247, 239, 231, 0.8); line-height: 1.5; }
            
            .field { display: flex; flex-direction: column; gap: 0.5rem; }
            .field label { font-size: 0.9rem; font-weight: 500; color: rgba(247, 239, 231, 0.9); }
            .field input, .field textarea { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 0.875rem 1rem; color: #fff; font-family: inherit; font-size: 1rem; transition: all 0.2s; }
            .field.full { grid-column: 1 / -1; }
            .booking-form { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
            .button { display: inline-flex; align-items: center; justify-content: center; min-height: 3.25rem; padding: 0.9rem 1.35rem; border-radius: 999px; font-weight: 600; font-size: 0.95rem; color: #fff; background: rgba(255, 255, 255, 0.1); border: none; cursor: pointer; }
            .button.primary { background: #d15f2f; color: #fff; }
        </style>
    </head>
    <body class="min-h-screen bg-[#060504] antialiased text-white" style="font-family: 'Instrument Sans', sans-serif;">
        @php
            $showsHtml = view('partials.front.shows', ['upcomingShows' => $upcomingShows])->render();
            $socialsHtml = view('partials.front.socials', ['socialLinks' => $socialLinks])->render();
            $bookingHtml = view('partials.front.booking')->render();
            
            $finalHtml = str_replace(
                ['[shows]', '[socials]', '[booking]'],
                [$showsHtml, $socialsHtml, $bookingHtml],
                $customHtml
            );
        @endphp
        {!! $finalHtml !!}
    </body>
    </html>
@else
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Grapes</title>
        <meta name="description" content="The Grapes official site, upcoming shows, and social links.">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Rye&display=swap');

            @font-face {
                font-family: 'Mandingo';
                src: url("{{ asset('fonts/MANDINGO.TTF') }}") format('truetype');
                font-display: swap;
            }

            :root {
                color-scheme: dark;
                --panel: rgba(24, 18, 14, 0.78);
                --panel-border: rgba(255, 255, 255, 0.1);
                --text: #f7efe7;
                --muted: #d7c5b3;
                --accent: #d15f2f;
                --accent-soft: #f0a56f;
                --accent-bright: #ffb15c;
            }

            * {
                box-sizing: border-box;
            }

            html, body {
                overscroll-behavior-y: none;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Montserrat', sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(209, 95, 47, 0.34), transparent 34%),
                    radial-gradient(circle at top right, rgba(240, 165, 111, 0.14), transparent 30%),
                    linear-gradient(135deg, #060504 0%, #120d0a 42%, #1b120d 100%);
            }

            .shell {
                position: relative;
                overflow: hidden;
                min-height: 100vh;
            }

            .shell::before,
            .shell::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                filter: blur(18px);
                opacity: 0.55;
                pointer-events: none;
            }

            .shell::before {
                width: 18rem;
                height: 18rem;
                left: -5rem;
                top: 4rem;
                background: rgba(209, 95, 47, 0.18);
            }

            .shell::after {
                width: 22rem;
                height: 22rem;
                right: -7rem;
                bottom: -5rem;
                background: rgba(240, 165, 111, 0.14);
            }

            .instrument-rail {
                display: none;
                position: fixed;
                top: 0;
                bottom: 0;
                width: clamp(6rem, 10vw, 8.5rem);
                z-index: 0;
                pointer-events: none;
                opacity: 0.92;
            }

            .instrument-rail.left {
                left: 0;
            }

            .instrument-rail.right {
                right: 0;
            }

            .instrument-item {
                position: absolute;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 4.75rem;
                height: 4.75rem;
                padding: 0.35rem;
                border-radius: 1.6rem;
                background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.08), rgba(24, 18, 14, 0.1) 42%, transparent 72%);
                border: none;
                box-shadow: none;
                color: #f7e7d1;
                backdrop-filter: none;
                opacity: 0.95;
            }

            .instrument-item img {
                width: 3.2rem;
                height: 3.2rem;
                object-fit: contain;
                filter: brightness(0) saturate(100%) invert(91%) sepia(18%) saturate(270%) hue-rotate(338deg) brightness(106%) contrast(94%) drop-shadow(0 0 0.45rem rgba(255, 177, 92, 0.18));
                opacity: 1;
            }

            .instrument-item.accent {
                color: var(--text);
            }

            .instrument-rail.left .instrument-item:nth-child(1) {
                top: 22%;
                left: 0.65rem;
                transform: rotate(-12deg);
            }

            .instrument-rail.left .instrument-item:nth-child(2) {
                top: 36%;
                left: 1.4rem;
                width: 5.1rem;
                height: 5.1rem;
                transform: rotate(8deg);
            }

            .instrument-rail.left .instrument-item:nth-child(3) {
                top: 56%;
                left: 0.8rem;
                transform: rotate(-7deg);
            }

            .instrument-rail.left .instrument-item:nth-child(4) {
                top: 73%;
                left: 1.5rem;
                width: 5.25rem;
                height: 5.25rem;
                transform: rotate(14deg);
            }

            .instrument-rail.right .instrument-item:nth-child(1) {
                top: 28%;
                right: 1rem;
                width: 5.05rem;
                height: 5.05rem;
                transform: rotate(11deg);
            }

            .instrument-rail.right .instrument-item:nth-child(2) {
                top: 46%;
                right: 0.7rem;
                transform: rotate(-9deg);
            }

            .instrument-rail.right .instrument-item:nth-child(3) {
                top: 66%;
                right: 1.35rem;
                width: 5.15rem;
                height: 5.15rem;
                transform: rotate(16deg);
            }

            @media (min-width: 1380px) {
                .instrument-rail {
                    display: block;
                }
            }

            .grid {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                gap: clamp(1.5rem, 3vw, 2.5rem);
                width: min(100%, 88rem);
                margin: 0 auto;
                padding: 0 clamp(1.1rem, 4vw, 2rem) 2rem;
                justify-items: center;
            }

            .hero,
            .aside {
                padding: 2rem;
                min-width: 0;
                width: min(100%, 72rem);
            }

            .hero {
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                gap: 1.1rem;
                padding: clamp(1rem, 1.8vw, 1.6rem);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 2.4rem;
                overflow: visible;
                text-align: left;
                align-items: flex-start;
                box-shadow: 0 30px 90px rgba(0, 0, 0, 0.38);
            }

            .hero-media {
                position: relative;
                width: 100%;
                margin-top: 0.45rem;
                border-radius: 2rem;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.08);
                background: #0a0705;
                box-shadow: 0 20px 56px rgba(0, 0, 0, 0.28);
            }

            .hero-title {
                position: absolute;
                left: 50%;
                top: 61%;
                transform: translate(-50%, -50%);
                z-index: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.12em;
                width: min(92%, 40rem);
                margin: 0;
                padding: 0;
                border: 0;
                background: transparent;
                color: #f6e8d7;
                font-family: 'Mandingo', 'Rye', serif;
                line-height: 0.86;
                text-transform: uppercase;
                text-align: center;
                text-shadow:
                    0 0 0.15rem rgba(0, 0, 0, 0.9),
                    0 0 1rem rgba(0, 0, 0, 0.55),
                    0 10px 28px rgba(0, 0, 0, 0.35);
            }

            .hero-title .wordmark-top {
                font-size: clamp(2.2rem, 5.6vw, 5.2rem);
                letter-spacing: 0.07em;
                transform: translateX(0.04em);
            }

            .hero-title .wordmark-bottom {
                font-size: clamp(2.2rem, 5.6vw, 5.2rem);
                letter-spacing: 0.07em;
                line-height: 0.86;
            }

            .hero-media img {
                display: block;
                width: 100%;
                height: min(56vw, 34rem);
                object-fit: cover;
                object-position: center 14%;
                filter: grayscale(1) contrast(1.05) brightness(0.92);
            }

            .hero-copy {
                width: 100%;
                max-width: none;
                margin-top: 0;
                padding: 1rem 1.1rem 1.1rem;
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 1.15rem;
                background: linear-gradient(180deg, rgba(10, 7, 5, 0.9), rgba(10, 7, 5, 0.8));
                box-shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
                backdrop-filter: blur(14px);
            }

            .eyebrow {
                margin: 0 0 1rem;
                text-transform: uppercase;
                letter-spacing: 0.22em;
                font-size: 0.78rem;
                color: #ffb86f;
            }

            h1 {
                margin: 0;
                font-family: 'Rye', serif;
                font-size: clamp(2.2rem, 4.1vw, 4.4rem);
                line-height: 0.96;
                letter-spacing: 0.01em;
                max-width: 14ch;
                text-wrap: balance;
                text-shadow: 0 4px 18px rgba(0, 0, 0, 0.42);
            }

            .lead {
                max-width: 40rem;
                margin: 1rem 0 0;
                font-size: clamp(0.95rem, 1.35vw, 1.02rem);
                line-height: 1.55;
                color: var(--muted);
            }

            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                margin-top: 1.25rem;
                justify-content: flex-start;
            }

            .field-error {
                color: #f87171;
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }

            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 3.25rem;
                padding: 0.9rem 1.35rem;
                border-radius: 999px;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-decoration: none;
                transition: transform 180ms ease, box-shadow 180ms ease, background 180ms ease;
            }

            .button:hover {
                transform: translateY(-1px);
            }

            .button.primary {
                color: #1b110b;
                background: linear-gradient(135deg, var(--accent-bright), var(--accent));
                box-shadow: 0 18px 36px rgba(209, 95, 47, 0.24);
            }

            .button.secondary {
                color: var(--text);
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid var(--panel-border);
            }

            .button.tertiary {
                color: var(--text);
                background: rgba(240, 165, 111, 0.1);
                border: 1px solid rgba(240, 165, 111, 0.28);
            }

            .stats {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
                margin-top: 2.5rem;
                width: 100%;
            }

            .stat {
                padding: 1rem 1.1rem;
                border-radius: 1.2rem;
                background: linear-gradient(180deg, rgba(20, 14, 10, 0.82), rgba(16, 11, 8, 0.76));
                border: 1px solid rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(12px);
            }

            .stat strong {
                display: block;
                font-size: 1.35rem;
                margin-bottom: 0.35rem;
            }

            .stat span {
                color: var(--muted);
                font-size: 0.92rem;
            }

            .aside {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(16rem, 1fr));
                align-content: start;
                gap: 1rem;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.045));
                border: 1px solid rgba(255, 255, 255, 0.06);
                border-radius: 2rem;
                backdrop-filter: blur(18px);
                justify-content: center;
            }

            .card {
                padding: 1.25rem;
                border-radius: 1.4rem;
                background: linear-gradient(180deg, rgba(26, 18, 13, 0.92), rgba(18, 12, 9, 0.9));
                border: 1px solid rgba(255, 255, 255, 0.08);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.28);
            }

            .card h2 {
                margin: 0 0 0.5rem;
                font-size: 0.85rem;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: var(--accent-soft);
            }

            .card p,
            .card li {
                color: var(--muted);
                line-height: 1.6;
            }

            .booking {
                margin: 0 auto 2rem;
                padding: 1.5rem;
                border-radius: 1.6rem;
                background: linear-gradient(180deg, rgba(22, 15, 11, 0.92), rgba(15, 10, 7, 0.88));
                border: 1px solid rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(14px);
                width: min(100%, 72rem);
            }

            .booking header {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
                margin-bottom: 1rem;
                text-align: center;
            }

            .booking header h2 {
                margin: 0;
                font-size: 1.2rem;
                letter-spacing: -0.03em;
            }

            .booking header p {
                margin: 0.35rem 0 0;
                color: var(--muted);
            }

            .booking-form {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
                max-width: 72rem;
                margin-inline: auto;
            }

            .field {
                display: grid;
                gap: 0.5rem;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            .field label {
                font-size: 0.85rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: rgba(247, 239, 231, 0.84);
            }

            .field input,
            .field textarea {
                width: 100%;
                padding: 0.95rem 1rem;
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.12);
                background: rgba(8, 6, 5, 0.72);
                color: var(--text);
                font: inherit;
            }

            .field textarea {
                min-height: 8rem;
                resize: vertical;
            }

            .booking-actions {
                display: flex;
                justify-content: center;
            }

            .socials-bottom {
                margin: 0 auto 2rem;
                width: min(100%, 72rem);
            }

            .setlist {
                margin: 1rem 0 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.8rem;
            }

            .setlist li {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
                padding-bottom: 0.8rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .setlist li > span:last-child {
                flex-shrink: 0;
            }

            .setlist li:last-child {
                border-bottom: 0;
                padding-bottom: 0;
            }

            .badge-row {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                justify-content: center;
            }

            .badge {
                padding: 0.65rem 0.9rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: var(--text);
                font-size: 0.92rem;
                text-decoration: none;
            }

            .flex-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .social-icon {
                display: block;
                width: 1rem;
                height: 1rem;
            }

            .footer-note {
                padding: 0 2rem 2rem;
                color: rgba(247, 239, 231, 0.7);
                font-size: 0.9rem;
                letter-spacing: 0.04em;
                width: min(100%, 88rem);
                margin-inline: auto;
                text-align: center;
            }

            @media (max-width: 960px) {
                .hero {
                    gap: 0.9rem;
                }

                .hero-media img {
                    height: min(72vw, 28rem);
                    object-position: center 10%;
                }

                .hero-media {
                    margin-top: 0.35rem;
                }

                .hero-title {
                    width: min(94%, 28rem);
                    top: 58%;
                }

                .aside {
                    grid-template-columns: 1fr;
                }

                .stats {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .hero,
                .aside,
                .footer-note {
                    padding-left: 1.1rem;
                    padding-right: 1.1rem;
                }

                .hero {
                    padding-top: 1.1rem;
                }

                .hero-copy {
                    padding: 0.95rem 1rem 1rem;
                }

                .hero-media img {
                    height: 16rem;
                    object-position: center 8%;
                }

                .hero-media {
                    margin-top: 0.3rem;
                }

                .hero-title {
                    width: min(96%, 22rem);
                    font-size: clamp(1.6rem, 10vw, 3rem);
                    top: 60%;
                }

                h1 {
                    max-width: none;
                    font-size: clamp(2rem, 12vw, 3.4rem);
                }

                .lead {
                    margin-top: 0.85rem;
                }

                .actions {
                    margin-top: 1rem;
                }

                .card {
                    padding: 1rem;
                }

                .setlist li {
                    flex-direction: column;
                }

                .setlist li > span:last-child {
                    white-space: normal;
                }

                .button {
                    width: 100%;
                }

                .booking { margin-left: 1.1rem; margin-right: 1.1rem; width: auto; padding: 1.25rem; } .booking-form { grid-template-columns: 1fr; gap: 1rem; } }
        </style>
    </head>
    <body>
        <div class="shell">
            <div class="instrument-rail left" aria-hidden="true">
                <span class="instrument-item">
                    <img src="https://cdn-icons-png.flaticon.com/512/4488/4488189.png" alt="" aria-hidden="true" />
                </span>
                <span class="instrument-item accent">
                    <img src="https://cdn-icons-png.flaticon.com/512/96/96421.png" alt="" aria-hidden="true" />
                </span>
                <span class="instrument-item">
                    <img src="https://cdn-icons-png.flaticon.com/512/2741/2741297.png" alt="" aria-hidden="true" />
                </span>
                <span class="instrument-item accent">
                    <img src="https://cdn-icons-png.flaticon.com/512/9288/9288569.png" alt="" aria-hidden="true" />
                </span>
            </div>

            <div class="instrument-rail right" aria-hidden="true">
                <span class="instrument-item accent">
                    <img src="https://cdn-icons-png.flaticon.com/512/11023/11023831.png" alt="" aria-hidden="true" />
                </span>
                <span class="instrument-item">
                    <img src="https://cdn-icons-png.flaticon.com/512/4900/4900892.png" alt="" aria-hidden="true" />
                </span>
                <span class="instrument-item accent">
                    <img src="https://cdn-icons-png.flaticon.com/512/2168/2168497.png" alt="" aria-hidden="true" />
                </span>
            </div>

            <main class="grid">
                <section class="hero">
                    <div class="hero-media" aria-hidden="true">
                        <img src="{{ asset('images/main.jpg') }}" alt="The Grapes band portrait" />
                        <h2 class="hero-title"><span class="wordmark-top">The</span><span class="wordmark-bottom">Grapes</span></h2>
                    </div>

                    <div class="hero-copy">
                        <p class="eyebrow">Live music with a vintage edge</p>
                        <h1>Big soul, bright hooks, and a set that stays with you.</h1>
                        <p class="lead">
                            The Grapes bring warm grooves, sharp songwriting, and a room-filling sound built for clubs, festivals, and late nights.
                            Book the band, check the next show, or jump into the latest tracks.
                        </p>

                        <div class="actions">
                            <a class="button primary" href="#shows">Upcoming Shows</a>
                            <a class="button secondary" href="#socials">Socials</a>
                            <a class="button tertiary" href="#booking">Booking</a>
                        </div>

                        <div class="stats" aria-label="Band highlights">
                            <div class="stat">
                                <strong>{{ $upcomingShows->count() }}</strong>
                                <span>Upcoming gigs!</span>
                            </div>
                            <div class="stat">
                                <strong>{{ $socialLinks->count() }}</strong>
                                <span>Active social and booking links being kept current.</span>
                            </div>
                            <div class="stat">
                                <strong>{{ $featuredShow?->venue ?? 'Live' }}</strong>
                                <span>
                                    {{ $featuredShow ? $featuredShow->event_date->format('M j') : 'Next featured show appears here.' }}
                                    @if ($featuredShow?->event_time)
                                        ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â¦ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â· {{ \Illuminate\Support\Carbon::parse($featuredShow->event_time)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="aside">
                    <article class="card" id="shows">
                        <h2>Next Gigs</h2>
                        @if ($upcomingShows->isNotEmpty())
                            <ul class="setlist">
                                @foreach ($upcomingShows as $show)
                                    <li>
                                        <span>
                                            <strong style="display:block;color:var(--text);font-size:1rem;">{{ $show->title }}</strong>
                                            <span>{{ $show->venue }}</span>
                                        </span>
                                        <span style="text-align:right;white-space:nowrap;">
                                            {{ $show->event_date->format('M j') }}
                                            @if ($show->event_time)
                                                ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â¦ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â· {{ \Illuminate\Support\Carbon::parse($show->event_time)->format('g:i A') }}
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No upcoming gigs have been added yet. Use the dashboard to publish the first date.</p>
                        @endif
                    </article>

                </aside>
            </main>

            <section class="booking" id="booking" aria-label="Booking form">
                <header>
                    <div>
                        <p class="eyebrow" style="margin-bottom:0.5rem;">Book The Grapes</p>
                        <h2>Send a booking enquiry</h2>
                        <p>Use this form to share your event details and we'll follow up from here.</p>
                    </div>
                </header>

                @if ($errors->has('booking'))
                    <div class="field full">
                        <div class="rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-100">
                            {{ $errors->first('booking') }}
                        </div>
                    </div>
                @endif

                <x-auth-session-status class="field full text-center" :status="session('status')" />

                <div class="field full" data-booking-status aria-live="polite" aria-atomic="true"></div>

                <form class="booking-form" method="POST" action="{{ route('booking-enquiry.send') }}#booking" data-booking-form novalidate>
                    @csrf
                    <div class="field">
                        <label for="book-name">Your name</label>
                        <input id="book-name" type="text" name="name" value="{{ old('name') }}" placeholder="Jon Doe" required />
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="book-email">Email</label>
                        <input id="book-email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="book-date">Event date</label>
                        <input id="book-date" type="date" name="event_date" value="{{ old('event_date') }}" required />
                        @error('event_date')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="book-venue">Venue</label>
                        <input id="book-venue" type="text" name="venue" value="{{ old('venue') }}" placeholder="Venue or location" required />
                        @error('venue')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="book-details">Booking details</label>
                        <textarea id="book-details" name="details" placeholder="Tell us about the event, set length, and anything else we should know." required>{{ old('details') }}</textarea>
                        @error('details')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field full booking-actions">
                        <button class="button primary" type="submit" data-booking-submit>
                            Send Enquiry
                        </button>
                    </div>
                </form>
            </section>

            <section class="socials-bottom" id="socials" aria-label="Social links">
                <article class="card">
                    <h2>Socials</h2>
                    @if ($socialLinks->isNotEmpty())
                        <div class="badge-row">
                            @foreach ($socialLinks as $socialLink)
                                <a class="badge flex-badge" href="{{ $socialLink->url }}" target="_blank" rel="noreferrer">
                                    @if($socialLink->icon)
                                        <img src="https://cdn.simpleicons.org/{{ strtolower(trim($socialLink->icon)) }}/f7efe7" class="social-icon" alt="" width="16" height="16" />
                                    @endif
                                    {{ $socialLink->label ?: $socialLink->platform }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>No social links have been added yet.</p>
                    @endif
                </article>
            </section>

            <div class="footer-note">
                <!-- The Grapes live page for database-driven shows and social updates. -->
            </div>
        </div>
    @if(request()->has('editor_mode'))
    <script>
        window.addEventListener('message', function(event) {
            if (!event.data || event.data.type !== 'editor_update') return;
            const key = event.data.key;
            const val = event.data.value;

            // Element mapping: key -> CSS selector
            const map = {
                wordmark_top:     '.wordmark-top',
                wordmark_bottom:  '.wordmark-bottom',
                eyebrow:          '.hero-copy .eyebrow',
                headline:         '.hero-copy h1',
                lead:             '.hero-copy .lead',
                btn_shows:        '.actions .button.primary',
                btn_socials:      '.actions .button.secondary',
                btn_booking:      '.actions .button.tertiary',
                stat1_label:      '.stats .stat:nth-child(1) span',
                stat2_label:      '.stats .stat:nth-child(2) span',
                gigs_title:       '#shows h2',
                booking_eyebrow:  '.booking header .eyebrow',
                booking_heading:  '.booking header h2',
                booking_desc:     '.booking header p:not(.eyebrow)',
                booking_submit:   '[data-booking-submit]',
                socials_title:    '.socials-bottom h2',
            };

            // Text content updates
            if (map[key]) {
                const el = document.querySelector(map[key]);
                if (el) el.textContent = val;
                return;
            }

            // Theme color
            if (key === 'theme_primary') {
                document.documentElement.style.setProperty('--accent', val);
                document.documentElement.style.setProperty('--accent-soft', val + 'cc');
                document.documentElement.style.setProperty('--accent-bright', val);
                document.body.style.background =
                    'radial-gradient(circle at top left, ' + val + '55, transparent 34%), ' +
                    'radial-gradient(circle at top right, ' + val + '22, transparent 30%), ' +
                    'linear-gradient(135deg, #060504 0%, #120d0a 42%, #1b120d 100%)';
            }

            if (key === 'hero_image') { const el = document.querySelector('.hero-media img'); if (el) el.src = val; }

            // Font change (only for the active field's target element)
            if (key === 'font_change') {
                try {
                    const data = JSON.parse(val);
                    const selector = map[data.target];
                    if (selector) {
                        const el = document.querySelector(selector);
                        if (el) el.style.fontFamily = "'" + data.font + "', sans-serif";
                    }
                } catch(e) {}
            }
        });
    </script>
    @endif
    </body>
</html>
@endif
