<?php

namespace SpriteGenerator;


/**
 * Generator commands
 *
 */
class GeneratorCommand extends \Symfony\Component\Console\Command\Command
{

  /**
   * Configure
   */
  protected function configure()
  {
    $this
      ->setName( 'generator:generate' )
      ->setDescription( 'Generator actions' )
      ->addArgument( 'src_images_folder', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Source images path' )
      ->addOption( 'image_filename', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Image filename' )
      ->addOption( 'image_save_path', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Image save path' )
      ->addOption( 'css_filename', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS filename' )
      ->addOption( 'css_save_path', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS save path' )
      ->addOption( 'css_append', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS append (default to false)' )
      ->addOption( 'css_classname_prefix', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS classname prefix' )
      ->addOption( 'css_url_prefix', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS URL prefix' )
      ->addOption( 'css_template_file', null, \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'CSS template file' )
      ->addOption( 'debug', null, \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'If set, enables trace messages' )
      ->setHelp( "Executes generator actions." );
  }



  /**
   * Execute
   *
   * @param \Symfony\Component\Console\Input\InputInterface   $input
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   * @return int|void
   * @throws \InvalidArgumentException
   */
  protected function execute( \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
  {
    $debug = ( $input->getOption( 'debug' ) ) ? true : false;

    $src_images_folder = $input->getArgument( 'src_images_folder' );

    $options = new \SpriteGenerator\GeneratorOptions();
    $options->debug = $debug;
    $options->src_images_folder = $src_images_folder;

    $options->image_filename = $input->getOption( 'image_filename' );
    $options->image_save_path = $input->getOption( 'image_save_path' );

    $options->css_filename = $input->getOption( 'css_filename' );
    $options->css_save_path = $input->getOption( 'css_save_path' );
    $options->css_append = $input->getOption( 'css_append' ) ?: false;
    $options->css_classname_prefix = $input->getOption( 'css_classname_prefix' );
    $options->css_url_prefix = $input->getOption( 'css_url_prefix' );
    $options->css_template_file = $input->getOption( 'css_template_file' );

    $generator = new \SpriteGenerator\Generator( $options );
    $generator->output_image( \SpriteGenerator\Generator::OUTPUT_SAVE );
    $generator->output_css( \SpriteGenerator\Generator::OUTPUT_SAVE );
  }

}
