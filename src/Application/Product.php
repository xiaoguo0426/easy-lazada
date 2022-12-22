<?php

namespace Onetech\EasyLazada\Application;

use Onetech\EasyLazada\Core\Api;

class Product extends Api
{
    /**
     * 增加或减少一种或多种现有产品的可销售数量
     * @document https://open.lazada.com/apps/doc/api?path=/product/stock/sellable/adjust
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function adjustSellableQuantity(string $payload)
    {
        $uri = 'product/stock/sellable/adjust';

        $params = [
            'payload' => $payload
        ];

        return $this->post($uri, $params);
    }

    /**
     * 创建单个新产品
     * @document https://open.lazada.com/apps/doc/api?path=/product/create
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function createProduct(string $payload)
    {
        $uri = 'product/create';

        $params = [
            'payload' => $payload
        ];

        return $this->post($uri, $params);
    }

    /**
     * 停用产品或产品对应的 SKU
     * @document https://open.lazada.com/apps/doc/api?path=/product/deactivate
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function deactivateProduct(string $apiRequestBody)
    {
        $uri = 'product/deactivate';

        $params = [
            'apiRequestBody' => $apiRequestBody
        ];

        return $this->post($uri, $params);
    }

    /**
     * 退出产品实验
     * @document https://open.lazada.com/apps/doc/api?path=/products/experiment/exit
     * @param string $imageUrl
     * @param string $startDate
     * @param string $endDate
     * @param int $productId
     * @param int $sellerId
     * @param string $expType
     * @param string $venture
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function exitExperiment(string $imageUrl, string $startDate, string $endDate, int $productId, int $sellerId, string $expType, string $venture)
    {
        $uri = 'products/experiment/exit';

        $params = [
            'imageUrl' => $imageUrl,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'productId' => $productId,
            'sellerId' => $sellerId,
            'expType' => $expType,
            'venture' => $venture,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 获取实验数据统计
     * @document https://open.lazada.com/apps/doc/api?path=/products/experiment/getdata
     * @param int $productId
     * @param int $sellerId
     * @param string $expType
     * @param string $venture
     * @param string $imageUrl
     * @param string $startDate
     * @param string $endDate
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getImageExperimentData(int $productId, int $sellerId, string $expType, string $venture, string $imageUrl, string $startDate, string $endDate)
    {
        $uri = 'products/experiment/getdata';

        $params = [
            'payload' => $productId,
            'sellerId' => $sellerId,
            'expType' => $expType,
            'venture' => $venture,
            'imageUrl' => $imageUrl,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return $this->get($uri, $params);
    }

    /**
     * 系统中按页面索引检索所有产品品牌
     * @document https://open.lazada.com/apps/doc/api?path=/category/brands/query
     * @param string $startRow
     * @param string $pageSize
     * @param string $languageCode
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getBrandByPages(string $startRow, string $pageSize, string $languageCode)
    {
        $uri = 'category/brands/query';

        $params = [
            'startRow' => $startRow,
            'pageSize' => $pageSize,
            'languageCode' => $languageCode,
        ];

        return $this->get($uri, $params);
    }

    /**
     * 获取指定产品类别的属性列表
     * @document https://open.lazada.com/apps/doc/api?path=/category/attributes/get
     * @param string $primary_category_id
     * @param string $language_code
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getCategoryAttributes(string $primary_category_id, string $language_code)
    {
        $uri = 'category/attributes/get';

        $params = [
            'primary_category_id' => $primary_category_id,
            'language_code' => $language_code
        ];

        return $this->get($uri, $params);
    }

    /**
     * 通过产品标题获取产品的类别建议
     * @document https://open.lazada.com/apps/doc/api?path=/product/category/suggestion/get
     * @param string $product_name
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getCategorySuggestion(string $product_name)
    {
        $uri = 'product/category/suggestion/get';

        $params = [
            'product_name' => $product_name
        ];

        return $this->get($uri, $params);
    }

    /**
     * 检索系统中所有产品类别的列表
     * @param string $language_code
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getCategoryTree(string $language_code)
    {
        $uri = 'category/tree/get';

        $params = [
            'language_code' => $language_code
        ];

        return $this->get($uri, $params);
    }

    /**
     * 通过 ItemId 或 SellerSku 获取单品
     * @document https://open.lazada.com/apps/doc/api?path=/product/item/get
     * @param string $item_id
     * @param string $seller_sku
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getProductItem(string $item_id, string $seller_sku)
    {
        $uri = 'product/item/get';

        $params = [
            'item_id' => $item_id,
            'seller_sku' => $seller_sku,
        ];

        return $this->get($uri, $params);
    }

    /**
     * 获取指定产品的详细信息
     * @document https://open.lazada.com/apps/doc/api?path=/products/get
     * @param string $filter
     * @param string $update_before
     * @param string $create_before
     * @param string $offset
     * @param string $create_after
     * @param string $update_after
     * @param string $limit
     * @param string $options
     * @param string $sku_seller_list
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getProducts(string $filter, string $update_before, string $create_before, string $offset, string $create_after, string $update_after, string $limit, string $options, string $sku_seller_list)
    {
        $uri = 'products/get';

        $params = [
            'filter' => $filter,
            'update_before' => $update_before,
            'create_before' => $create_before,
            'offset' => $offset,
            'create_after' => $create_after,
            'update_after' => $update_after,
            'limit' => $limit,
            'options' => $options,
            'sku_seller_list' => $sku_seller_list,
        ];

        return $this->get($uri, $params);
    }

    /**
     * 获取所列出项目的质量控制状态
     * @document https://open.lazada.com/apps/doc/api?path=/product/qc/status/get
     * @param string $offset
     * @param string $limit
     * @param array $seller_skus
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getQcStatus(string $offset, string $limit, array $seller_skus)
    {
        $uri = 'product/qc/status/get';

        $params = [
            'offset' => $offset,
            'limit' => $limit,
            'seller_skus' => $this->array2string($seller_skus),
        ];

        return $this->get($uri, $params);
    }

    /**
     * 从系统中获取 MigrateImages API 的返回信息
     * @document https://open.lazada.com/apps/doc/api?path=/image/response/get
     * @param string $batch_id
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getResponse(string $batch_id)
    {
        $uri = 'image/response/get';

        $params = [
            'batch_id' => $batch_id
        ];

        return $this->get($uri, $params);
    }

    /**
     * 平台将通过该接口提供产品数量限制信息
     * @document https://open.lazada.com/apps/doc/api?path=/image/response/get
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getSellerItemLimit()
    {
        $uri = 'product/seller/item/limit';

        return $this->get($uri);
    }

    /**
     * 获取没有关键属性的产品。（仅限跨境卖家）
     * @document https://open.lazada.com/apps/doc/api?path=/product/unfilled/attribute/get
     * @param int $page_index
     * @param string $attribute_tag
     * @param int $page_size
     * @param string $language_code
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function getUnfilledAttributeItem(int $page_index, string $attribute_tag, int $page_size, string $language_code)
    {
        $uri = 'product/unfilled/attribute/get';

        $params = [
            'page_index' => $page_index,
            'attribute_tag' => $attribute_tag,
            'page_size' => $page_size,
            'language_code' => $language_code,
        ];
        return $this->get($uri, $params);
    }

    /**
     * 将产品放入特定的 A/B 测试实验中
     * @document https://open.lazada.com/apps/doc/api?path=/products/experiment/join
     * @param string $imageUrl
     * @param string $startDate
     * @param string $endDate
     * @param int $productId
     * @param int $sellerId
     * @param string $expType
     * @param string $venture
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function joinExperiment(string $imageUrl, string $startDate, string $endDate, int $productId, int $sellerId, string $expType, string $venture)
    {
        $uri = 'products/experiment/join';

        $params = [
            'imageUrl' => $imageUrl,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'productId' => $productId,
            'sellerId' => $sellerId,
            'expType' => $expType,
            'venture' => $venture,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 将单个图像从外部站点迁移到 Lazada 站点。允许的图像格式为 JPG 和 PNG。图像文件的最大大小为 1MB。
     * @document https://open.lazada.com/apps/doc/api?path=/image/migrate
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function migrateImage(string $payload)
    {
        $uri = 'image/migrate';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 将多个图像从外部站点迁移到 Lazada 站点。允许的图像格式为 JPG 和 PNG。图像文件的最大大小为 1MB。一次调用最多可以迁移8张图片。
     * @document https://open.lazada.com/apps/doc/api?path=/images/migrate
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function migrateImages(string $payload)
    {
        $uri = 'images/migrate';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 查询产品的实验配置
     * @document https://open.lazada.com/apps/doc/api?path=/products/experiment/getconfig
     * @param int $productId
     * @param string $venture
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function queryProductExperimentConfiguration(int $productId, string $venture)
    {
        $uri = 'products/experiment/getconfig';

        $params = [
            'productId' => $productId,
            'venture' => $venture,
        ];

        return $this->get($uri, $params);
    }

    /**
     * 删除现有产品、一种产品中的某些 SKU 或一种产品中的所有 SKU。系统在一个请求中最多支持 50 个 SellerSkus。
     * @document https://open.lazada.com/apps/doc/api?path=/product/remove
     * @param array $seller_sku_list
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function removeProduct(array $seller_sku_list)
    {
        $uri = 'product/remove';

        $params = [
            'seller_sku_list' => $seller_sku_list,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 通过关联一个或多个图像 URL 来为现有产品设置图像
     * https://open.lazada.com/apps/doc/api?path=/images/set
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function setImages(string $payload)
    {
        $uri = 'images/set';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 更新一种或多种现有产品的价格和数量。最多可以更新50个产品，但推荐20个
     * @document https://open.lazada.com/apps/doc/api?path=/product/price_quantity/update
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function updatePriceQuantity(string $payload)
    {
        $uri = 'product/price_quantity/update';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 更新现有产品的属性或 SKU
     * @document https://open.lazada.com/apps/doc/api?path=/product/update
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function updateProduct(string $payload)
    {
        $uri = 'product/update';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 更新一种或多种现有产品的可销售数量。最多可以更新50个产品，但推荐20个。
     * @document https://open.lazada.com/apps/doc/api?path=/product/stock/sellable/update
     * @param string $payload
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function updateSellableQuantity(string $payload)
    {
        $uri = 'product/stock/sellable/update';

        $params = [
            'payload' => $payload,
        ];

        return $this->post($uri, $params);
    }

    /**
     * 将单个图像文件上传到 Lazada 站点。允许的图像格式为 JPG 和 PNG。图像文件的最大大小为 1MB
     * @document https://open.lazada.com/apps/doc/api?path=/image/upload
     * @param string $image
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed
     */
    public function uploadImage(string $image)
    {
        $uri = 'image/upload';

        $params = [
            'image' => fopen($image, 'rb')
        ];

        return $this->upload($uri, $params);
    }
}