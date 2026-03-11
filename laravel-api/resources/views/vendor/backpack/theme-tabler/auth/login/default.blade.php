@extends(backpack_view('layouts.auth'))

@section('content')
    <style>
        /* Force dark theme for the login page to match the vibe */
        body, .page {
            background-color: transparent !important;
        }
        html {
            background-color: #0a0a0a !important;
        }
        
        #particle-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: -1;
            pointer-events: none;
            background-color: #0a0a0a;
        }
        .login-wrapper {
            position: relative;
            z-index: 10;
        }
        /* Glassmorphism for the login card */
        .card.card-md {
            background: rgba(20, 20, 20, 0.45) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 15px 40px rgba(0,0,0,0.5) !important;
            border-radius: 1.5rem !important;
            color: #fafafa !important;
        }
        .card-body {
            padding: 2.5rem !important;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #fafafa !important;
            border-radius: 0.5rem !important;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        .form-label, .form-check-label {
            color: #a1a1aa !important;
            font-weight: 500 !important;
        }
        .btn-primary {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }
        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-1px);
        }
        .auth-logo-container {
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.15em !important;
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        a {
            color: #a1a1aa !important;
            text-decoration: none !important;
        }
        a:hover {
            color: #fafafa !important;
        }
        
        /* Override Tabler defaults */
        .navbar-brand-autodark {
            display: none !important; /* hide default tabler logo */
        }
        .invalid-feedback {
            color: #fb7185 !important;
        }
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        .form-check-input:checked {
            background-color: #fafafa !important;
            border-color: #fafafa !important;
        }
    </style>

    <canvas id="particle-canvas"></canvas>

    <div class="page page-center login-wrapper">
        <div class="container container-tight py-4">
            <div class="text-center mb-5 auth-logo-container">
                HYORIOS ADMIN
            </div>
            <div class="card card-md">
                <div class="card-body pt-0 mt-4">
                    @include(backpack_view('auth.login.inc.form'))
                </div>
            </div>
            @if (config('backpack.base.registration_open'))
                <div class="text-center text-muted mt-4">
                    <a tabindex="6" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');

        let width, height;
        const resize = () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        };
        window.addEventListener('resize', resize);
        resize();

        const numParticles = 500;
        const particles = [];

        // zinc-400 equivalent RGB for alpha blending (161, 161, 170)
        for(let i=0; i<numParticles; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                radius: Math.random() * 1.2 + 0.3,
                alpha: Math.random() * 0.6 + 0.1
            });
        }

        const draw = () => {
            ctx.clearRect(0, 0, width, height);
            
            // Maintain deep charcoal background
            ctx.fillStyle = '#0a0a0a';
            ctx.fillRect(0, 0, width, height);

            particles.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;

                // Infinite loop wraparound
                if(p.x < 0) p.x = width;
                if(p.x > width) p.x = 0;
                if(p.y < 0) p.y = height;
                if(p.y > height) p.y = 0;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(161, 161, 170, ${p.alpha})`; 
                ctx.fill();
            });

            requestAnimationFrame(draw);
        };
        draw();
    </script>
@endsection
