<?php

namespace IAmFrom
{
  class SettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $current_site;
      global $site;
      global $areas;
      global $content;

      $site = \WpMvc\Site::find( $current_site->id );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if ( isset( $_POST['site']['sitemeta']['i_am_from'] ) && trim( $_POST['site']['sitemeta']['i_am_from']['meta_value'] ) != '' ) {
          $websafe_name = 'i_am_from_';
          $websafe_name .= \WpMvc\ApplicationHelper::unique_identifier( $_POST['site']['sitemeta']['i_am_from']['meta_value'] );

          $site->sitemeta->{$websafe_name} = \WpMvc\SiteMeta::virgin();
          $site->sitemeta->{$websafe_name}->site_id = $site->id;
          $site->sitemeta->{$websafe_name}->meta_key = $websafe_name;
          $site->sitemeta->{$websafe_name}->meta_value = $_POST['site']['sitemeta']['i_am_from']['meta_value'];

          $site->sitemeta->{$websafe_name . '_link'} = \WpMvc\SiteMeta::virgin();
          $site->sitemeta->{$websafe_name . '_link'}->site_id = $site->id;
          $site->sitemeta->{$websafe_name . '_link'}->meta_key = $websafe_name . '_link';
          $site->sitemeta->{$websafe_name . '_link'}->meta_value = $_POST['site']['sitemeta']['i_am_from_link']['meta_value'];
        }
        unset( $_POST['site']['sitemeta']['i_am_from'] );
        unset( $_POST['site']['sitemeta']['i_am_from_link'] );

        $site->takes_post( $_POST['site'] );

        $site->save();
        static::redirect_to( "{$_SERVER['REQUEST_URI']}&i_am_from_updated=1" );
      }

      $areas = array();

      $this->get_areas_from_sitemeta( $areas, $site );

      $content = array();

      $this->make_form_content_from_areas( $content, $areas, $site );
      
      $this->make_form_content_from_new_area( $content, $site );

      $this->render( $this, "index" );
    }

    private function get_areas_from_sitemeta( &$areas, $site )
    {
      $sitemeta_vars = get_object_vars( $site->sitemeta );

      foreach ( $sitemeta_vars as $key => $value ) {
        if ( preg_match( '/^((?!.*_link)i_am_from.*)$/', $key ) )
          array_push( $areas, $site->sitemeta->{$key} );
      }
    }
    private function make_form_content_from_areas( &$content, $areas, $site )
    {
      foreach ( $areas as $area ) {
        $content[] = array(
          'title' => __( 'Name' ),
          'name' => $site->sitemeta->{$area->meta_key}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key},
          'default_value' => $site->sitemeta->{$area->meta_key}->meta_value,
          'key' => 'meta_value'
        );

        $content[] = array(
          'title' => __( 'Link' ),
          'name' => $site->sitemeta->{$area->meta_key . '_link'}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key . '_link'},
          'default_value' => $site->sitemeta->{$area->meta_key . '_link'}->meta_value,
          'key' => 'meta_value'
        );

        $content[] = array(
          'title' => __( 'Delete' ),
          'type' => 'delete_action',
          'delete_objects' => array(
            $site->sitemeta->{$area->meta_key}->meta_key,
            $site->sitemeta->{$area->meta_key . '_link'}->meta_key
            ),
          'object' => $site->sitemeta->{$area->meta_key}
        );

        $content[] = array( 'type' => 'spacer' );
      }
    }

    private function make_form_content_from_new_area( &$content, &$site )
    {
      $site->sitemeta->i_am_from = \WpMvc\SiteMeta::virgin();
      $site->sitemeta->i_am_from->site_id = $site->id;
      $site->sitemeta->i_am_from->meta_key = 'i_am_from';
      $site->sitemeta->i_am_from->meta_value = '';

      $site->sitemeta->i_am_from_link = \WpMvc\SiteMeta::virgin();
      $site->sitemeta->i_am_from_link->site_id = $site->id;
      $site->sitemeta->i_am_from_link->meta_key = 'i_am_from_link';
      $site->sitemeta->i_am_from_link->meta_value = '';

      $content[] = array(
        'title' => __( 'Name' ),
        'name' => $site->sitemeta->i_am_from->meta_key,
        'type' => 'text',
        'object' => $site->sitemeta->i_am_from,
        'default_value' => $site->sitemeta->i_am_from->meta_value,
        'key' => 'meta_value'
      );

      $content[] = array(
        'title' => __( 'Link' ),
        'name' => $site->sitemeta->i_am_from_link->meta_key,
        'type' => 'text',
        'object' => $site->sitemeta->i_am_from_link,
        'default_value' => $site->sitemeta->i_am_from_link->meta_value,
        'key' => 'meta_value'
      );
    }
  }
}
