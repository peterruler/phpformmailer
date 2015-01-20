<?php
namespace ch\keepitnative\tests\formmailer\src\tests\src;

//require __DIR__.'/../../../src/input/Input.php';

use ch\keepitnative\formmailer\src\input\Input;

class InputTest extends \PHPUnit_Framework_TestCase
{
    public function testCanLoadFromGlobals()
    {
        $_GET['foo'] = 'Hello';

        $input = Input::createFromGlobals();

        $this->assertEquals($_GET['foo'], $input->get('foo'));
        $this->assertNull($input->get('bar'));
    }

    public function testCanReplaceInputValues()
    {
        $newInputs = [
            'get' => ['foo' => 'Hello'],
            'post' => ['bar' => 'World']
        ];

        $input = new Input();

        $input->replace($newInputs);

        $this->assertEquals($newInputs['get']['foo'], $input->get('foo'));
        $this->assertEquals($newInputs['post']['bar'], $input->post('bar'));
    }
}
