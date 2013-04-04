<?php

namespace SpriteGenerator;


/**
 * Generator options
 *
 */
class GeneratorOptions
{

  //////////////////////////////////////////////////////
  // GENERAL OPTIONS
  //////////////////////////////////////////////////////

  /**
   * Defines if trace messages is enabled or not
   *
   * @var bool
   */
  public $debug = true;



  //////////////////////////////////////////////////////
  // SOURCE OPTIONS
  //////////////////////////////////////////////////////

  /**
   * Source images folder
   *
   * @var string
   */
  public $src_images_folder;


  /**
   * Scan subfolders from source folder
   *
   * @var bool
   */
  public $src_scan_subfolders = false;



  //////////////////////////////////////////////////////
  // IMAGE OPTIONS
  //////////////////////////////////////////////////////

  /**
   * Image filename
   *
   * @var string
   */
  public $image_filename = 'sprite';


  /**
   * Image save path
   *
   * @var string
   */
  public $image_save_path;


  /**
   * Padding between images
   *
   * @var int
   */
  public $image_padding = 2;



  //////////////////////////////////////////////////////
  // CSS OPTIONS
  //////////////////////////////////////////////////////

  /**
   * CSS filename
   *
   * @var string
   */
  public $css_filename = 'sprite';


  /**
   * CSS save path
   *
   * @var string
   */
  public $css_save_path;


  /**
   * CSS append
   *
   * @var bool
   */
  public $css_append = false;


  /**
   * CSS classname prefix
   *
   * @var string
   */
  public $css_classname_prefix;


  /**
   * CSS Url prefix
   *
   * @var string
   */
  public $css_url_prefix;


  /**
   * CSS Template file path
   *
   * @var string
   */
  public $css_template_file;

}
