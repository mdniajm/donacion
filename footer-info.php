<?php
class Kindaid_Footer_Info_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'kindaid_footer_info',
            __('Kindaid Footer Info', 'kindaid'),
            array('description' => __('Display footer logo, info, and social links', 'kindaid'))
        );

        // Enqueue media uploader script
        add_action('admin_enqueue_scripts', array($this, 'enqueue_media_uploader'));
    }

    public function enqueue_media_uploader() {
        wp_enqueue_media();
        wp_enqueue_script(
            'kindaid-media-upload',
            get_template_directory_uri() . '/assets/js/kindaid-widget.js',
            array('jquery'),
            false,
            true
        );
    }

    // FRONT-END DISPLAY
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Title (optional)
        $title = !empty($instance['title'])
            ? apply_filters('widget_title', $instance['title'], $instance, $this->id_base)
            : '';

        $logo         = !empty($instance['logo']) ? esc_url($instance['logo']) : '';
        $info         = !empty($instance['info']) ? wp_kses_post($instance['info']) : '';
        $social1      = !empty($instance['social1']) ? esc_url($instance['social1']) : '';
        $social2      = !empty($instance['social2']) ? esc_url($instance['social2']) : '';
        $social3      = !empty($instance['social3']) ? esc_url($instance['social3']) : '';
        $social4      = !empty($instance['social4']) ? esc_url($instance['social4']) : '';
        $linkedin_url = !empty($instance['linkedin_url']) ? esc_url($instance['linkedin_url']) : '';

        // Output title if present
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

        <?php if (!empty($logo)): ?>
        <div class="tp-footer-logo mb-25">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img data-width="108" src="<?php echo esc_url($logo); ?>" alt="">
            </a>
        </div>
        <?php endif; ?>

        <?php if (!empty($info)): ?>
            <p class="tp-footer-dec mb-30"><?php echo $info; ?></p>
        <?php endif; ?>

        <div class="tp-footer-social">
            <?php if (!empty($social1)): ?>
            <a href="<?php echo esc_url($social1); ?>"><i class="fab fa-facebook-f"></i></a>
            <?php endif; ?>

            <?php if (!empty($social2)): ?>
            <a href="<?php echo esc_url($social2); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28884 0.714844H0.666992L6.14691 7.9153L1.01754 13.9556H3.38746L7.26697 9.38713L10.7118 13.9136H15.3337L9.69453 6.50391L9.70451 6.51669L14.5599 0.798959H12.19L8.58427 5.04503L5.28884 0.714844ZM3.21817 1.97588H4.65702L12.7825 12.6525H11.3436L3.21817 1.97588Z" fill="currentColor"/>
                </svg>
            </a>
            <?php endif; ?>

            <?php if (!empty($social3)): ?>
            <a href="<?php echo esc_url($social3); ?>"><i class="fas fa-globe"></i></a>
            <?php endif; ?>

            <?php if (!empty($social4)): ?>
            <a href="<?php echo esc_url($social4); ?>"><i class="fab fa-instagram"></i></a>
            <?php endif; ?>

            <?php if (!empty($linkedin_url)): ?>
            <a href="<?php echo esc_url($linkedin_url); ?>"><i class="fab fa-linkedin"></i></a>
            <?php endif; ?>
        </div>

        <?php
        echo $args['after_widget'];
    }

    // BACK-END FORM
    public function form($instance) {
        $title        = !empty($instance['title']) ? esc_attr($instance['title']) : '';
        $logo         = !empty($instance['logo']) ? esc_url($instance['logo']) : '';
        $info         = !empty($instance['info']) ? esc_textarea($instance['info']) : '';
        $social1      = !empty($instance['social1']) ? esc_url($instance['social1']) : '';
        $social2      = !empty($instance['social2']) ? esc_url($instance['social2']) : '';
        $social3      = !empty($instance['social3']) ? esc_url($instance['social3']) : '';
        $social4      = !empty($instance['social4']) ? esc_url($instance['social4']) : '';
        $linkedin_url = !empty($instance['linkedin_url']) ? esc_url($instance['linkedin_url']) : '';
        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title (optional):', 'kindaid'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text"
                   value="<?php echo $title; ?>"
                   placeholder="<?php esc_attr_e('Widget title…', 'kindaid'); ?>">
        </p>

        <!-- Logo Upload -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('logo')); ?>"><?php esc_html_e('Logo Upload:', 'kindaid'); ?></label><br>
            <input type="text" class="widefat kindaid-upload-field"
                   id="<?php echo esc_attr($this->get_field_id('logo')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('logo')); ?>"
                   value="<?php echo esc_attr($logo); ?>">
            <button type="button" class="button select-media-button"><?php esc_html_e('Upload', 'kindaid'); ?></button>
        </p>

        <!-- Footer Info -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('info')); ?>"><?php esc_html_e('Footer Info:', 'kindaid'); ?></label>
            <textarea class="widefat" rows="4"
                      id="<?php echo esc_attr($this->get_field_id('info')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('info')); ?>"><?php echo esc_textarea($info); ?></textarea>
        </p>

        <!-- Social URLs -->
        <p><label><?php esc_html_e('Facebook URL:', 'kindaid'); ?></label>
            <input class="widefat" name="<?php echo esc_attr($this->get_field_name('social1')); ?>" type="url" value="<?php echo esc_attr($social1); ?>"></p>

        <p><label><?php esc_html_e('Twitter/X URL:', 'kindaid'); ?></label>
            <input class="widefat" name="<?php echo esc_attr($this->get_field_name('social2')); ?>" type="url" value="<?php echo esc_attr($social2); ?>"></p>

        <p><label><?php esc_html_e('Website URL:', 'kindaid'); ?></label>
            <input class="widefat" name="<?php echo esc_attr($this->get_field_name('social3')); ?>" type="url" value="<?php echo esc_attr($social3); ?>"></p>

        <p><label><?php esc_html_e('Instagram URL:', 'kindaid'); ?></label>
            <input class="widefat" name="<?php echo esc_attr($this->get_field_name('social4')); ?>" type="url" value="<?php echo esc_attr($social4); ?>"></p>

        <p><label><?php esc_html_e('LinkedIn URL:', 'kindaid'); ?></label>
            <input class="widefat" name="<?php echo esc_attr($this->get_field_name('linkedin_url')); ?>" type="url" value="<?php echo esc_attr($linkedin_url); ?>"></p>

        <script>
        jQuery(document).ready(function ($) {
            function initMediaUpload() {
                $(document).off('click', '.select-media-button').on('click', '.select-media-button', function (e) {
                    e.preventDefault();
                    var button = $(this);
                    var input = button.prev('.kindaid-upload-field');

                    var frame = wp.media({
                        title: '<?php echo esc_js(__('Select or Upload Logo', 'kindaid')); ?>',
                        button: { text: '<?php echo esc_js(__('Use this image', 'kindaid')); ?>' },
                        multiple: false
                    });

                    frame.on('select', function () {
                        var attachment = frame.state().get('selection').first().toJSON();
                        input.val(attachment.url).trigger('change');
                        frame.close();
                    });

                    frame.open();
                });
            }
            initMediaUpload();
        });
        </script>
        <?php
    }

    // SAVE
    public function update($new_instance, $old_instance) {
        $instance = array();

        // Title (optional)
        $instance['title'] = isset($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';

        $instance['logo']         = !empty($new_instance['logo']) ? esc_url_raw($new_instance['logo']) : '';
        $instance['info']         = !empty($new_instance['info']) ? wp_kses_post($new_instance['info']) : '';

        $instance['social1']      = isset($new_instance['social1']) ? esc_url_raw($new_instance['social1']) : '';
        $instance['social2']      = isset($new_instance['social2']) ? esc_url_raw($new_instance['social2']) : '';
        $instance['social3']      = isset($new_instance['social3']) ? esc_url_raw($new_instance['social3']) : '';
        $instance['social4']      = isset($new_instance['social4']) ? esc_url_raw($new_instance['social4']) : '';
        $instance['linkedin_url'] = isset($new_instance['linkedin_url']) ? esc_url_raw($new_instance['linkedin_url']) : '';

        return $instance;
    }
}

// REGISTER WIDGET
function register_kindaid_footer_info_widget() {
    register_widget('Kindaid_Footer_Info_Widget');
}
add_action('widgets_init', 'register_kindaid_footer_info_widget');
