<?php


namespace HPT\Test\Grabber;


class CZCProductLoader implements \IGrabber
{
    /** @var string */
    protected $baseUrl;

    /** @var string[] */
    protected $searchedPageContent = array();

    /** @var string */
    protected $productPageContent = array();

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
        return rtrim($this->baseUrl,'/');
    }

    /**
     * @param string $productId
     *
     * @return string
     */
    protected function getUrlForProduct(string $productId)
    {
        return $this->getBaseUrl(). '/' . $productId . '/hledat';
    }

    /**
     * @param string $productId
     * @param string $contentData
     */
    protected function addSearchPageContent(string $productId, string $contentData)
    {
        $this->searchedPageContent[$productId] = $contentData;
    }

    /**
     * @param string $productId
     *
     * @return float|null
     */
    public function getPrice($productId)
    {
        $pageContent = $this->getSearchPageContent($productId);
        $price = null;
        if (preg_match_all('#.*<span class="price-vatin">(.*)&nbsp;Kč</span>.*#', $pageContent, $match)) {
            $price = floatval(str_replace("\xc2\xa0", '', $match[1][1]));
        }

        return $price;
    }

    /**
     * @param string $productId
     *
     * @return false|string
     */
    protected function getSearchPageContent(string $productId)
    {
        if (array_key_exists($productId, $this->searchedPageContent)) {
            return $this->searchedPageContent[$productId];
        }
        if (!($pageContent = @file_get_contents($this->getUrlForProduct($productId)))) throw new \RuntimeException('Unable load CZC page content for productId "' . $productId . '"');

        $this->searchedPageContent[$productId] = $pageContent;

        return $this->searchedPageContent[$productId];
    }

    /**
     * @param string $productId
     *
     * @return string|null
     */
    protected function getProductPageContent(string $productId): ?string
    {
        if (array_key_exists($productId, $this->productPageContent)) {
            return $this->productPageContent[$productId];
        }

        $searchContent = $this->getSearchPageContent($productId);
        $productPageContent = null;
        if (preg_match_all('#.*href="(.*)\/produkt".*#', $searchContent, $match)) {
            if (!($productPageContent = @file_get_contents($this->getBaseUrl() . reset($match[1]).'/produkt'))) throw new \RuntimeException('Unable load CZC page content for productId "' . $productId . '"');
        }

        $this->productPageContent[$productId] = $productPageContent;

        return $this->productPageContent[$productId];
    }

    /**
     * @param string $productId
     *
     * @return string|null
     */
    public function getName(string $productId)
    {
        $productPageContent = $this->getProductPageContent($productId);

        if (preg_match_all('#.*(title="Název produktu: )(.*)" .*#', $productPageContent, $match)) {
            return reset($match[2]);
        }

        return null;
    }

    /**
     * @param string $productId
     *
     * @return int|null
     */
    public function getScore(string $productId)
    {
        $productPageContent = $this->getProductPageContent($productId);
        if (preg_match_all('#.*<span class="rating__label">(.*)\s%.*#', $productPageContent, $match)) {
            return intval(reset($match[1]));
        }

        return null;
    }
}