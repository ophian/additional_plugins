<?php
require_once __DIR__ . '/../../buttons/BulletButton.php';

/**
 * Class BulletButtonTest
 */
class BulletButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BulletButton
     */
    protected $button;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->button = new BulletButton('serendipity[body]');
    }

    /**
     * @test
     */
    public function render()
    {
        $expected = '            <button class="wrap_selection" type="button" name="insbull" data-tag-open="&bull;" data-tag-close="" data-tarea="serendipity[body]">&bull;</button>' . PHP_EOL;
        $this->assertEquals($expected, $this->button->render());
    }

}
