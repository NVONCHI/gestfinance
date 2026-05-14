<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'fr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'GestFinance' ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        :root {
            /* Material Design 3 Color Palette (Baseline Blue) */
            --md-sys-color-primary: #0061A4;
            --md-sys-color-on-primary: #FFFFFF;
            --md-sys-color-primary-container: #D1E4FF;
            --md-sys-color-on-primary-container: #001D36;
            
            --md-sys-color-secondary: #535F70;
            --md-sys-color-on-secondary: #FFFFFF;
            --md-sys-color-secondary-container: #D7E3F7;
            --md-sys-color-on-secondary-container: #101C2B;
            
            --md-sys-color-surface: #FDFBFF;
            --md-sys-color-on-surface: #1A1C1E;
            --md-sys-color-surface-variant: #E0E2EC;
            --md-sys-color-on-surface-variant: #44474E;
            --md-sys-color-outline: #74777F;
            
            --md-sys-color-error: #BA1A1A;
            --md-sys-color-on-error: #FFFFFF;
            
            font-family: 'Roboto', sans-serif;
        }

        body { 
            margin: 0; 
            background-color: #F8F9FA; 
            color: var(--md-sys-color-on-surface); 
            display: flex; 
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        
        a { text-decoration: none; color: inherit; }

        /* Sidebar Navigation */
        .sidebar {
            width: 280px;
            background-color: var(--md-sys-color-surface);
            border-right: 1px solid var(--md-sys-color-surface-variant);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--md-sys-color-primary);
        }

        .nav-list { list-style: none; padding: 12px; margin: 0; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 100px;
            margin-bottom: 4px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface-variant);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item:hover { background-color: rgba(0, 97, 164, 0.08); }
        .nav-item.active { 
            background-color: var(--md-sys-color-primary-container); 
            color: var(--md-sys-color-on-primary-container); 
        }
        .nav-section-title {
            padding: 16px 16px 8px 24px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--md-sys-color-outline);
            letter-spacing: 0.5px;
        }

        /* Main Layout */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        
        .top-bar {
            height: 64px;
            background: white;
            border-bottom: 1px solid var(--md-sys-color-surface-variant);
            display: flex;
            align-items: center;
            padding: 0 24px;
            justify-content: space-between;
        }

        .content-area { 
            padding: 24px; 
            flex: 1; 
            overflow-y: auto; 
            max-width: 1200px; 
            width: 100%; 
            margin: 0 auto; 
            box-sizing: border-box;
        }

        /* Material 3 Card Styles */
        .card { 
            background: white; 
            border-radius: 16px; 
            padding: 24px; 
            box-shadow: 0 1px 2px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            border: 1px solid var(--md-sys-color-surface-variant);
            transition: box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Material 3 Button Styles */
        .btn { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            padding: 10px 24px; 
            border-radius: 100px; 
            font-weight: 500; 
            cursor: pointer; 
            border: none; 
            font-size: 14px; 
            gap: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            height: 40px;
            box-sizing: border-box;
            white-space: nowrap;
        }

        /* Filled Button (Primary) */
        .btn-filled { 
            background: var(--md-sys-color-primary); 
            color: var(--md-sys-color-on-primary); 
        }
        .btn-filled:hover {
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            filter: brightness(1.1);
        }

        /* Outlined Button */
        .btn-outlined { 
            background: transparent; 
            border: 1px solid var(--md-sys-color-outline);
            color: var(--md-sys-color-primary); 
        }
        .btn-outlined:hover {
            background-color: rgba(0, 97, 164, 0.04);
        }

        /* Text Button */
        .btn-text {
            background: transparent;
            color: var(--md-sys-color-primary);
            padding: 10px 12px;
        }
        .btn-text:hover {
            background-color: rgba(0, 97, 164, 0.08);
        }
        
        /* Danger variant */
        .btn-danger {
            color: var(--md-sys-color-error);
        }
        .btn-danger:hover {
            background-color: rgba(186, 26, 26, 0.08);
        }

        /* Forms */
        .form-group { margin-bottom: 24px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--md-sys-color-on-surface-variant);
        }
        .form-control { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid var(--md-sys-color-outline); 
            border-radius: 8px; 
            box-sizing: border-box; 
            background: transparent;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--md-sys-color-primary);
            border-width: 2px;
            padding: 11px 15px;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            color: var(--md-sys-color-outline);
        }
        .breadcrumb-item:after { content: '/'; margin-left: 8px; }
        .breadcrumb-item:last-child:after { content: ''; }
        .breadcrumb-item.active { color: var(--md-sys-color-on-surface); font-weight: 500; }

        /* Tables */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid var(--md-sys-color-surface-variant);
            font-size: 14px;
            font-weight: 700;
            color: var(--md-sys-color-on-surface-variant);
        }
        .data-table td { 
            padding: 16px; 
            border-bottom: 1px solid var(--md-sys-color-surface-variant); 
            vertical-align: middle;
        }

        /* Utilities */
        .flex { display: flex; align-items: center; }
        .flex-between { display: flex; align-items: center; justify-content: space-between; }
        .gap-8 { gap: 8px; }
        .gap-16 { gap: 16px; }
        .mt-24 { margin-top: 24px; }
    </style>
</head>
<body>
    <?php if (\App\Core\AuthHelper::isLoggedIn()): ?>
    <aside class="sidebar">
        <div class="sidebar-header">
            <span class="material-symbols-outlined">account_balance</span>
            <span style="font-size: 20px; font-weight: 700;">GestFinance</span>
        </div>
        
        <nav class="nav-list">
            <a href="/dashboard" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">dashboard</span> <?= __('dashboard') ?>
            </a>
            <a href="/profile" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/profile' ? 'active' : '' ?>">
                <span class="material-symbols-outlined">account_circle</span> <?= __('profile') ?>
            </a>
            
            <div class="nav-section-title"><?= __('my_operations') ?></div>
            <a href="/demandes" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/demandes') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">description</span> <?= __('my_requests') ?>
            </a>
            
            <?php if ($_SESSION['user_category'] !== 'agent'): ?>
            <a href="/validations" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/validations') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">rule</span> <?= __('validation_center') ?>
            </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_space']) && $_SESSION['user_space'] === 'admin'): ?>
                <div class="nav-section-title"><?= __('administration') ?></div>
                <a href="/admin/users" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/admin/users') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">group</span> <?= __('users') ?>
                </a>
                <a href="/admin/services" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/admin/services') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">lan</span> <?= __('services') ?>
                </a>
                <a href="/admin/roles" class="nav-item <?= str_contains($_SERVER['REQUEST_URI'], '/admin/roles') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">badge</span> <?= __('roles') ?>
                </a>
            <?php endif; ?>
        </nav>
    </aside>
    <?php endif; ?>

    <div class="main-wrapper">
        <?php if (isset($_SESSION['user_id'])): ?>
        <header class="top-bar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-outlined" style="color: var(--md-sys-color-outline);">
                    <?= $_SESSION['user_space'] === 'admin' ? 'admin_panel_settings' : 'person' ?>
                </span>
                <span style="font-weight: 500; font-size: 16px; color: var(--md-sys-color-outline);"><?= $_SESSION['user_space'] === 'admin' ? __('admin') : __('user') ?></span>
                <span style="margin: 0 8px; color: var(--md-sys-color-surface-variant);">|</span>
                <span style="font-weight: 500; font-size: 18px;"><?= $title ?? '' ?></span>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
                
                <div class="lang-switcher" style="display: flex; align-items: center; gap: 4px;">
                    <a href="/lang/fr" class="btn btn-text" style="padding: 4px 8px; font-weight: <?= ($_SESSION['lang'] ?? 'fr') === 'fr' ? 'bold' : 'normal' ?>; color: <?= ($_SESSION['lang'] ?? 'fr') === 'fr' ? 'var(--md-sys-color-primary)' : 'var(--md-sys-color-outline)' ?>;">FR</a>
                    <span style="color: var(--md-sys-color-surface-variant);">|</span>
                    <a href="/lang/en" class="btn btn-text" style="padding: 4px 8px; font-weight: <?= ($_SESSION['lang'] ?? 'fr') === 'en' ? 'bold' : 'normal' ?>; color: <?= ($_SESSION['lang'] ?? 'fr') === 'en' ? 'var(--md-sys-color-primary)' : 'var(--md-sys-color-outline)' ?>;">EN</a>
                </div>

                <span style="font-size: 14px; color: var(--md-sys-color-outline);"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="/logout" class="btn btn-text btn-danger">
                    <span class="material-symbols-outlined">logout</span>
                    <?= __('logout') ?>
                </a>
            </div>
        </header>
        <?php endif; ?>

        <main class="content-area">
            <?php if (isset($_SESSION['user_id']) && isset($breadcrumbs)): ?>
            <nav class="breadcrumbs">
                <?php foreach ($breadcrumbs as $i => $crumb): ?>
                    <a href="<?= $crumb['url'] ?>" class="breadcrumb-item <?= $i === count($breadcrumbs)-1 ? 'active' : '' ?>">
                        <?= htmlspecialchars($crumb['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div style="background: #FFDAD6; color: #410002; padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #FFB4AB;">
                    <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div style="background: #E8F5E9; color: #1B5E20; padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #A5D6A7;">
                    <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <?= isset($content) ? $content : '' ?>
        </main>
    </div>
</body>
</html>
