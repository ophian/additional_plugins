<?php
require_once __DIR__ . '/../../buttons/AposButton.php';

/**
 * Class AposButtonTest
 */
class AposButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AposButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new AposButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insapos" data-tag-open="&apos;" data-tag-close="" data-tarea="serendipity[body]">&apos;</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
