<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class FBL extends Api
{

    public function cancelFulfillmentOrderforMCL()
    {
        $uri = '';

        $params = [];

        $this->post($uri, $params);
    }

}