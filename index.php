<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f48c25",
                        "background-light": "#f8f7f5",
                        "background-dark": "#221910",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
<title>WireCo Manufacturing | Premium Industrial Wire Solutions</title>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    .spotlight {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
        background: radial-gradient(
            circle 150px at var(--x, -100%) var(--y, -100%),
            rgba(244, 140, 37, 0.15) 0%,
            rgba(0, 0, 0, 0) 100%
        );
    }
    
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    
    .stagger-1 { transition-delay: 0.1s; }
    .stagger-2 { transition-delay: 0.2s; }
    .stagger-3 { transition-delay: 0.3s; }
</style></head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased"><div class="spotlight" id="spotlight"></div>
<!-- Top Navigation -->
<nav class="sticky top-0 z-50 bg-background-light/95 dark:bg-background-dark/95 border-b border-primary/10 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-3xl">precision_manufacturing</span>
                <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-slate-100">Shree Unnati</span>
            </div>

            <div class="hidden md:flex items-center space-x-6"> <a class="text-sm font-medium hover:text-primary transition-colors" href="#products">Products</a>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#services">Services</a>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#about">About</a>
            </div>

            <div>
                <a href="login.php" class="bg-primary text-background-dark px-6 py-2 rounded font-bold text-sm hover:scale-105 transition-all inline-block text-center shadow-lg shadow-primary/20">
                    Login
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-32 reveal">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid lg:grid-cols-2 gap-12 items-center">
<div class="z-10 reveal">
<h1 class="text-5xl lg:text-7xl font-black leading-tight tracking-tighter mb-6 text-slate-900 dark:text-slate-100">
                        High-Quality <span class="text-primary">Industrial</span> Wire Solutions
                    </h1>
<p class="text-lg lg:text-xl text-slate-600 dark:text-slate-400 mb-10 max-w-xl">
                        Precision-engineered wire products for global infrastructure, aerospace, and high-performance industrial applications.
                    </p>
<div class="flex flex-wrap gap-4">
<button class="bg-primary text-background-dark px-8 py-4 rounded font-bold text-base hover:opacity-90 transition-all flex items-center gap-2">
                            View Products <span class="material-symbols-outlined">arrow_forward</span>
</button>
<button class="border border-primary/30 bg-primary/5 text-primary px-8 py-4 rounded font-bold text-base hover:bg-primary/10 transition-all">
                            Technical Data
                        </button>
</div>
</div>
<div class="relative reveal">
<div class="aspect-square rounded-xl bg-primary/10 absolute -top-4 -right-4 w-full h-full -z-10"></div>
<div class="aspect-square rounded-lg bg-cover bg-center shadow-2xl border border-primary/20" data-alt="Close up of high quality copper industrial wire coils" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCEG1pWWBWdgyWIq-4K80kgKR2jwcEOzc9CXVXkKAyxb0grz6yZwKMQfB6VqD9_4g6QZsWMvlXBEM0Yc6459YGWEbJRzWtjQO92xkXQCQp7c2PdgQuzssYCKy22nSTBNXvI5MIsq7Vk00ZEN0IBT6L2cqiMVlEoS23_isjEh-Exh1QBM61aCn1aBVqIWHtMr02ujxt8Lhu3sWksddC4aCKx9FFTILxC2hztBLBeCkJ9cfeXA9sKWk5Z6kbUNKafqPg-wQgYa44JXxs')">
</div>
</div>
</div>
</div>
</section>
<!-- Services Section -->
<section class="py-24 bg-primary/5 reveal">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="mb-16">
<h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-3">Expertise</h2>
<h3 class="text-4xl font-bold text-slate-900 dark:text-slate-100">Our Key Services</h3>
<div class="h-1 w-20 bg-primary mt-4"></div>
</div>
<div class="grid md:grid-cols-3 gap-8">
<!-- Service 1 -->
<div class="bg-background-light dark:bg-background-dark/50 border border-primary/10 p-8 rounded-lg hover:border-primary/50 transition-colors reveal stagger-1">
<span class="material-symbols-outlined text-primary text-4xl mb-6">settings_suggest</span>
<h4 class="text-xl font-bold mb-4">Custom Manufacturing</h4>
<p class="text-slate-600 dark:text-slate-400">Bespoke wire specifications designed for unique industrial needs, from alloy composition to specific gauges.</p>
</div>
<!-- Service 2 -->
<div class="bg-background-light dark:bg-background-dark/50 border border-primary/10 p-8 rounded-lg hover:border-primary/50 transition-colors reveal stagger-2">
<span class="material-symbols-outlined text-primary text-4xl mb-6">conveyor_belt</span>
<h4 class="text-xl font-bold mb-4">Bulk Supply</h4>
<p class="text-slate-600 dark:text-slate-400">High-capacity production lines optimized for large-scale wholesale distribution and just-in-time delivery.</p>
</div>
<!-- Service 3 -->
<div class="bg-background-light dark:bg-background-dark/50 border border-primary/10 p-8 rounded-lg hover:border-primary/50 transition-colors reveal stagger-3">
<span class="material-symbols-outlined text-primary text-4xl mb-6">verified_user</span>
<h4 class="text-xl font-bold mb-4">Quality Testing</h4>
<p class="text-slate-600 dark:text-slate-400">Rigorous stress, conductivity, and durability testing to ensure compliance with ASTM and ISO standards.</p>
</div>
</div>
</div>
</section>
<!-- About Us Summary -->
<section class="py-24 reveal">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex flex-col lg:flex-row gap-16 items-center">
<div class="w-full lg:w-1/2">
<div class="grid grid-cols-2 gap-4">
<div class="aspect-video bg-cover bg-center rounded-lg reveal" data-alt="Industrial manufacturing facility for steel wire" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBPqelLIRWQBMOaaXdR7hoGCSpIcjY_9fJzNdjgf3zeyeeWsUceop4-3dTnEKHGlTH_lpG_UtIwHSx04T8IAgs2FzB4bwNOJ4bMRqUx6E29U36NOYjQeepL7MJ3rZ59TL1lvpREkRzBLbqLd8v3VWOFHJKz3DpSjs4o7B2_8Z_kJNAmET9530goBkRvBuc62U95G8qB9g8QgWdLvy_vmyJ5e2zEMWfHL18Gn2gb8YQvXyeQQ7ECikQCNRMrkG1q5iYiCbYqLsQABQk')"></div>
<div class="aspect-video bg-cover bg-center rounded-lg mt-8 reveal" data-alt="Engineer checking wire quality control" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDy9DwWveaXHlrMqtOonOHcQP13tBWPTC4KOS3cUa_-1u3OW5pXshoOOgvXudNi7OgH0RGw0t1XkLC_o81exnMcSwqvHgxkVtjeHcys1HfkH_OMR9f8RMEkf0oY_MZ0wVCwQXth_ToxJ8XxOBsW2OxGvJHYJygtZ5qcgtI-8CHCjj-qSwV6qykylX8PCEpwExcsqfE0qWPDXr-JhtRwMl4yfO4qGYosa24yEAGO03lO5qDl8pBY8SNHU5-LaNI0PMREvto4XVFIZwM')"></div>
</div>
</div>
<div class="w-full lg:w-1/2">
<h2 class="text-3xl font-bold mb-6 text-slate-900 dark:text-slate-100">Four Decades of Engineering Excellence</h2>
<p class="text-lg text-slate-600 dark:text-slate-400 mb-6">
                        Founded in 1984, WireCo has grown from a local workshop into a global leader in wire manufacturing. Our commitment to innovation and reliability has made us the preferred partner for critical infrastructure projects worldwide.
                    </p>
<p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
                        We don't just sell wire; we provide technical solutions that empower industries to build faster, safer, and more efficiently.
                    </p>
<div class="grid grid-cols-3 gap-4">
<div class="reveal">
<div class="text-2xl font-black text-primary">40+</div>
<div class="text-xs uppercase font-bold text-slate-500">Years Exp.</div>
</div>
<div class="reveal">
<div class="text-2xl font-black text-primary">2500+</div>
<div class="text-xs uppercase font-bold text-slate-500">Global Clients</div>
</div>
<div class="reveal">
<div class="text-2xl font-black text-primary">12k</div>
<div class="text-xs uppercase font-bold text-slate-500">Tons Annual</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="py-20 reveal">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="bg-primary rounded-xl p-8 lg:p-16 relative overflow-hidden flex flex-col items-center text-center">
<div class="absolute inset-0 bg-background-dark opacity-10 pointer-events-none"></div>
<h2 class="text-background-dark text-4xl lg:text-5xl font-black mb-6 relative z-10">Ready to Start Your Project?</h2>
<p class="text-background-dark/80 text-lg mb-10 max-w-2xl relative z-10 font-medium">
                    Get a personalized quote within 24 hours. Our technical team is ready to assist with your specific manufacturing requirements.
                </p>
<div class="flex flex-wrap justify-center gap-4 relative z-10">
<button class="bg-background-dark text-primary px-10 py-4 rounded font-black text-lg hover:bg-slate-900 transition-colors shadow-xl">
                        Request a Quote
                    </button>
<button class="bg-transparent border-2 border-background-dark text-background-dark px-10 py-4 rounded font-black text-lg hover:bg-background-dark/10 transition-colors">
                        Contact Sales
                    </button>
</div>
</div>
</div>
</section>
<!-- Footer -->
<footer class="bg-background-light dark:bg-background-dark border-t border-primary/10 py-12 reveal">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
<div class="col-span-2 md:col-span-1 reveal">
<div class="flex items-center gap-2 mb-6">
<span class="material-symbols-outlined text-primary text-2xl">precision_manufacturing</span>
<span class="text-lg font-bold">Shree Unnati </span>
</div>
<p class="text-sm text-slate-500">Leading the industry in precision wire manufacturing since 1984.</p>
</div>
<div class="reveal">
<h5 class="font-bold mb-4">Products</h5>
<ul class="space-y-2 text-sm text-slate-500">
<li><a class="hover:text-primary" href="#">Copper Wire</a></li>
<li><a class="hover:text-primary" href="#">Stainless Steel</a></li>
<li><a class="hover:text-primary" href="#">Alloy Solutions</a></li>
<li><a class="hover:text-primary" href="#">Custom Gauges</a></li>
</ul>
</div>
<div class="reveal">
<h5 class="font-bold mb-4">Company</h5>
<ul class="space-y-2 text-sm text-slate-500">
<li><a class="hover:text-primary" href="#">About Us</a></li>
<li><a class="hover:text-primary" href="#">Careers</a></li>
<li><a class="hover:text-primary" href="#">Sustainability</a></li>
<li><a class="hover:text-primary" href="#">Contact</a></li>
</ul>
</div>
<div class="reveal">
<h5 class="font-bold mb-4">Connect</h5>
<div class="flex gap-4">
<a class="text-slate-500 hover:text-primary" href="#"><span class="material-symbols-outlined">share</span></a>
<a class="text-slate-500 hover:text-primary" href="#"><span class="material-symbols-outlined">mail</span></a>
<a class="text-slate-500 hover:text-primary" href="#"><span class="material-symbols-outlined">call</span></a>
</div>
</div>
</div>
<div class="pt-8 border-t border-primary/5 text-center text-xs text-slate-500">
                © 2024 WireCo Manufacturing Inc. All rights reserved.
            </div>
</div>
</footer>
<script>
    document.addEventListener('mousemove', (e) => {
        const spotlight = document.getElementById('spotlight');
        spotlight.style.setProperty('--x', e.clientX + 'px');
        spotlight.style.setProperty('--y', e.clientY + 'px');
    });

    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script></body></html>