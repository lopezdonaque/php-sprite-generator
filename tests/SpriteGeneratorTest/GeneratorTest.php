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
    $this->_output_path = sys_get_temp_dir() . '/' . uniqid();
    mkdir( $this->_output_path, 777 );
  }



  /**
   * Returns the default options
   *
   * @return \SpriteGenerator\GeneratorOptions
   */
  private function _get_default_options()
  {
    $options = new \SpriteGenerator\GeneratorOptions();
    $options->debug = false;
    $options->src_images_folder = $GLOBALS[ 'testdata_path' ] . '/icons';

    $options->image_filename = 'test';
    $options->image_save_path = $this->_output_path;

    $options->css_filename = 'test';
    $options->css_save_path = $this->_output_path;
    $options->css_append = false;
    $options->css_classname_prefix = 'prefix-';
    $options->css_url_prefix = 'url-prefix-';

    return $options;
  }



  /**
   * Test generator
   */
  public function test_generator()
  {
    $generator = new \SpriteGenerator\Generator( $this->_get_default_options() );
    $generator->output_image( \SpriteGenerator\Generator::OUTPUT_SAVE );
    $generator->output_css( \SpriteGenerator\Generator::OUTPUT_SAVE );

    $this->assertFileEquals( $this->_output_path . '/test.css', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.css' );
    $this->assertFileEquals( $this->_output_path . '/test.png', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.png' );
  }



  /**
   * Test generator using template file
   */
  public function test_template_file()
  {
    $options = $this->_get_default_options();
    $options->css_template_file = $GLOBALS[ 'testdata_path' ] . '/icons_template.tpl';

    $generator = new \SpriteGenerator\Generator( $options );
    $generator->output_image( \SpriteGenerator\Generator::OUTPUT_SAVE );
    $generator->output_css( \SpriteGenerator\Generator::OUTPUT_SAVE );

    $this->assertFileEquals( $this->_output_path . '/test.css', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.css' );
    $this->assertFileEquals( $this->_output_path . '/test.png', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.png' );
  }



  /**
   * Test append generated css to file
   */
  public function test_css_append()
  {
    // Copy the base css file
    copy( $GLOBALS[ 'testdata_path' ] . '/icons_base.css', $this->_output_path . '/test.css' );

    $options = $this->_get_default_options();
    $options->css_template_file = $GLOBALS[ 'testdata_path' ] . '/icons_template.tpl';
    $options->css_append = true;

    $generator = new \SpriteGenerator\Generator( $options );
    $generator->output_image( \SpriteGenerator\Generator::OUTPUT_SAVE );
    $generator->output_css( \SpriteGenerator\Generator::OUTPUT_SAVE );

    $this->assertFileEquals( $this->_output_path . '/test.css', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.css' );
    $this->assertFileEquals( $this->_output_path . '/test.png', $GLOBALS[ 'output_compare_path' ] . '/' . __FUNCTION__ . '/test.png' );
  }

}
