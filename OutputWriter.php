<?php


namespace HPT\Test\Grabber;


class OutputWriter implements \IOutput
{
    const PRODUCT_PRICE_KEY = 'price';
    const PRODUCT_NAME_KEY = 'name';
    const PRODUCT_SCORE_KEY = 'score';

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

    public function setProductName(string $productId, ?string $name): void
    {
        $this->productsData[$productId][self::PRODUCT_NAME_KEY] = $name;
    }

    public function setProductScore(string $productId, ?int $score): void
    {
        $this->productsData[$productId][self::PRODUCT_SCORE_KEY] = $score;
    }
}