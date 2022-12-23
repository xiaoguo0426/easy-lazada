<h1 align="center"> easy-lazada </h1>

<p align="center"> .</p>

## Installing

使用之前，请认真阅读ladaza API 文档
https://open.lazada.com/doc/doc.htm?spm=a2o9m.11193494.0.0.191e266bRZ7fPZ&nodeId=27493&docId=118729#?nodeId=29586&docId=120248

```shell
$ composer require onetech/easy-lazada -vvv
```

## Usage

```php
use Onetech\EasyLazada\Lazada;

require 'vendor/autoload.php';

$lazada = new Lazada([
    'region' => 'TH',
    'app_key' => '',
    'app_secret' => '',
    'redirect_uri' => 'https://admin.erp.local',
    'debug' => true,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => sys_get_temp_dir() . '/foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);

//1. 创建授权地址，引导用户进行授权
echo $lazada->oauth->authorizer->create();

//2. 从redirect url中获取code值，去换取access_token等信息
$code = $_GET['code'];
echo $lazada->access_token->setCode($code)->getToken();//创建token

//$lazada->access_token->refresh();
//$lazada->access_token->getToken();
//$lazada->access_token->getRefreshToken();
//$lazada->access_token->delToken();


$order_id = 13800138000;
$res = $lazada->order->getOrder($order_id);
```

## TODO

1. 还有部分API还没有对接，PR welcome
2. 上传图片的API还没有对接成功
3. 其他未知问题

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/onetech/easy-lazada/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/onetech/easy-lazada/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and
PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT