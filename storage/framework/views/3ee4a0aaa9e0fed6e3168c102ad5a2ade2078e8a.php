<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Movie App')); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e50914;
            --primary-hover: #b20710;
            --bg-darker: #0b0b0b;
            --bg-dark: #141414;
            --bg-light: #232323;
            --text-main: #ffffff;
            --text-muted: #b3b3b3;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-darker);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
            transition: background 0.3s;
            z-index: 1050;
        }

        .dropdown-item.text-white { color: #fff !important; }
        .dropdown-item.text-white:hover { background-color: #e50914 !important; color: #fff !important; }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: var(--text-main) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(229, 9, 20, 0.3);
        }

        .card {
            background: var(--bg-light);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .movie-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: none;
            background: transparent;
        }

        .movie-card:hover {
            transform: scale(1.04);
            z-index: 10;
        }

        .movie-card:hover .card-img-overlay {
            opacity: 1;
        }

        .movie-poster {
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            transition: filter 0.3s;
            aspect-ratio: 2/3;
            object-fit: cover;
            width: 100%;
        }

        .movie-card:hover .movie-poster {
            filter: brightness(0.6) blur(2px);
        }

        .card-img-overlay {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.25rem;
            opacity: 0;
            transition: opacity 0.3s;
            background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
        }

        .dropdown-menu {
            background-color: var(--bg-dark);
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .dropdown-item {
            color: var(--text-main);
            font-size: 0.9rem;
            padding: 0.6rem 1.2rem;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .alert {
            border-radius: 8px;
            border: none;
            font-weight: 500;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-darker);
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    MOVIE APP
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <?php if(auth()->guard()->check()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('movies.index')); ?>"><?php echo e(__('app.nav.movies')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('favorites.index')); ?>"><?php echo e(__('app.nav.favorites')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownLang" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(strtoupper(app()->getLocale())); ?>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownLang" style="background-color: #1a1a1a; border: 1px solid #333;">
                                <a class="dropdown-item text-white hover-bg-danger" href="<?php echo e(route('language.switch', 'en')); ?>">EN</a>
                                <a class="dropdown-item text-white hover-bg-danger" href="<?php echo e(route('language.switch', 'id')); ?>">ID</a>
                            </div>
                        </li>
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('app.auth.login')); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-dark text-white" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-white" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('app.nav.logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show bg-danger text-white border-0" role="alert">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\TechnicalTest\resources\views/layouts/app.blade.php ENDPATH**/ ?>