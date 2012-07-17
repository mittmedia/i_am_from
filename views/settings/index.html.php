<?php global $site; global $areas; global $content; ?>

<div class="wrap i_am_from">
  <div id="icon-options-general" class="icon32"><br></div>
  <h2><?php _e( 'I Am From Settings', 'i-am-from' ); ?></h2>
  <h3><?php _e( 'Configure Areas', 'i-am-from' ); ?></h3>
  <?php

  \WpMvc\FormHelper::render_form( $site, $content );

  ?>
</div>
