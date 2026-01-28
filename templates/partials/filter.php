<?php
  $categorias = get_terms(array(
    'taxonomy' => 'edital_category',
    'hide_empty' => false,
    'parent' => 0,
  ));

  $status = get_terms(array(
    'taxonomy' => 'edital_status',
    'hide_empty' => false,
    'orderby' => 'term_order',
  ));

  $has_filter = !empty($_POST['edital-data-inicio']) || !empty($_POST['edital-data-fim']) || !empty($_POST['edital_category']) || !empty($_POST['edital_status']);
?>
<aside class="editais__filter">
  <details <?php echo ($has_filter) ? 'open' : ''; ?>>
    <summary><?php _e('Filtros', 'ifrs-portal-plugin-editais'); ?></summary>

    <form action="<?php echo get_post_type_archive_link( 'edital' ); ?>" method="POST">
      <fieldset class="row">
        <legend class="col-12">Data do Edital</legend>
        <div class="form-group col-12 col-sm-6">
          <?php $field_id = uniqid(); ?>
          <label for="<?php echo $field_id; ?>" class="mb-sm-0 mr-sm-1">de</label>
          <input type="date" id="<?php echo $field_id; ?>" name="edital-data-inicio" value="<?php echo (!empty($_POST['edital-data-inicio'])) ? sanitize_text_field($_POST['edital-data-inicio']) : ''; ?>" class="form-control form-control-sm mr-sm-1">
          <small class="form-text text-muted">No formato <em>dia/mês/ano</em>, por exemplo 29/12/2008</small>
        </div>
        <div class="form-group col-12 col-sm-6">
          <?php $field_id = uniqid(); ?>
          <label for="<?php echo $field_id; ?>" class="mb-sm-0 mr-sm-1">até</label>
          <input type="date" id="<?php echo $field_id; ?>" name="edital-data-fim" value="<?php echo (!empty($_POST['edital-data-fim'])) ? sanitize_text_field($_POST['edital-data-fim']) : ''; ?>" class="form-control form-control-sm">
          <small class="form-text text-muted">No formato <em>dia/mês/ano</em>, por exemplo 29/12/2008</small>
        </div>
      </fieldset>
      <fieldset>
        <legend>Categoria</legend>
        <div class="form-group">
          <?php foreach ($categorias as $categoria): ?>
            <?php $field_id = uniqid(); ?>
            <?php $categoria_check = (!empty($_POST['edital_category']) && in_array($categoria->slug, $_POST['edital_category'])) || is_tax('edital_category', $categoria->slug); ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="edital_category[]" value="<?php echo $categoria->slug; ?>" id="<?php echo $field_id; ?>" <?php echo $categoria_check ? 'checked' : ''; ?>>
              <label class="form-check-label" for="<?php echo $field_id; ?>"><?php echo $categoria->name; ?></label>
            </div>
            <?php
              $filhos = get_terms(array(
                'taxonomy' => 'edital_category',
                'hide_empty' => false,
                'parent' => $categoria->term_id,
              ));
            ?>
            <?php foreach ($filhos as $filho) : ?>
              <?php $field_id = uniqid(); ?>
              <?php $filho_check = (!empty($_POST['edital_category']) && in_array($filho->slug, $_POST['edital_category'])) || is_tax('edital_category', $filho->slug); ?>
              <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" name="edital_category[]" value="<?php echo $filho->slug; ?>" id="<?php echo $field_id; ?>" <?php echo $filho_check ? 'checked' : ''; ?>>
                <label class="form-check-label" for="<?php echo $field_id; ?>"><?php echo $filho->name; ?></label>
              </div>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <fieldset>
        <legend>Status</legend>
        <?php foreach ($status as $stat): ?>
          <?php $field_id = uniqid(); ?>
          <?php $stat_check = (isset($_POST['edital_status']) && in_array($stat->slug, $_POST['edital_status'])) || is_tax('edital_status', $stat->slug); ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="edital_status[]" value="<?php echo $stat->slug; ?>" id="<?php echo $field_id; ?>" <?php echo $stat_check ? 'checked' : ''; ?>>
            <label class="form-check-label" for="<?php echo $field_id; ?>"><?php echo $stat->name; ?></label>
          </div>
        <?php endforeach; ?>
      </fieldset>

      <fieldset>
        <div class="btn-group" role="group" aria-label="Ações do Filtro">
          <input type="submit" value="Filtrar" class="btn btn-outline-primary">
          <a href="<?php echo get_post_type_archive_link( 'edital' ); ?>" class="btn btn-outline-secondary"><?php _e('Limpar', 'ifrs-portal-plugin-editais'); ?></a>
        </div>
      </fieldset>
    </form>
  </details>
</aside>
