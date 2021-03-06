<?php

namespace Oauth\Model;

class RedirectUris extends \Model\Oauth {

    protected static $_table_name = 'oauth_client_redirect_uris';
    protected static $_fields = array(
        'client_id' => array(
            'data_type' => 'varchar',
            'label' => 'Client ID',
            'null' => false,
            'validation' => array(
                'required' => true,
                'max_length' => 50
            ),
        ),
        'redirect_uri' => array(
            'data_type' => 'varchar',
            'label' => 'Redirect URI',
            'null' => false,
            'validation' => array(
                'required' => true,
                'max_length' => 255
            ),
        ),
    );
    protected static $_relationships = array(
        'has_one' => array(
            'client' => array(
                'key_from' => 'client_id',
                'model_to' => 'Oauth\\Model\\Clients',
                'key_to' => 'id',
                'cascade_save' => false,
                'cascade_delete' => true,
            )
        ),
    );
}
