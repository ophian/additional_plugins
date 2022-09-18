<?php
require_once 'Button.php';

/**
 * Class button
 */
class CenterButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('inscenter');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_CENTER_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->addClass('lang-html');
        $this->setOpenTag('p style=\'text-align: center;\'');
        $this->setCloseTag('p');

        return parent::render();
    }

}
