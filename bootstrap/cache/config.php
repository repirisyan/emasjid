<?php return array (
  'adminlte' => 
  array (
    'title' => 'E-Masjid',
    'title_prefix' => '',
    'title_postfix' => '',
    'use_ico_only' => true,
    'use_full_favicon' => false,
    'logo' => '<b>E-masjid</b>',
    'logo_img' => 'storage/logo/mosque.png',
    'logo_img_class' => 'brand-image img-circle elevation-1',
    'logo_img_xl' => NULL,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'E-Masjid',
    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-teal',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,
    'layout_topnav' => NULL,
    'layout_boxed' => NULL,
    'layout_fixed_sidebar' => NULL,
    'layout_fixed_navbar' => NULL,
    'layout_fixed_footer' => NULL,
    'layout_dark_mode' => NULL,
    'classes_auth_card' => 'card-outline shadow card-teal',
    'classes_auth_header' => 'bg-white',
    'classes_auth_body' => 'bg-white text-muted',
    'classes_auth_footer' => 'bg-white',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat bg-teal',
    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => 'text-black-50',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary sidebar-no-expand elevation-4',
    'classes_sidebar_nav' => 'nav-flat',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',
    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,
    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',
    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',
    'menu' => 
    array (
      0 => 
      array (
        'type' => 'fullscreen-widget',
        'topnav_right' => true,
      ),
      1 => 
      array (
        'type' => 'darkmode-widget',
        'topnav_right' => true,
      ),
      2 => 
      array (
        'header' => 'MENU',
      ),
      3 => 
      array (
        'text' => 'Dashboard',
        'icon' => 'fas fa-fw fa-tachometer-alt',
        'url' => '/home',
      ),
      4 => 
      array (
        'text' => 'Profil Masjid',
        'icon' => 'fas fa-fw fa-mosque',
        'can' => 'isAdmin',
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Logo',
            'url' => 'admin/settings/masjid/logo',
            'icon' => 'fas fa-fw fa-dot-circle',
          ),
          1 => 
          array (
            'text' => 'Visi Misi',
            'url' => 'admin/settings/masjid/visimisi',
            'icon' => 'fas fa-fw fa-dot-circle',
          ),
          2 => 
          array (
            'text' => 'Sejarah',
            'url' => 'admin/settings/masjid/sejarah',
            'icon' => 'fas fa-fw fa-dot-circle',
          ),
          3 => 
          array (
            'text' => 'Struktur Organisasi',
            'url' => 'admin/settings/masjid/struktur-organisasi',
            'icon' => 'fas fa-fw fa-dot-circle',
          ),
        ),
      ),
      5 => 
      array (
        'text' => 'Kelola Akun',
        'icon' => 'fas fa-fw fa-users',
        'can' => 'isAdmin',
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Users',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'isAdmin',
            'url' => '/users',
          ),
          1 => 
          array (
            'text' => 'Pengurus',
            'icon' => 'fas fa-fw fa-sitemap',
            'can' => 'isAdmin',
            'url' => '/users/pengurus',
          ),
          2 => 
          array (
            'text' => 'Ustadz',
            'icon' => 'fas fa-fw fa-user-shield',
            'can' => 'isAdmin',
            'url' => '/users/ustadz',
          ),
          3 => 
          array (
            'text' => 'Imam',
            'icon' => 'fas fa-fw fa-user-shield',
            'can' => 'isAdmin',
            'url' => '/users/imam',
          ),
          4 => 
          array (
            'text' => 'Muadzin',
            'icon' => 'fas fa-fw fa-user-shield',
            'can' => 'isAdmin',
            'url' => '/users/muadzin',
          ),
          5 => 
          array (
            'text' => 'Khotib',
            'icon' => 'fas fa-fw fa-user-shield',
            'can' => 'isAdmin',
            'url' => '/users/khotib',
          ),
        ),
      ),
      6 => 
      array (
        'text' => 'Divisi Ziswaf',
        'icon' => 'fas fa-fw fa-users',
        'can' => 
        array (
          0 => 'isBendahara',
          1 => 'isPengurus',
          2 => 'isAdmin',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Visi Misi',
            'icon' => 'fas fa-fw fa-dot-circle',
            'url' => 'ziswaf/visimisi',
            'can' => 
            array (
              0 => 'isAdmin',
              1 => 'isPengurus',
            ),
          ),
          1 => 
          array (
            'text' => 'Laporan Keuangan',
            'icon' => 'fas fa-fw fa-dot-circle',
            'url' => 'ziswaf/keuangan',
            'can' => 
            array (
              0 => 'isAdmin',
              1 => 'isBendahara',
            ),
          ),
          2 => 
          array (
            'text' => 'Galeri Kegiatan',
            'icon' => 'fas fa-fw fa-dot-circle',
            'url' => 'ziswaf/galeri',
            'can' => 
            array (
              0 => 'isAdmin',
              1 => 'isPengurus',
            ),
          ),
        ),
      ),
      7 => 
      array (
        'text' => 'Berita',
        'icon' => 'fas fa-fw fa-newspaper',
        'url' => 'pengurus/berita',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
      ),
      8 => 
      array (
        'text' => 'Kajian Online',
        'icon' => 'fas fa-fw fa-newspaper',
        'url' => 'kajian/online',
        'can' => 
        array (
          0 => 'isUstadz',
          1 => 'isAdmin',
          2 => 'isKetua',
        ),
      ),
      9 => 
      array (
        'text' => 'Galeri',
        'icon' => 'fas fa-fw fa-image',
        'url' => 'pengurus/galeri',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
      ),
      10 => 
      array (
        'text' => 'Event',
        'icon' => 'fas fa-fw fa-calendar',
        'url' => 'pengurus/event',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
      ),
      11 => 
      array (
        'text' => 'Mustahik',
        'icon' => 'fas fa-fw fa-user',
        'url' => 'pengurus/mustahik',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
      ),
      12 => 
      array (
        'text' => 'Keuangan',
        'icon' => 'fas fa-fw fa-money-bill-wave-alt',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
          2 => 'isBendahara',
          3 => 'isKetua',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Laporan Keuangan',
            'url' => 'keuangan/laporan',
            'icon' => 'fas fa-fw fa-scroll',
            'can' => 
            array (
              0 => 'isBendahara',
              1 => 'isAdmin',
              2 => 'isKetua',
            ),
          ),
          1 => 
          array (
            'text' => 'Pengajuan Anggaran',
            'url' => 'keuangan/pengajuan',
            'icon' => 'fas fa-fw fa-hand-holding-usd',
            'can' => 
            array (
              0 => 'isPengurus',
              1 => 'isAdmin',
            ),
          ),
          2 => 
          array (
            'text' => 'Konfirmasi Anggaran',
            'url' => 'keuangan/pengajuan/konfirmasi',
            'icon' => 'fas fa-fw fa-hand-holding-usd',
            'can' => 
            array (
              0 => 'isKetua',
              1 => 'isAdmin',
            ),
          ),
        ),
      ),
      13 => 
      array (
        'text' => 'Kelola Kegiatan',
        'icon' => 'fas fa-fw fa-calendar-week',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Jadwal Sholat Jumat',
            'url' => 'pengurus/kegiatan/jumat',
            'icon' => 'fas fa-fw fa-mosque',
          ),
          1 => 
          array (
            'text' => 'Jadwal Kajian Rutin',
            'url' => 'pengurus/kegiatan/kajian',
            'icon' => 'fas fa-fw fa-quran',
          ),
        ),
      ),
      14 => 
      array (
        'text' => 'Qurban',
        'icon' => 'fas fa-fw fa-paw',
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'Hewan',
            'icon' => 'fas fa-fw fa-hippo',
            'can' => 
            array (
              0 => 'isBendahara',
              1 => 'isAdmin',
            ),
            'url' => '/pengurus/hewan_qurban',
          ),
          1 => 
          array (
            'text' => 'Konfirmasi Pembayaran',
            'icon' => 'fas fa-fw fa-money-bill',
            'can' => 
            array (
              0 => 'isBendahara',
              1 => 'isAdmin',
            ),
            'url' => 'pengurus/qurban/pembayaran',
          ),
          2 => 
          array (
            'text' => 'Produksi',
            'icon' => 'fas fa-fw fa-box-open',
            'can' => 
            array (
              0 => 'isProduksi',
              1 => 'isAdmin',
            ),
            'submenu' => 
            array (
              0 => 
              array (
                'text' => 'Penyembelihan',
                'icon' => 'fas fa-fw fa-drumstick-bite',
                'can' => 
                array (
                  0 => 'isProduksi',
                  1 => 'isAdmin',
                ),
                'url' => '/pengurus/produksi/penyembelihan',
              ),
              1 => 
              array (
                'text' => 'Pembungkusan',
                'icon' => 'fas fa-fw fa-box',
                'can' => 
                array (
                  0 => 'isProduksi',
                  1 => 'isAdmin',
                ),
                'url' => '/pengurus/produksi/pembungkusan',
              ),
            ),
          ),
          3 => 
          array (
            'text' => 'Distribusi',
            'icon' => 'fas fa-fw fa-shipping-fast',
            'can' => 
            array (
              0 => 'isDistribusi',
              1 => 'isAdmin',
            ),
            'submenu' => 
            array (
              0 => 
              array (
                'text' => 'Warga',
                'icon' => 'fas fa-fw fa-users',
                'can' => 
                array (
                  0 => 'isDistribusi',
                  1 => 'isAdmin',
                ),
                'url' => '/qurban/distribusi',
              ),
              1 => 
              array (
                'text' => 'Shohibul',
                'icon' => 'fas fa-fw fa-user',
                'can' => 
                array (
                  0 => 'isDistribusi',
                  1 => 'isAdmin',
                ),
                'url' => '/qurban/permintaan',
              ),
            ),
          ),
          4 => 
          array (
            'text' => 'Pendaftaran',
            'icon' => 'fas fa-fw fa-clipboard-list',
            'can' => 
            array (
              0 => 'isUser',
              1 => 'isAdmin',
            ),
            'url' => '/qurban/pendaftaran',
          ),
          5 => 
          array (
            'text' => 'Monitoring',
            'icon' => 'fas fa-fw fa-desktop',
            'url' => 'qurban/monitoring',
          ),
          6 => 
          array (
            'text' => 'Laporan',
            'icon' => 'fas fa-fw fa-file',
            'can' => 
            array (
              0 => 'isAdmin',
            ),
            'submenu' => 
            array (
              0 => 
              array (
                'text' => 'Distribusi',
                'icon' => 'fas fa-fw fa-dot-circle',
                'url' => '/qurban/laporan/distribusi',
              ),
              1 => 
              array (
                'text' => 'Mudhohi',
                'icon' => 'fas fa-fw fa-dot-circle',
                'url' => '/qurban/laporan/mudhohi',
              ),
            ),
          ),
        ),
      ),
      15 => 
      array (
        'text' => 'Kontak Pesan',
        'icon' => 'fas fa-fw fa-envelope',
        'url' => 'pengurus/kontak',
        'can' => 
        array (
          0 => 'isPengurus',
          1 => 'isAdmin',
        ),
      ),
    ),
    'filters' => 
    array (
      0 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\GateFilter',
      1 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\HrefFilter',
      2 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\SearchFilter',
      3 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\ActiveFilter',
      4 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\ClassesFilter',
      5 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\LangFilter',
      6 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\DataFilter',
    ),
    'plugins' => 
    array (
      'Datatables' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
          ),
          1 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
          ),
          2 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
          ),
        ),
      ),
      'Select2' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
          ),
          1 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
          ),
        ),
      ),
      'Chartjs' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
          ),
        ),
      ),
      'Sweetalert2' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
          ),
        ),
      ),
      'Pace' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css',
          ),
          1 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js',
          ),
        ),
      ),
    ),
    'iframe' => 
    array (
      'default_tab' => 
      array (
        'url' => NULL,
        'title' => NULL,
      ),
      'buttons' => 
      array (
        'close' => true,
        'close_all' => true,
        'close_all_other' => true,
        'scroll_left' => true,
        'scroll_right' => true,
        'fullscreen' => true,
      ),
      'options' => 
      array (
        'loading_screen' => 1000,
        'auto_show_new_tab' => true,
        'use_navbar_items' => true,
      ),
    ),
    'livewire' => true,
  ),
  'app' => 
  array (
    'name' => 'AlikhlashCimareme',
    'env' => 'production',
    'debug' => false,
    'url' => 'https://alikhlashcimareme.or.id/',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'id_ID',
    'key' => 'base64:Cr2/vRpAQSU52nFxqdWiHXC3AQBfdouea72x2FMjpGs=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'RealRashid\\SweetAlert\\SweetAlertServiceProvider',
      23 => 'Barryvdh\\DomPDF\\ServiceProvider',
      24 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      25 => 'App\\Providers\\AppServiceProvider',
      26 => 'App\\Providers\\AuthServiceProvider',
      27 => 'App\\Providers\\EventServiceProvider',
      28 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Alert' => 'RealRashid\\SweetAlert\\Facades\\Alert',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' => 
  array (
    'default' => 'pusher',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '0ff377834399b408fb58',
        'secret' => 'ffec389f2a4e924495aa',
        'app_id' => '1233078',
        'options' => 
        array (
          'cluster' => 'ap1',
          'useTLS' => true,
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/Users/user/Downloads/alikhlash/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'alikhlashcimareme_cache',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'alikhl13_emasjid',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'alikhl13_emasjid',
        'username' => 'alikhl13_emasjid',
        'password' => '8A2Ami8fgQ)4]X',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'alikhl13_emasjid',
        'username' => 'alikhl13_emasjid',
        'password' => '8A2Ami8fgQ)4]X',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'alikhl13_emasjid',
        'username' => 'alikhl13_emasjid',
        'password' => '8A2Ami8fgQ)4]X',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'alikhlashcimareme_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => '/Users/user/Downloads/alikhlash/storage/framework/cache/laravel-excel',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/Users/user/Downloads/alikhlash/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/Users/user/Downloads/alikhlash/storage/app/public',
        'url' => 'https://alikhlashcimareme.or.id//storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
      ),
    ),
    'links' => 
    array (
      '/Users/user/Downloads/alikhlash/public/storage' => '/Users/user/Downloads/alikhlash/storage/app/public',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => '/Users/user/Downloads/alikhlash/resources/views/livewire',
    'layout' => 'layouts.app',
    'asset_url' => NULL,
    'app_url' => NULL,
    'middleware_group' => 'web',
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
    ),
    'manifest_path' => NULL,
    'back_button_cache' => false,
    'render_on_redirect' => false,
  ),
  'livewire-alert' => 
  array (
    'alert' => 
    array (
      'position' => 'top-end',
      'timer' => 3000,
      'toast' => true,
      'text' => NULL,
      'showCancelButton' => false,
      'showConfirmButton' => false,
    ),
    'confirm' => 
    array (
      'icon' => 'warning',
      'position' => 'center',
      'toast' => false,
      'timer' => NULL,
      'showConfirmButton' => true,
      'showCancelButton' => true,
      'cancelButtonText' => 'No',
      'confirmButtonColor' => '#3085d6',
      'cancelButtonColor' => '#d33',
    ),
  ),
  'livewire-datatables' => 
  array (
    'default_time_format' => 'H:i',
    'default_date_format' => 'd/m/Y',
    'suppress_search_highlights' => false,
    'per_page_options' => 
    array (
      0 => 10,
      1 => 25,
      2 => 50,
      3 => 100,
    ),
    'default_per_page' => 10,
    'model_namespace' => 'App',
    'default_classes' => 
    array (
      'row' => 
      array (
        'even' => 'divide-x divide-gray-100 text-sm text-gray-900 bg-gray-100',
        'odd' => 'divide-x divide-gray-100 text-sm text-gray-900 bg-gray-50',
        'selected' => 'divide-x divide-gray-100 text-sm text-gray-900 bg-yellow-100',
      ),
      'cell' => 'text-sm text-gray-900',
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/Users/user/Downloads/alikhlash/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/Users/user/Downloads/alikhlash/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/Users/user/Downloads/alikhlash/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'mail.alikhlashcimareme.or.id',
        'port' => '587',
        'encryption' => NULL,
        'username' => 'admin@alikhlashcimareme.or.id',
        'password' => '8A2Ami8fgQ)4]X',
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
    ),
    'from' => 
    array (
      'address' => 'admin@alikhlashcimareme.or.id',
      'name' => 'AlikhlashCimareme',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/Users/user/Downloads/alikhlash/resources/views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => '/Users/user/Downloads/alikhlash/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'alikhlashcimareme_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'sweetalert' => 
  array (
    'cdn' => NULL,
    'alwaysLoadJS' => false,
    'neverLoadJS' => false,
    'timer' => 5000,
    'width' => NULL,
    'height_auto' => true,
    'padding' => NULL,
    'animation' => 
    array (
      'enable' => true,
    ),
    'animatecss' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
    'show_confirm_button' => true,
    'show_close_button' => false,
    'toast_position' => 'top-end',
    'timer_progress_bar' => false,
    'middleware' => 
    array (
      'autoClose' => false,
      'toast_position' => 'top-end',
      'toast_close_button' => false,
      'timer' => 6000,
      'auto_display_error_messages' => false,
    ),
    'customClass' => 
    array (
      'container' => NULL,
      'popup' => NULL,
      'header' => NULL,
      'title' => NULL,
      'closeButton' => NULL,
      'icon' => NULL,
      'image' => NULL,
      'content' => NULL,
      'input' => NULL,
      'actions' => NULL,
      'confirmButton' => NULL,
      'cancelButton' => NULL,
      'footer' => NULL,
    ),
    'toast_close_button' => false,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/Users/user/Downloads/alikhlash/resources/views',
    ),
    'compiled' => '/Users/user/Downloads/alikhlash/storage/framework/views',
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => '/Users/user/Downloads/alikhlash/storage/fonts/',
      'font_cache' => '/Users/user/Downloads/alikhlash/storage/fonts/',
      'temp_dir' => '/var/folders/2l/k9h021xj6cz791j29cfv7p9h0000gn/T',
      'chroot' => '/Users/user/Downloads/alikhlash',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 94,
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
