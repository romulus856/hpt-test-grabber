<?php


interface IOutput
{

    /**
     * @return string
     */
    public function getJson();

    /**
     * @param string     $productId
     * @param float|null $price
     */
    public function setProductPrice(string $productId, ?float $price): void;

    /**
     * @param string      $productId
     * @param string|null $name
     */
    public function setProductName(string $productId, ?string $name): void;

    /**
     * @param string   $productId
     * @param int|null $score
     */
    public function setProductScore(string $productId, ?int $score): void;
}
