<?php

namespace SpriteGeneratorTest;


/**
 * Test for "Generator" class
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * Path where the generated files will be saved
   *
   * @var string
   */
  private $_output_path;



  /**
   * Prepares the environtment
   */
  protected function setUp()
  {
    $this->_output_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid();
    mkdir( $this->_output_path, 777 );
  }



  /**
   * Test one
   */
  public function test_one()
  {
    $options = new \SpriteGenerator\GeneratorOptions();
    $options->debug = false;
    $options->src_images_folder = $GLOBALS[ 'testdata_path' ] . DIRECTORY_SEPARATOR . 'icons';

    $options->image_filename = 'test';
    $options->image_save_path = $this->_output_path;

    $options->css_filename = 'test';
    $options->css_save_path = $this->_output_path;
    $options->css_append = false;
    $options->css_classname_prefix = 'prefix-';
    $options->css_url_prefix = 'url-prefix-';

    $generator = new \SpriteGenerator\Generator( $options );
    $generator->output_image( \SpriteGenerator\Generator::OUTPUT_SAVE );
    $generator->output_css( \SpriteGenerator\Generator::OUTPUT_SAVE );

    $this->assertFileEquals( $this->_output_path . '/test.css', $GLOBALS[ 'output_compare_path' ] . '/test_one/test.css' );
    $this->assertFileEquals( $this->_output_path . '/test.png', $GLOBALS[ 'output_compare_path' ] . '/test_one/test.png' );
  }

}
