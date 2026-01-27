<?php ob_start(); ?>

<?php do_action('ifrs_editais_before_single'); ?>

<article class="edital">
  <!-- wp:post-title /-->

  <!-- wp:group {"className":"edital__meta","layout":{"type":"flex","flexWrap":"wrap"}} -->
  <div class="wp-block-group edital__meta">
    <!-- wp:paragraph -->
    <p><strong><?php _e('Data de Publica&ccedil;&atilde;o'); ?>:</strong> <?php the_date(); ?> <?php _e('às'); ?> <?php echo get_the_time('G\hi'); ?></p>
    <!-- /wp:paragraph -->

    <!-- wp:paragraph -->
    <p><strong><?php _e('&Uacute;ltima Modifica&ccedil;&atilde;o'); ?>:</strong> <?php the_modified_date(); ?> <?php _e('às'); ?> <?php echo get_the_time('G\hi'); ?></p>
    <!-- /wp:paragraph -->

    <!-- wp:paragraph -->
    <p><strong><?php _e('Categorias'); ?>:</strong> <?php echo ($categorias = get_the_term_list( get_the_ID(), 'edital_category', '', ', ', '' )) ? $categorias : '-'; ?></p>
    <!-- /wp:paragraph -->

    <!-- wp:paragraph -->
    <p><strong><?php _e('Status'); ?>:</strong> <?php echo ($status = get_the_term_list( get_the_ID(), 'edital_status', '', ', ', '' )) ? $status : '-'; ?></p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->

  <!-- wp:post-content /-->

  <?php
    $edital_files = array();
    $edital_files = array_merge(
      $edital_files,
      array_map(function($arr) {
          return $arr + ['date' => get_the_modified_date('U', $arr['ID']), 'group' => 'Edital'];
      }, rwmb_meta('edital_file' ))
    );
    $edital_files = array_merge(
      $edital_files,
      array_map(function($arr) {
          return $arr + ['date' => get_the_modified_date('U', $arr['ID']), 'group' => 'Retificações'];
      }, rwmb_meta('edital_retifica_files' ))
    );
    $edital_files = array_merge(
      $edital_files,
      array_map(function($arr) {
          return $arr + ['date' => get_the_modified_date('U', $arr['ID']), 'group' => 'Anexos'];
      }, rwmb_meta('edital_anexos_files' ))
    );
    $edital_files = array_merge(
      $edital_files,
      array_map(function($arr) {
          return $arr + ['date' => get_the_modified_date('U', $arr['ID']), 'group' => 'Publicações'];
      }, rwmb_meta('edital_publica_files' ))
    );
  ?>
  <?php if ( !empty( $edital_files ) ) : ?>
    <table class="table table-striped edital__table">
      <thead>
        <tr>
          <th><?php _e('Publicado em'); ?></th>
          <th><?php _e('Arquivo'); ?></th>
          <th><?php _e('Grupo'); ?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($edital_files as $key => $file) : ?>
        <tr>
          <td><?php echo date_i18n( 'd/m/Y H:i', $file['date'] ); ?></td>
          <td><a href="<?php echo $file['url']; ?>"><strong><?php echo $file['title']; ?></strong></a></td>
          <td><?php echo $file['group']; ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</article>

<?php do_action('ifrs_editais_after_single'); ?>

<?php echo do_blocks(ob_get_clean()); ?>
