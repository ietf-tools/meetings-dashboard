<?php
return array(
    // Documentation pages
    'documentation' => array(
        '*' => array(
            'assets' => array(
                'vendors' => array(
                    'css' => array(
                        'plugins/custom/prismjs/prismjs.bundle.css',
                    ),
                    'js'  => array(
                        'plugins/custom/prismjs/prismjs.bundle.js',
                    ),
                ),
                'custom'  => array(
                    'js' => array(
                        'js/custom/documentation/documentation.js',
                    ),
                ),
            ),

            'layout' => array(
                // Content
                'content' => array(
                    'width'  => 'fixed', // Set fixed|fluid to change width type
                    'layout' => 'documentation'  // Set content type
                ),
            ),
        ),

        'getting-started' => array(
            'overview' => array(
                'title'       => 'Overview',
                'description' => '',
                'view'        => 'documentation/getting-started/overview',
            ),

            'build' => array(
                'title'       => 'Gulp',
                'description' => '',
                'view'        => 'documentation/getting-started/build/build',
            ),

            'multi-demo' => array(
                'title'       => 'Multi-demo',
                'description' => '',
                'view'        => 'documentation/getting-started/multi-demo',
            ),

            'file-structure' => array(
                'title'       => 'Build',
                'description' => '',
                'view'        => 'documentation/getting-started/file-structure',
            ),

            'customization' => array(
                'sass'       => array(
                    'title'       => 'SASS',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/sass',
                ),
                'javascript' => array(
                    'title'       => 'Javascript',
                    'description' => '',
                    'view'        => 'documentation/getting-started/customization/javascript',
                ),
            ),

            'rtl' => array(
                'title' => 'RTL Version',
                'view'  => 'documentation/getting-started/rtl',
            ),

            'troubleshoot' => array(
                'title' => 'Troubleshoot',
                'view'  => 'documentation/getting-started/troubleshoot',
            ),

            'changelog' => array(
                'title'       => 'Changelog',
                'description' => 'version and update info',
                'view'        => 'documentation/getting-started/changelog/changelog',
            ),

            'updates' => array(
                'title'       => 'Updates',
                'description' => 'components preview and usage',
                'view'        => 'documentation/getting-started/updates',
            ),

            'references' => array(
                'title'       => 'References',
                'description' => '',
                'view'        => 'documentation/getting-started/references',
            ),
        ),

        'general' => array(
            'datatables' => array(
                'overview' => array(
                    'title'       => 'Overview',
                    'description' => 'plugin overview',
                    'view'        => 'documentation/general/datatables/overview/overview',
                ),
            ),
        ),

        'configuration' => array(
            'menu' => array(
                'title'       => 'Menu',
                'description' => '',
                'view'        => 'documentation/configuration/menu',
            ),
        ),
    ),
);
