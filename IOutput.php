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
}
