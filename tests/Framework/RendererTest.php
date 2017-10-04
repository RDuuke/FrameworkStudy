<?php
namespace Tests\Framework;

use Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->renderer = new Renderer();
        $this->renderer->addPath(__DIR__ . '/views');

    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('home', __DIR__ . '/views');
        $content = $this->renderer->render('@home/demo');
        $this->assertEquals("Hi guys!!", $content);
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals("Hi guys!!", $content);
    }

    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoparams', ["name" => "Juan"]);
        $this->assertEquals("Saludos Juan", $content);
    }

    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('name', 'Juan');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals("Saludos Juan", $content);
    }


}