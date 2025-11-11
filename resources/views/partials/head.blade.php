<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="index,follow" />
<meta name="author" content="{{ config('app.name') }} Team" />
<meta name="description" content="{{ $description ?? __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}" />

<link rel="canonical" href="{{ url()->current() }}" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/apple-touch-icon.png" type="image/png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="shortcut icon" href="/apple-touch-icon.png" type="image/png">

<meta name="theme-color" content="#111827" media="(prefers-color-scheme: dark)">
<meta name="theme-color" content="#fafafa" media="(prefers-color-scheme: light)">

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $title ?? config('app.name') }}" />
<meta property="og:description" content="{{ $description ?? __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}" />
<meta property="og:image" content="{{ asset('apple-touch-icon.png') }}" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}" />
<meta name="twitter:description" content="{{ $description ?? __('Streamline vehicle inspections, quotations, and repairs — all in one place.') }}" />
<meta name="twitter:image" content="{{ asset('apple-touch-icon.png') }}" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<style>
    .font-montserrat {
        font-family: "Montserrat", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
    }
</style>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
