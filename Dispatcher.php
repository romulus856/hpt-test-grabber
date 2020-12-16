<?php


class Dispatcher
{

    const INPUT_FILE_PATH = __DIR__.'/vstup.txt';

    /**
     * @var IGrabber
     */
    private $grabber;

    /**
     * @var IOutput
     */
    private $output;

    /**
     * @param IGrabber $grabber
     * @param IOutput  $output
     */
    public function __construct(IGrabber $grabber, IOutput $output)
    {
        $this->grabber = $grabber;
        $this->output = $output;
    }

    /**
     * @return IGrabber
     */
    public function getGrabber()
    {
        return $this->grabber;
    }

    /**
     * @return IOutput
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return string JSON
     */
    public function run()
    {
        $productIds = $this->loadProductFromInputFile();
        if (!is_array($productIds)) return $this->getOutput()->getJson();

        foreach ($productIds as $productId) {
            $this->getOutput()->setProductPrice($productId, $this->getGrabber()->getPrice($productId));
        }

        return $this->getOutput()->getJson();
    }

    /**
     * @return false|string[]
     */
    protected function loadProductFromInputFile()
    {
        if (!file_exists(self::INPUT_FILE_PATH)) throw new \RuntimeException('Input file on path "' . self::INPUT_FILE_PATH . '" does not exist!');
        if (!($content = @file_get_contents(self::INPUT_FILE_PATH))) throw new \RuntimeException('Unable to load contents of file on path "' . self::INPUT_FILE_PATH, '"');

        return explode("\r\n", trim($content));
    }

}
