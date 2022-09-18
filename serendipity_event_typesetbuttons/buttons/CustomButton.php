<?php
require_once 'Button.php';

/**
 * Class CustomButton
 */
class CustomButton extends Button
{
    /**
     * @var string
     */
    protected $open;

    /**
     * @var string
     */
    protected $close;

    /**
     * @return string
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @param string $close
     */
    public function setClose($close)
    {
        $this->close = $close;
    }

    /**
     * @return string
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param string $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->setOpenTag($this->getOpen());
        $this->setCloseTag($this->getClose());

        return parent::render();
    }

}
