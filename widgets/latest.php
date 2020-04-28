<?php
class Editais_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'editais_widget',
            __( 'Últimos Editais', 'ifrs-portal-plugin-editais' ),
            array( 'description' => __( 'Últimos Editais cadastrados ou atualizados.', 'ifrs-portal-plugin-editais' ), )
        );
    }

    private $widget_fields = array();

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $query = array(
            'orderby' => 'modified',
            'order' => 'DESC',
            'post_type' => 'edital',
            'posts_per_page' => 5
        );
        $latest_editais = new WP_Query($query);

        if ($latest_editais->have_posts()) :
?>
            <div class="ultimos-editais">
                <?php
                    if ( ! empty( $instance['title'] ) ) {
                        echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
                    }
                ?>
                <?php while ($latest_editais->have_posts()) : $latest_editais->the_post(); ?>
                    <div class="ultimos-editais__edital">
                        <p class="ultimos-editais__edital-datetime">
                            <?php echo get_the_modified_date('d/m/Y'); ?>
                            &agrave;s
                            <?php echo get_the_modified_time('G\hi'); ?>
                        </p>
                        &bull;
                        <?php echo get_the_term_list(get_the_ID(), 'edital_category', '<ul class="ultimos-editais__edital-categories"><li>', ',&nbsp;</li><li>', '</li></ul>'); ?>
                        <h3 class="ultimos-editais__edital-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php wp_reset_query(); ?>

            <div class="acesso-todos-editais">
                <hr class="acesso-todos-editais__separador">
                <a href="<?php echo get_post_type_archive_link( 'edital' ); ?>" class="acesso-todos-editais__link"><?php _e('Acesse todos os Editais'); ?></a>
            </div>
<?php
        endif;

        echo $args['after_widget'];
    }

    public function field_generator( $instance ) {
        $output = '';

        foreach ( $this->widget_fields as $widget_field ) {
            $default = '';

            if ( isset($widget_field['default']) ) {
                $default = $widget_field['default'];
            }

            $widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $default, 'ifrs-portal-plugin-editais' );

            switch ( $widget_field['type'] ) {
                default:
                $output .= '<p>';
                $output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'ifrs-portal-plugin-editais' ).':</label> ';
                $output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
                $output .= '</p>';
            }
        }

        echo $output;
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Últimos Editais', 'ifrs-portal-plugin-editais' );
?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
<?php
        $this->field_generator( $instance );
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        foreach ( $this->widget_fields as $widget_field ) {
            switch ( $widget_field['type'] ) {
                default:
                $instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
            }
        }

        return $instance;
    }
}

function register_editais_widget() {
    register_widget( 'Editais_Widget' );
}

add_action( 'widgets_init', 'register_editais_widget' );
