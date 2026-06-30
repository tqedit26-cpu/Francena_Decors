<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Fancy Decorators delivers luxury construction, premium residential and commercial builds, upscale renovations, and bespoke interior design across the metropolitan area." />
  <meta name="keywords" content="luxury construction, premium builder, residential construction, commercial construction, interior design, home renovation, elite contractors, custom build services" />
  <meta name="robots" content="index, follow" />
  <title>@yield('title', 'Fancy Decorators | Luxury Construction Company')</title>
  <meta name="theme-color" content="#d4af5f" />
  <meta property="og:title" content="Fancy Decorators | Luxury Construction Company" />
  <meta property="og:description" content="Premium construction and design services for luxury residential, commercial, and interior projects. Turn your vision into award-worthy spaces." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.fancydecorators.com/" />
  <meta property="og:image" content="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1800&q=80" />
  <meta property="og:site_name" content="Fancy Decorators" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Fancy Decorators | Luxury Construction Company" />
  <meta name="twitter:description" content="Premium construction and design services for luxury residential, commercial, and interior projects." />
  <meta name="twitter:image" content="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1800&q=80" />
  <meta name="twitter:site" content="@@FancyDecorators" />
  <link rel="canonical" href="https://www.fancydecorators.com/" />
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "HomeAndConstructionBusiness",
    "name": "Fancy Decorators",
    "url": "https://www.fancydecorators.com/",
    "logo": "https://www.fancydecorators.com/logo.png",
    "image": "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1800&q=80",
    "description": "Premium luxury construction, high-end renovations, and custom interior design services for residential and commercial clients.",
    "telephone": "+1 234 567 890",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "25 Royal Avenue",
      "addressLocality": "Downtown City",
      "addressRegion": "State",
      "postalCode": "12345",
      "addressCountry": "USA"
    },
    "areaServed": {
      "@@type": "City",
      "name": "Metropolitan Area"
    },
    "openingHoursSpecification": [
      {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
        "opens": "08:00",
        "closes": "18:00"
      }
    ],
    "sameAs": [
      "https://www.facebook.com/FancyDecorators",
      "https://www.instagram.com/FancyDecorators",
      "https://www.linkedin.com/company/FancyDecorators"
    ]
  }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>
<body>
  @include('partials.header')

  @yield('content')

  @include('partials.footer')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
