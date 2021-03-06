<?php
namespace ch\keepitnative\tests\formmailer\src\tests\src;
use ch\keepitnative\formmailer\src\uploader\Uploader;
use ch\keepitnative\formmailer\src\error\Error;
use ch\keepitnative\formmailer\src\input\Input;

require_once __DIR__.'/../../../src/uploader/Uploader.php';
require_once __DIR__.'/../../../src/error/Error.php';
require_once __DIR__.'/../../../src/input/Input.php';
/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-01-12 at 16:35:20.
 */
class UploaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Uploader
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $error = new Error();
        $input = new Input();
        $this->object = new Uploader($input,$error);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::setErrors
     * @todo   Implement testSetErrors().
     */
    public function testSetErrors()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::getErrors
     * @todo   Implement testGetErrors().
     */
    public function testGetErrors()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::setInput
     * @todo   Implement testSetInput().
     */
    public function testSetInput()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::getInput
     * @todo   Implement testGetInput().
     */
    public function testGetInput()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::isIsSuccess
     * @todo   Implement testIsIsSuccess().
     */
    public function testIsIsSuccess()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::setIsSuccess
     * @todo   Implement testSetIsSuccess().
     */
    public function testSetIsSuccess()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::onSuccess
     * @todo   Implement testOnSuccess().
     */
    public function testOnSuccess()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ch\keepitnative\formmailer\src\uploader\Uploader::uploadFile
     * @todo   Implement testUploadFile().
     */
    public function testUploadFile()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
