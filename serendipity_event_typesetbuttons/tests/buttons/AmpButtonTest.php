<?php
require_once __DIR__ . '/../../buttons/AmpButton.php';

/**
 * Class AmpButtonTest
 */
class AmpButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AccentButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new AmpButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insamp" data-tag-open="&" data-tag-close="" data-tarea="serendipity[body]">&</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
