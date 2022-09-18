<?php
require_once 'Button.php';

/**
 * Class EndashButton
 */
class EndashButton extends Button
{
    /**
     * Constructor
     *
     * @param string $textarea
     */
    public function __construct($textarea)
    {
        parent::__construct($textarea);
        $this->setName('insend');
        $this->setValue(PLUGIN_EVENT_TYPESETBUTTONS_ENDASH_BUTTON);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addClass('wrap_selection');
        $this->setOpenTag('&ndash;');

        return parent::render();
    }

}
