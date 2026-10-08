# ViteCSS

A lightweight front-end assets collection for local HTML and Laravel projects.

This repository includes:
- `index.html` sample page displaying fonts, CSS variables, and UI utilities.
- `css/app.css` core theme styles, color variables, and utility classes.
- `fonts/fonts.css` font loading for local font families.
- `js/app.js` app utilities and front-end script logic.
- `js/alpine.bundle.js`, `js/html2canvas.min.js`, and `js/chart.js` for interactive features.

## Project structure

- `index.html` — demo page and font preview.
- `css/app.css` — main stylesheet with theme variables and custom properties.
- `fonts/fonts.css` — font stylesheet for local fonts.
- `js/app.js` — application JavaScript utilities.
- `assets/`, `samples/`, `upload/` — supporting demos and examples.

## Usage

### Static HTML

Include the CSS and fonts in the document head:

<!--html -->
<link rel="stylesheet" href="css/app.css">
<!-- -->

Include the required script files before the closing `</body>` tag:

<!--html -->
<script src="js/app.min.js"></script>
<!-- -->

Optional secondary scripts:

<!--html -->
<script src="js/html2canvas.min.js"></script>
<script src="js/chart.js"></script>
<script src="js/confetti.js"></script>
<script src="js/three.min.js"></script>
<!-- -->

Use these optional scripts only when your page uses screenshot rendering, charts, confetti effects, or 3D/Three.js features.

### Laravel

If you are using Laravel with a public `vitecss` directory, add the following to your Blade layout:

<!--blade -->
<!-- In <head> -->
<link rel="stylesheet" href="{{ asset('vitecss/css/app.min.css') }}">

<!-- Before </body> -->
<script src="{{ asset('vitecss/js/app.js') }}" defer></script>
<script src="{{ asset('vitecss/js/html2canvas.min.js') }}" defer></script>
<script src="{{ asset('vitecss/js/chart.js') }}" defer></script>
<!-- -->

## Customization

- Edit `css/app.css` to update theme colors, fonts, and spacing.
- Modify `index.html` to preview font styles and sample components.

## Notes

- `index.html` demonstrates font usage with local font names such as `Poppins`, `Anton`, `DM Sans`, `Urbanist`, `Manrope`, and more.
- The project is designed for a self-contained front-end asset bundle and does not require a build tool to run.
- To view the demo, open `index.html` in your browser or serve the `vitecss` directory through a web server.


<!-- Primary Boilerplate (For assistance you can copy and paste) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="{{ config('app.name') }} - Your description title here" />
    <meta property="og:description" content="Your description title here" />
    <meta property="og:image" content="{{ asset(config('settings.logo')) }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />

    <!-- Twitter Card (optional but recommended) -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.name') }} - Your description here" />
    <meta name="twitter:description" content="Your description title here" />
    <meta name="twitter:image" content="{{ asset(config('settings.logo')) }}" />

    <link rel="icon" type="image/png" href="/favicon-96x96.png?v=20260712" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg?v=20260712" />
    <link rel="shortcut icon" href="/favicon.ico?v=20260712" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=20260712" />
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
    <link rel="manifest" href="/site.webmanifest?v=20260712" />
    <link rel="stylesheet" href="{{ asset('vitecss/css/app.min.css?v='.config('versions.vite_version').'') }}">
    
    <script src="{{ asset('vitecss/js/app.min.js') }}" defer></script>
<title>{{ config('app.name') }} - @yield('title')</title>
</head>
<body>
    
</body>
</html>