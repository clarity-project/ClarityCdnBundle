<?php

namespace Clarity\CdnBundle\Tests\Filemanager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Clarity\CdnBundle\Filemanager\Filemanager;

/**
 * @author nikita prokurat <nickpro@tut.by>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class FilemanagerTest extends WebTestCase
{
    /**
     * @var Filemanager
     */
    private $fm;
    private static $image = 'testimage.png';
    private static $imageName = 'test_image_name';
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        clearstatcache();
        $this->createGdImage();
        $this->fm = static::$kernel->getContainer()->get('clarity_cdn.filemanager');
        parent::setUp();
    }

    public function testUpload()
    {
        $this->assertTrue(is_file(__DIR__ . '/' . self::$image));

        if (is_file(__DIR__ . '/' . self::$image)) {

            $image = new UploadedFile(
                __DIR__ . '/' . self::$image,
                self::$imageName,
                null,
                filesize(__DIR__ . '/' . self::$image),
                UPLOAD_ERR_OK,
                true
            );

            $this->assertEquals($image->getClientOriginalName(), self::$imageName);
            
            $object = $this->fm->upload($image, 'cdn_test');
            
            $this->assertTrue(is_file($object->getFullPath()));
            $this->assertTrue(is_readable($object->getFullPath()));
            $this->assertEquals($object->getSchemaPath(), "image://cdn_test/" . self::$image);
            
            $this->assertTrue(is_file($this->fm->get($object->getSchemaPath())->getFullPath()));
            
            $this->fm->remove($object->getSchemaPath());
            
            $this->assertFalse(is_file($this->fm->get($object->getSchemaPath())));
        }
    }

    private function createGdImage()
    {
        try {
            $im = imagecreatetruecolor(100, 100);
            ob_start();
                imagejpeg($im, null, 85);
                $contents = ob_get_contents();
            ob_end_clean();

            imagedestroy($im);

            $fh = fopen(__DIR__ . '/' . self::$image, "a+");
            fwrite($fh, $contents);
            fclose($fh);
            
            return true;
        } catch (\Exception $e) {
            $this->assertTrue(false, "Could not create image");
            return false;
        }
    }

    public function tearDown()
    {
        if (is_file(__DIR__ . '/' . self::$image)) {
            @unlink(__DIR__ . '/' . self::$image);
        }
        unset($this->fm);
        parent::tearDown();
    }
}
