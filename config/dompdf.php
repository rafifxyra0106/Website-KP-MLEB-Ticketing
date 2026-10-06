<?php

return [
    'show_warnings'   => false,
    'orientation'     => 'portrait',
    'defines'         => [],
    'dpi'             => 96,
    'default_font'    => 'DejaVu Sans',
    'font_height_ratio' => 1.1,
    'is_php_enabled'  => false,
    'is_remote_enabled' => false,
    'is_javascript_enabled' => false,
    'is_html5_parser_enabled' => true,
    'is_font_subsetting_enabled' => false,
    'pdf_backend'     => 'CPDF',
    'log_output_file' => null,
    'temp_dir'        => storage_path('app/'),
    'font_dir'        => storage_path('fonts/'),
    'font_cache'      => storage_path('fonts/'),
    'chroot'          => realpath(base_path()),
    'options'         => [
        'enable_php'   => false,
        'enable_css_float' => false,
        'enable_javascript' => false,
        'enable_remote' => false,
    ],
];
