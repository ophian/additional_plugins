<?php
require_once 'Button.php';

/**
 * Class EmdashButton
 */
class EmdashButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insemd');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_EMDASH_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->setOpenTag('&mdash;');

        return parent::render();
    }

}
