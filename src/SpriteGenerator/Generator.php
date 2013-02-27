<?php

namespace SpriteGenerator;


/**
 * Generator
 *
 */
class Generator
{

  /**#@+
   * Output type constants
   *
   * @var string
   */
  /** Outputs to browser */
  const OUTPUT_VIEW = 'view';

  /** Outputs as binary to be downloaded */
  const OUTPUT_DOWNLOAD = 'download';

  /** Saves in path */
  const OUTPUT_SAVE = 'save';
  /**#@-*/


  /**
   * Image type to save as (for possible future modifications)
   *
   * @var string
   */
  private $_image_type = 'png';


  /**
   * Options
   *
   * @var GeneratorOptions
   */
  private $_options;


  /**
   * Accepted filetypes
   *
   * @var string[]
   */
  private $_accepted_filetypes = array( 'png', 'gif', 'jpg', 'jpeg' );


  /**
   * Contains images and image informations from source images folder
   *
   * @var array
   */
  private $_images = array();



  /**
   * Constructor
   *
   * @param GeneratorOptions $options
   */
  public function __construct( $options )
  {
    $this->_options = $options;

    /*// Check options
    $uid = uniqid();
    if( !$this->_options->image_save_path )
    {

    }*/
  }



  /**
   * Outputs image
   *
   * @param string $type
   */
  public function output_image( $type )
  {
    $this->_load_images_from_folder();
    $sprite = $this->_create_image();
    $path = null;

    switch( $type )
    {
      case self::OUTPUT_VIEW:
        header( 'Content-Type: image/' . $this->_image_type );
        break;

      case self::OUTPUT_SAVE:
        $path = $this->_options->image_save_path . '/' . $this->_options->image_filename . '.' . $this->_image_type;
        break;

      case self::OUTPUT_DOWNLOAD:
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: image/' . $this->_image_type );
        header( 'Content-Disposition: attachment; filename=' . $this->_options->image_filename . '.' . $this->_image_type );
        header( 'Content-Transfer-Encoding: binary' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . filesize( $sprite ) );
        ob_clean();
        flush();
        break;
    }

    $func = 'image' . $this->_image_type;
    $func( $sprite, $path );
    imagedestroy( $sprite );
  }



  /**
   * Outputs CSS
   *
   * @param string $type
   */
  public function output_css( $type )
  {
    $this->_load_images_from_folder();
    $css = $this->_create_css();

    switch( $type )
    {
      case self::OUTPUT_VIEW:
        header( 'Content-Type: text/css' );
        print $css;
        break;

      case self::OUTPUT_SAVE:
        $file = $this->_options->css_save_path . '/' . $this->_options->css_filename . '.css';
        $flags = $this->_options->css_append ? FILE_APPEND : 0;
        file_put_contents( $file, $css, $flags );
        break;

      case self::OUTPUT_DOWNLOAD:

        break;
    }

  }



  /**
   * Loads images from folder
   */
  private function _load_images_from_folder()
  {
    $this->_trace( 'Loading images from folder' );
    $this->_images = array();

    if( $dir_contents = scandir( $this->_options->src_images_folder ) )
    {
      foreach( $dir_contents as $file )
      {
        $ext = strtolower( substr( $file, strrpos( $file, '.' ) + 1 ) );

        // Ignore non-matching file extensions (it also ignores "." and "..")
        if( in_array( $ext, $this->_accepted_filetypes ) )
        {
          $filepath = $this->_options->src_images_folder . '/' . $file;
          $info = getimagesize( $filepath );
          $this->_images[] = array
          (
            'filename' => pathinfo( $file, PATHINFO_FILENAME ),
            'path' => $filepath,
            'width' => $info[0],
            'height' => $info[1],
            'mime' => $info[ 'mime' ],
            'type' => end( explode( '/', $info[ 'mime' ] ) )
          );
        }
      }
    }
  }



  /**
   * Generates and returns the CSS code
   *
   * @return string
   */
  private function _create_css()
  {
    $this->_trace( 'Creating CSS' );

    $total = $this->_get_total_size();
    $top = $total[ 'height' ];
    $css = '';

    $template = <<<TEXT
.[classname_prefix][image_name]
{
  background-image: url( [url_prefix][sprite_image_name] ) !important;
  background-position: [x]px [y]px !important;
  background-repeat: no-repeat;
  width: [w]px;
  height: [h]px;
}\n\n
TEXT;

    foreach( $this->_images as $image )
    {
      $data = array
      (
        'classname_prefix' => $this->_options->css_classname_prefix,
        'image_name' => $image[ 'filename' ],
        'url_prefix' => $this->_options->css_url_prefix,
        'sprite_image_name' => $this->_options->image_filename .  '.' . $this->_image_type,
        'x' => $image[ 'width' ] - $total[ 'width' ],
        'y' => $top - $total[ 'height' ],
        'w' => $image[ 'width' ],
        'h' => $image[ 'height' ]
      );

      $css_class = $template;

      foreach( $data as $key => $value )
      {
        $css_class = str_replace( '[' . $key . ']', $value, $css_class );
      }

      $css .= $css_class;
      $top -= ( $image[ 'height' ] + $this->_options->image_padding );
    }

    return $css;
  }



  /**
   * Generates and return the sprite image resource
   *
   * @return resource
   */
  private function _create_image()
  {
    $this->_trace( 'Creating image' );

    $total = $this->_get_total_size();
    $sprite = imagecreatetruecolor( $total[ 'width' ], $total[ 'height' ] );
    $transparent = imagecolorallocatealpha( $sprite, 0, 0, 0, 127 );
    imagesavealpha( $sprite, true );
    imagefill( $sprite, 0, 0, $transparent );
    $top = 0;

    foreach( $this->_images as $image )
    {
      $func = 'imagecreatefrom' . $image[ 'type' ];
      $img = $func( $image[ 'path' ] );
      imagecopy( $sprite, $img, ( $total[ 'width' ] - $image[ 'width' ] ), $top, 0, 0,  $image[ 'width' ], $image[ 'height' ] );
      $top += ( $image[ 'height' ] + $this->_options->image_padding );
    }

    return $sprite;
  }



  /**
   * Returns the calculated width and height needed for sprite image
   *
   * @return array
   */
  private function _get_total_size()
  {
    $arr = array( 'width' => 0, 'height' => 0 );

    foreach( $this->_images as $image )
    {
      if( $arr[ 'width' ] < $image[ 'width' ] )
      {
        $arr[ 'width' ] = $image[ 'width' ];
      }

      $arr[ 'height' ] += ( $image[ 'height' ] + $this->_options->image_padding );
    }

    return $arr;
  }



  /**
   * Prints message if debug is enabled
   *
   * @param string $message
   */
  private function _trace( $message )
  {
    if( $this->_options->debug )
    {
      print $message . PHP_EOL;
    }
  }

}
