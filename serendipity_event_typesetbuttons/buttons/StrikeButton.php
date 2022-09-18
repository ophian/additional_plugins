<?php
require_once 'Button.php';

/**
 * Class button
 */
class StrikeButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insstrike');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_STRIKE_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->addClass('lang-html');
        $this->setOpenTag('del');
        $this->setCloseTag('del');

        return parent::render();
    }
}
