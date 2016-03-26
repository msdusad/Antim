<?php
return array(
    'modules' => array(
        'ZfcBase',
        'ZfcUser',
        'BjyAuthorize',
        'RoleUserBridge',
        //'ZendDeveloperTools',    	
    	//'ZFTool',
        'WebinoImageThumb',
        'Application',
		'Administrator',
        'Admin',
        'ScnSocialAuth',
        'BjyProfiler',
        'SharedTasks',
        'CremationPlan',       
        'Emails',
        'EventCalendar',
        'Memoralize',
        'Obituary',
        'PrePlanning',
        'IMandir',
        'Shopping',
        'Donation',
        'SpeckPaypal',
		'Menu',
		'Pages',
		'Mailbox'
		
        
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    )
);
