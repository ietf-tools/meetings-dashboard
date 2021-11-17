<?php
return array(
    'dashboard' => array(
        'title'       => 'Dashboard',
        'description' => 'Welcome to the IETF Dashboard',
        'view'        => 'index',
        'layout'      => array(
            'page-title' => array(
                'breadcrumb' => false,
            ),
        ),
        'assets'      => array(
            'custom' => array(
                'js' => array(
                    'js/custom/widgets.js',
                    'js/dashboard/widgets.js',
                ),
            ),
        ),
    ),
    'index' => array(
        'title'       => 'Dashboard',
        'description' => '',
        'view'        => 'index',
        'layout'      => array(
            'page-title' => array(
                'breadcrumb' => false // hide breadcrumb
            ),
        ),
        'assets'      => array(
            'custom' => array(
                'js' => array(
                    'js/custom/widgets.js',
                    'js/dashboard/widgets.js',
                ),
            ),
        ),
    ),
    'admin' => array(
        'users' => array(
            'title'  => 'User Management',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'systems' => array(
            'title'  => 'System Management',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),
    'reports' => array(
        'title'       => 'Reports',
        'description' => '',
        'view'        => 'reports',
        'layout'      => array(
            'page-title' => array(
                'breadcrumb' => false // hide breadcrumb
            ),
        ),
        'assets'      => array(
            'custom' => array(
                'js' => array(
                    'js/custom/widgets.js',
                    'js/dashboard/widgets.js',
                ),
            ),
        ),
    ),
    'monitoring' => array(
        'title'       => 'Monitoring',
        'description' => '',
        'view'        => 'monitoring',
        'layout'      => array(
            'page-title' => array(
                'breadcrumb' => false // hide breadcrumb
            ),
        ),
        'assets'      => array(
            'custom' => array(
                'js' => array(
                    'js/custom/widgets.js',
                    'js/dashboard/widgets.js',
                    'js/monitoring.js'
                ),
            ),
        ),
    ),
    'participants' => array(
        'index' => array(
            'title'  => 'Participants Management',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),
    'sessions' => array(
        'index' => array(
            'title'  => 'Sessions Management',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        '*' => array(
            'index' => array(
               'custom' => array(
                   'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                    'plugins/custom/datatables/datatables.bundle.js',
                    ),
                )
            )
        )
    ),

    'documentation' => array(
        // Apply for all documentation pages
        '*' => array(
            // Layout
            'layout' => array(
                // Aside
                'aside' => array(
                    'display'  => true, // Display aside
                    'theme'    => 'light', // Set aside theme(dark|light)
                    'minimize' => false, // Allow aside minimize toggle
                    'menu'     => 'documentation' // Set aside menu type(main|documentation)
                ),

                'header' => array(
                    'left' => 'page-title',
                ),

                'toolbar' => array(
                    'display' => false,
                ),

                'page-title' => array(
                    'layout'            => 'documentation',
                    'description'       => false,
                    'responsive'        => true,
                    'responsive-target' => '#kt_header_nav' // Responsive target selector
                ),
            ),
        ),
    ),

    'login'           => array(
        'title'  => 'Login',
        'assets' => array(
            'custom' => array(
                'js' => array(
                    'js/custom/authentication/sign-in/general.js',
                ),
            ),
        ),
    ),
    'log' => array(
        'audit'  => array(
            'title'  => 'Audit Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
        'system' => array(
            'title'  => 'System Log',
            'assets' => array(
                'custom' => array(
                    'css' => array(
                        'plugins/custom/datatables/datatables.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/datatables/datatables.bundle.js',
                    ),
                ),
            ),
        ),
    ),

    'account' => array(
        'overview' => array(
            'title'  => 'My Attendance',
            'view'   => 'account/overview/overview',
            'layout'      => array(
                'page-title' => array(
                    'breadcrumb' => false // hide breadcrumb
                ),
            ),
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/widgets.js',
                    ),
                ),
            ),
        ),

        'settings' => array(
            'title'  => 'My Attendance',
            'view'   => 'account/settings/settings',
            'assets' => array(
                'custom' => array(
                    'js' => array(
                        'js/custom/account/settings/profile-details.js',
                        'js/custom/account/settings/signin-methods.js',
                        'js/custom/modals/two-factor-authentication.js',
                    ),
                ),
            ),
        ),
    ),

);
