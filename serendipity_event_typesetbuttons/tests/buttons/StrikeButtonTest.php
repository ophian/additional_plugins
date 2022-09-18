<?php
require_once __DIR__ . '/../../buttons/StrikeButton.php';

/**
 * Class StrikeButtonTest
 */
class StrikeButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StrikeButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new StrikeButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection lang-html" type="button" name="insstrike" data-tag-open="p style=\'text-decoration: line-through;\'" data-tag-close="p" data-tarea="serendipity[body]">Strike</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
