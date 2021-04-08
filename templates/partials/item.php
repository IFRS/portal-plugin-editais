<?php the_post(); ?>

<section class="edital">
    <article class="edital__main">
        <h2 class="edital__title">
            <?php the_title(); ?>
            <br>
            <small>de <?php echo date_i18n( get_option( 'date_format' ), rwmb_meta( 'edital_date' ) ); ?></small>
        </h2>
        <div class="edital__content">
            <?php the_content(); ?>
        </div>
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
            <div class="table-responsive">
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
            </div>
        <?php endif; ?>
    </article>
    <aside class="edital__dados">
        <h3 class="edital__dados-title"><?php _e('Dados do Edital'); ?></h3>
        <p>
            <strong><?php _e('Data de Publica&ccedil;&atilde;o'); ?></strong>
            <br>
            <?php the_date(); ?> <?php _e('às'); ?> <?php echo get_the_time('G\hi'); ?>
        </p>
        <p>
            <strong><?php _e('&Uacute;ltima Modifica&ccedil;&atilde;o'); ?></strong>
            <br>
            <?php the_modified_date(); ?> <?php _e('às'); ?> <?php echo get_the_time('G\hi'); ?>
        </p>
        <p>
            <strong><?php _e('Categorias'); ?></strong>
            <br>
            <?php echo ($categorias = get_the_term_list( get_the_ID(), 'edital_category', '', ', ', '' )) ? $categorias : '-'; ?>
        </p>
        <p>
            <strong><?php _e('Status'); ?></strong>
            <br>
            <?php echo ($status = get_the_term_list( get_the_ID(), 'edital_status', '', ', ', '' )) ? $status : '-'; ?>
        </p>
    </aside>
</section>
