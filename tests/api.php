<?php

use Onetech\EasyLazada\Lazada;

require '../vendor/autoload.php';

$lazada = new Lazada([
    'region' => 'th',
    'app_key' => '',
    'app_secret' => '',
    'redirect_uri' => 'https://backend.erp.local/lazada/callback',
    'debug' => true,
    'sandbox' => true,
    'log' => [
        'name' => 'foundation',
        'file' => './foundation.log',
        'level' => 'debug',
        'permission' => 0777,
    ],
    'cache' => new Doctrine\Common\Cache\FilesystemCache(sys_get_temp_dir())
]);

//$order_id = '';
//$res = $lazada->order->getOrder(279438600134006);

try {
    $res = $lazada->order->getOrders([
        'created_after' => '2022-03-10T09:00:00+08:00',
        'update_after' => '2022-03-17T09:00:00+08:00',
        'limit' => 5,
        'status' => 'returned'// unpaid未支付, pending待处理, canceled取消, ready_to_ship待交付物流, delivered妥投, returned退回, shipped运输在途, failed失败, topack打包,toship待交付物流,shipping运输在途 and lost丢失
    ]);
    var_dump($res);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e->getMessage());
}

//try {
//    $res = $lazada->order->getOrderItems(623246300764242);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//}
//
//var_dump($res);

//try {
//    $res = $lazada->order->getMultipleOrderItems([
//        279438600134006,
//        279433200134006
//    ]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//}


//$orderItems = [
//    279438600234006
//];
//try {
//    $res = $lazada->order->setStatusToPackedByMarketplace('Aramax', $orderItems);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}


$orderItems = [
    278751600264014
];
//try {
//    $res = $lazada->order->setStatusToReadyToShip('dropship', $orderItems, 'Aramax', '12345678');
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->order->setStatusToCanceled(279433200234006, 15, 'out of stock');
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->order->getDocument('shippingLabel', [279430200264014]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}
//
//try {
//    $res = $lazada->order->getAwbDocumentHtml([532417706064242]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}
//
//try {
//    $res = $lazada->order->getAwbDocumentPDF([532417706064242]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->order->setInvoiceNumber(279430200264014, 'abcd1231231');
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//file_put_contents('./2.png');

//try {
//    $res = $lazada->product->uploadImage(file_get_contents('./2.png'));
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}


//try {
//    $order_id = '200067700954012';
//    $locale = 'en';
//    $ofcPackageIdList = [];
//
//    $res = $lazada->logistics->getOrderTrace($order_id, $locale, $ofcPackageIdList);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->logistics->getShipmentProviders();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->batchQueryFollowStatus([
//        100000154012
//    ]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getMultiWarehouseBySeller([
//        'warehouse'
//    ]);
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getPickUpStoreList();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getSeller();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getSellerPerformance();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getSellerPolicyFetch('SG', 'en');
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->getWarehouseBySellerId();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->seller->queryWarehouseDetailInfoBySellerId();
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}

//try {
//    $res = $lazada->data_moat->computeRisk(time(), 'ERP System', '113.111.140.172', '0ca175b9c0f726a831d895e269332461');
//    var_dump($res);
//} catch (\GuzzleHttp\Exception\GuzzleException $e) {
//    var_dump($e->getMessage());
//}