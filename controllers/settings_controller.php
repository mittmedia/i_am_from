<?php

namespace IAmFrom
{
  class SettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $site;
      global $areas;
      global $content;

      $site = \WpMvc\Site::find( 1 );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $site->takes_post( $_POST['site'] );

        $site->save();

        static::redirect_to( "{$_SERVER['REQUEST_URI']}&i_am_from_updated=1" );
      }

      $sitemeta_vars = get_object_vars( $site->sitemeta );

      $areas = array();

      foreach ( $sitemeta_vars as $key => $value ) {
        if ( preg_match( '/^((?!.*_link)i_am_from.*)$/', $key ) )
          array_push( $areas, $site->sitemeta->{$key} );
      }

      $content = array();

      foreach ( $areas as $area ) {
        $area_content = array(
          'title' => __( 'Name' ),
          'name' => $site->sitemeta->{$area->meta_key}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key},
          'default_value' => $site->sitemeta->{$area->meta_key}->meta_value,
          'key' => 'meta_value'
        );

        $area_link = array(
          'title' => __( 'Link' ),
          'name' => $site->sitemeta->{$area->meta_key . '_link'}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key . '_link'},
          'default_value' => $site->sitemeta->{$area->meta_key . '_link'}->meta_value,
          'key' => 'meta_value'
        );

        array_push( $content, $area_content );
        array_push( $content, $area_link );
        array_push( $content, array( 'type' => 'spacer' ) );
      }

      $this->render( $this, "index" );
    }
  }
}
