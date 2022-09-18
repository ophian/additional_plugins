<?php
require_once __DIR__ . '/../../buttons/GaccentButton.php';

/**
 * Class GaccentButtonTest
 */
class GaccentButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var GaccentButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new GaccentButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insgaccent" data-tag-open="&#x0300;" data-tag-close="" data-tarea="serendipity[body]">&nbsp;&#x0300;</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
