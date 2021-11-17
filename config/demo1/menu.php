<?php

use App\Core\Adapters\Theme;

return array(
    // Main menu
    'main'       => array(
        //// Dashboard
        array(
            'title' => 'Dashboard',
            'path'  => 'dashboard',
            'icon'  => Theme::getSvgIcon("icons/duotone/Design/PenAndRuller.svg", "svg-icon-2"),
        ),

        //// Modules
        array(
            'classes' => array('content' => 'pt-8 pb-2'),
            'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
        ),

        // Account
        array(
            'title'      => 'Account',
            'icon'       => array(
                'svg'  => Theme::getSvgIcon("icons/duotone/General/User.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub'        => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'  => 'Overview',
                        'path'   => 'account/overview',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'Settings',
                        'path'   => 'account/settings',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'      => 'Security',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "Coming soon",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                ),
            ),
        ),

        // System
        array(
            'title'      => 'System',
            'icon'       => array(
                'svg'  => Theme::getSvgIcon("icons/duotone/Layout/Layout-4-blocks.svg", "svg-icon-2"),
                'font' => '<i class="bi bi-layers fs-3"></i>',
            ),
            'classes'    => array('item' => 'menu-accordion'),
            'attributes' => array(
                "data-kt-menu-trigger" => "click",
            ),
            'sub'        => array(
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => array(
                    array(
                        'title'      => 'Settings',
                        'path'       => '#',
                        'bullet'     => '<span class="bullet bullet-dot"></span>',
                        'attributes' => array(
                            'link' => array(
                                "title"             => "Coming soon",
                                "data-bs-toggle"    => "tooltip",
                                "data-bs-trigger"   => "hover",
                                "data-bs-dismiss"   => "click",
                                "data-bs-placement" => "right",
                            ),
                        ),
                    ),
                    array(
                        'title'  => 'Audit Log',
                        'path'   => 'log/audit',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                    array(
                        'title'  => 'System Log',
                        'path'   => 'log/system',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ),
                ),
            ),
        ),

        // Separator
        array(
            'content' => '<div class="separator mx-1 my-4"></div>',
        ),

        // Changelog
        array(
            'title' => 'Changelog v'.theme()->getVersion(),
            'icon'  => Theme::getSvgIcon("icons/duotone/Files/File.svg", "svg-icon-2"),
            'path'  => 'documentation/getting-started/changelog',
        ),
    ),

    // Horizontal menu
    'horizontal' => array(
        // Dashboard
        array(
            'title'   => 'Dashboard',
            'path'    => 'dashboard',
            'classes' => array('item' => 'me-lg-1'),
        ),

        // Resources
        array(
            'title'      => 'Reports',
            'path'       => 'reports',
            'classes' => array('item' => 'me-lg-1'),
        ),
        array(
            'title'      => 'Monitoring',
            'path'       => 'monitoring',
            'classes' => array('item' => 'me-lg-1'),
        ),
    ),
    'horizontal-admin' => array(
        array(
            'title'    => 'Participants',
            'path'     => 'participants/index',
            'classes'  => array('item' => 'me-lg-1'),
        ),
        array(
            'title'    => 'Sessions',
            'path'     => 'sessions/index',
            'classes'  => array('item' => 'me-lg-1'),
        ),
        array(
            'title'      => 'Admin',
            'classes'    => array('item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'),
            'attributes' => array(
                'data-kt-menu-trigger'   => "click",
                'data-kt-menu-placement' => "bottom-start",
            ),
            'sub'        => array(
                'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                'items' => array(

                    // User Management
                    array(
                        'title' => 'User Management',
                        'icon'  => Theme::getSvgIcon("icons/duotone/General/User.svg", "svg-icon-2"),
                        'path'  => 'admin/users',
                    ),

                    // Systems Management
                    array(
                        'title' => 'Systems Management',
                        'icon'  => Theme::getSvgIcon("icons/duotone/General/Settings-2.svg", "svg-icon-2"),
                        'path'  => 'admin/systems',
                    ),
                ),
            ),
        ),
    )
);
