<?php

namespace IAmFrom
{
  class SettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $site;
      global $areas;

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

      $this->render( $this, "index" );
    }
  }
}
