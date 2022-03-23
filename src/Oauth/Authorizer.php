<?php


namespace Onetech\EasyLazada\Oauth;


class Authorizer
{

    const OAUTH_URL = 'https://auth.lazada.com/oauth/authorize?response_type=%s&force_auth=%s&redirect_uri=%s&client_id=%s';

    private $response_type;

    private $force_auth;

    private $app_key;

    private $redirect_uri;

    public function __construct($app_key, $redirect_uri)
    {
        $this->app_key = $app_key;
        $this->redirect_uri = urlencode($redirect_uri);

        $this->response_type = 'code';
        $this->force_auth = 'ture';
    }

    public function create(): string
    {
        return sprintf(self::OAUTH_URL, $this->response_type, $this->force_auth, $this->redirect_uri, $this->app_key);
    }
}