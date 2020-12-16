<?php


namespace HPT\Test\Grabber;


class OutputWriter implements \IOutput
{
    const PRODUCT_PRICE_KEY = 'price';

    /** @var array */
    private $productsData = array();

    /**
     * @return array
     */
    private function getProductsData()
    {
        return $this->productsData;
    }

    /**
     * @param string     $productId
     * @param float|null $price
     */
    public function setProductPrice(string $productId, ?float $price):void
    {
        $this->productsData[$productId][self::PRODUCT_PRICE_KEY] = $price;
    }

    /**
     * @return false|string
     */
    public function getJson()
    {
        return json_encode($this->getProductsData());
    }
}