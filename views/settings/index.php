<?php global $site; global $areas; global $content; ?>

<div class="wrap">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'I Am From Settings' ); ?></h2>
  <?php

  \WpMvc\FormHelper::render_form( $site, $content );

  ?>
</div>
