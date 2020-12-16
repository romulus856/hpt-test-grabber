<?php


interface IGrabber
{

	/**
	 * @param string $productId
	 * @return float
	 */
	public function getPrice($productId);

    /**
     * @param string $productId
     *
     * @return string
     */
	public function getName(string $productId);

    /**
     * @param string $productId
     *
     * @return int
     */
	public function getScore(string $productId);

}
