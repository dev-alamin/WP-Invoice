<?php 
namespace ADS\Admin;
use WP_Widget;
use ADS\Traits\Helper;

class Widget extends WP_Widget {
    use Helper; // To import fronend form
    public function __construct() {
        parent::__construct(
            'ads_frontend_form_widget',
            __('Frontend Form Widget', 'frontend-form-submission'),
            array(
                'description' => __('Displays the frontend submission form.', 'frontend-form-submission')
            )
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }
        
        echo '<div class="ads-frontend-form-widget">';
        echo $this->generate_frontend_form();
        echo '</div>';

        // Define the AJAX URL variable for the widget
        $ajax_url = admin_url('admin-ajax.php');

        // Enqueue your JavaScript file with the localized variable
        wp_enqueue_script('ads-frontend-form-submission', ADS_FFS_PLUGIN_ASSET . 'js/frontend.js', ['jquery'], time(), true);
        wp_localize_script('ads-frontend-form-submission', 'ads_frontend_form_submission', array(
            'ajax_url' => $ajax_url,
            'nonce' => wp_create_nonce('frontend-form-submission-nonce')
        ));
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'frontend-form-submission'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
