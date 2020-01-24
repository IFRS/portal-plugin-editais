<?php
    $categorias = get_terms(array(
        'taxonomy' => 'edital_category',
        'hide_empty' => false,
        'orderby' => 'term_order',
    ));

    $status = get_terms(array(
        'taxonomy' => 'edital_status',
        'hide_empty' => false,
        'orderby' => 'term_order',
    ));
?>
<aside class="filter">
    <h3 class="filter__title"><?php _e('Filtros'); ?></h3>

    <form action="<?php echo get_post_type_archive_link( 'edital' ); ?>" method="POST" class="filter__form">
        <fieldset>
            <legend>Categoria</legend>
            <?php foreach ($categorias as $categoria): ?>
                <?php $field_id = uniqid(); ?>
                <?php $categoria_check = (isset($_POST['edital_category']) && in_array($categoria->slug, $_POST['edital_category'])) || is_tax('edital_category', $categoria->slug); ?>
                <div class="form-check<?php echo ($categoria->parent !== 0) ? ' ml-3' : '' ?>">
                    <input class="form-check-input" type="checkbox" name="edital_category[]" value="<?php echo $categoria->slug; ?>" id="<?php echo $field_id; ?>" <?php echo $categoria_check ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="<?php echo $field_id; ?>"><?php echo $categoria->name; ?></label>
                </div>
            <?php endforeach; ?>
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

        <div class="btn-group" role="group" aria-label="Ações do Filtro">
            <input type="submit" value="Filtrar" class="btn btn-primary">
            <a href="<?php echo get_post_type_archive_link( 'edital' ); ?>" class="btn btn-outline-secondary"><?php _e('Limpar Filtros', 'ifrs-portal-plugin-editais'); ?></a>
        </div>
    </form>
</aside>
