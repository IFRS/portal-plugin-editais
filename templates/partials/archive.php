<?php do_action('ifrs_editais_before_archive'); ?>

<section class="editais">
  <?php echo do_blocks( '<!-- wp:query-title {"type":"archive","level":2,"showPrefix":false,"className":"mb-4"} /-->' ); ?>

  <?php echo wpautop(get_option( 'ifrs_editais_intro' )); ?>

  <?php load_template(plugin_dir_path(__FILE__) . 'filter.php'); ?>

  <?php if (have_posts()) : ?>
    <?php load_template(plugin_dir_path(__FILE__) . 'loop.php'); ?>
  <?php else : ?>
    <?php if (is_search()) : ?>
      <div class="alert alert-danger" role="alert">
        <p><?php _e('N&atilde;o foram encontrados Editais com os termos buscados.', 'ifrs-portal-plugin-editais'); ?></p>
      </div>
    <?php else : ?>
      <div class="alert alert-warning" role="alert">
        <strong><?php _e('Ops!'); ?></strong>&nbsp;<?php _e('N&atilde;o foram encontrados Editais publicados.', 'ifrs-portal-plugin-editais'); ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</section>

<?php do_action('ifrs_editais_after_archive'); ?>
