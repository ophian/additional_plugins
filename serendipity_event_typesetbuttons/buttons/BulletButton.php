<?php
require_once 'Button.php';

/**
 * Class BulletButton
 */
class BulletButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insbull');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_BULLET_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->setOpenTag('&bull;');

        return parent::render();
    }

}
