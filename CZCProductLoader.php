<?php


namespace HPT\Test\Grabber;


class CZCProductLoader implements \IGrabber
{
    /** @var string */
    protected $baseUrl;

    /**
     * CZCProductLoader constructor.
     *
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $productId
     *
     * @return string
     */
    protected function getUrlForProduct(string $productId)
    {
        return rtrim($this->getBaseUrl(),'/').'/'.$productId.'/hledat';
    }

    /**
     * @param string $productId
     *
     * @return float|null
     */
    public function getPrice($productId)
    {
        if(!($pageContent = @file_get_contents($this->getUrlForProduct($productId)))) throw new \RuntimeException('Unable load CZC page content for productId "'.$productId.'"');
        $price = null;
        if(preg_match_all('#.*<span class="price-vatin">(.*)&nbsp;Kč</span>.*#',$pageContent,$match))
        {
            $price = floatval(str_replace("\xc2\xa0",'',$match[1][1]));
        }

        return $price;
    }
}