<?php
require_once __DIR__ . '/../../buttons/SpaceButton.php';

/**
 * Class SpaceButtonTest
 */
class SpaceButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SpaceButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new SpaceButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insSpace" data-tag-open="&#160;" data-tag-close="" data-tarea="serendipity[body]">Space</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
