<?php
require_once __DIR__ . '/../../buttons/EndashButton.php';

/**
 * Class EndashButtonTest
 */
class EndashButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EndashButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new EndashButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $html = sprintf(
            '<button class="wrap_selection" type="button" name="insend" data-tag-open="%s" data-tag-close="%s" data-tarea="serendipity[body]">%s</button>',
            '&ndash;',
            '',
            '&ndash;'
        );
        $expected = '            ' . $html . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
