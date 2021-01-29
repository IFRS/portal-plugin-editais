<section class="editais">
    <div class="editais__main">
        <h2 class="editais__title">
            <?php
                _e('Editais', 'ifrs-portal-plugin-editais');

                if (is_tax('edital_category') && !isset($_POST['edital_category'])) {
                    printf(__(' na categoria %s', 'ifrs-portal-plugin-editais'), single_term_title('', false));
                }

            // if (is_tax('edital_status') && !isset($_POST['edital_status'])) {
            //     printf(__(' com o status %s', 'ifrs-portal-plugin-editais'), single_term_title('', false));
            // }

                if (is_search() && get_search_query()) {
                    printf(__('<small>(Resultados com o termo &ldquo;%s&rdquo;)</small>', 'ifrs-portal-plugin-editais'), get_search_query());
                }
            ?>
        </h2>

        <?php echo wpautop(get_option( 'ifrs_editais_intro' )); ?>

        <?php if (have_posts()) : ?>
            <?php load_template(plugin_dir_path(__FILE__) . 'loop.php'); ?>
        <?php else : ?>
                <?php if (is_search()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <p><?php printf(__('N&atilde;o foram encontrados Editais com os termos buscados.', 'ifrs-portal-plugin-editais'), single_term_title('', false)); ?></p>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        <p><strong><?php _e('Ops!'); ?></strong>&nbsp;<?php printf(__('N&atilde;o foram encontrados Editais publicados.', 'ifrs-portal-plugin-editais'), single_term_title('', false)); ?></p>
                    </div>
                <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="editais__aside">
        <?php load_template(plugin_dir_path(__FILE__) . 'filter.php'); ?>
    </div>
</section>
