@php
    $seoTitle = $title ?? 'SprayWow | Premium Cleaning Sprays';
    $seoDescription = $description ?? 'Premium cleaning sprays, home care products, and practical cleaning tips from SprayWow.';
    $seoKeywords = $keywords ?? 'cleaning sprays, home cleaning tips, spray cleaners, SprayWow';
    $seoCanonical = $canonical ?? url()->current();
    $seoImage = $image ?? asset('images/spray-wow-logo-500.webp');
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<link rel="canonical" href="{{ $seoCanonical }}">
<meta property="og:type" content="{{ $type ?? 'website' }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:site_name" content="SprayWow">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
