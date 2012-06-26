<?php global $site; global $areas; ?>

<div class="wrap">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'I Am From Settings' ); ?></h2>
  <?php

  $content = array();

  foreach ( $areas as $area ) {
    $area_content = array(
      'title' => 'Name',
      'name' => $site->sitemeta->{$area->meta_key}->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->{$area->meta_key},
      'default_value' => $site->sitemeta->{$area->meta_key}->meta_value,
      'key' => 'meta_value'
    );

    $area_link = array(
      'title' => 'Link',
      'name' => $site->sitemeta->{$area->meta_key . '_link'}->meta_key,
      'type' => 'text',
      'object' => $site->sitemeta->{$area->meta_key . '_link'},
      'default_value' => $site->sitemeta->{$area->meta_key . '_link'}->meta_value,
      'key' => 'meta_value'
    );

    array_push( $content, $area_content );
    array_push( $content, $area_link );
  }

  \WpMvc\FormHelper::render_form( $site, $content );

  ?>
</div>
