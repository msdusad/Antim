<?php
return array(
    'email' => array(
        'credentials' => array(
            'from_mail' => 'support@domain.com',
            'from_name' => 'yourname',
        ),
        //use smtp or sendmail
        'transport' => 'sendmail',
        'smtp' => array(
            'host' => 'smtp.domain.com',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'ssl'      => 'tls',
                'username' => 'youremail',
                'password' => 'yourpassword'
            ),
        ),
    ),
);