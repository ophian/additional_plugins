<?php
require_once __DIR__ . '/../../buttons/EmdashButton.php';

/**
 * Class EmdashButtonTest
 */
class EmdashButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EmdashButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new EmdashButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $html = sprintf(
            '<button class="wrap_selection" type="button" name="insemd" data-tag-open="%s" data-tag-close="%s" data-tarea="serendipity[body]">%s</button>',
            '&mdash;',
            '',
            '&mdash;'
        );
        $expected = '            ' . $html . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
