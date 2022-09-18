<?php
require_once __DIR__ . '/../../buttons/CenterButton.php';

/**
 * Class CenterButtonTest
 */
class CenterButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CenterButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new CenterButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection lang-html" type="button" name="inscenter" data-tag-open="p style=\'text-align: center;\'" data-tag-close="p" data-tarea="serendipity[body]">Center</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
