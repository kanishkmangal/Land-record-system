<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Land Records Portal') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-surface": "#1e333c",
                        "on-secondary-fixed-variant": "#005312",
                        "on-secondary-fixed": "#002204",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#747781",
                        "tertiary": "#171a1c",
                        "on-primary-container": "#7796d1",
                        "surface-bright": "#f3faff",
                        "on-tertiary-fixed": "#191c1e",
                        "secondary-fixed-dim": "#88d982",
                        "primary-fixed-dim": "#abc7ff",
                        "surface-container-highest": "#cfe6f2",
                        "on-tertiary-container": "#939698",
                        "on-background": "#071e27",
                        "surface-container-low": "#e6f6ff",
                        "primary-container": "#002d62",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "tertiary-fixed": "#e0e3e5",
                        "background": "#f3faff",
                        "secondary-fixed": "#a3f69c",
                        "on-error": "#ffffff",
                        "inverse-primary": "#abc7ff",
                        "inverse-on-surface": "#dff4ff",
                        "on-primary": "#ffffff",
                        "surface-dim": "#c7dde9",
                        "on-surface": "#071e27",
                        "surface": "#f3faff",
                        "on-surface-variant": "#43474f",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed-variant": "#444749",
                        "surface-container": "#dbf1fe",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#217128",
                        "tertiary-container": "#2b2f31",
                        "secondary": "#1b6d24",
                        "error": "#ba1a1a",
                        "primary-fixed": "#d7e2ff",
                        "outline-variant": "#c4c6d1",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#d5ecf8",
                        "primary": "#00193c",
                        "surface-tint": "#3e5e95",
                        "on-primary-fixed": "#001b3f",
                        "on-primary-fixed-variant": "#24467c",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#a0f399",
                        "surface-variant": "#cfe6f2"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "xs": "4px",
                        "xl": "80px",
                        "sm": "12px",
                        "gutter": "24px",
                        "base": "8px",
                        "lg": "48px",
                        "container-max": "1280px",
                        "md": "24px"
                    },
                    "fontFamily": {
                        "h1": ["Public Sans"],
                        "body-sm": ["Inter"],
                        "h2": ["Public Sans"],
                        "body-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "h3": ["Public Sans"],
                        "label-md": ["Inter"]
                    },
                    "fontSize": {
                        "h1": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "h2": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "h3": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "16px", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f3faff;
            font-family: 'Inter', sans-serif;
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-surface text-on-surface">
    @include('components.navbar')

    <main class="pt-14 pb-20">
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.bottom-nav')

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
