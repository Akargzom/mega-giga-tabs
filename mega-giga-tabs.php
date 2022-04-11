<?php

/**
 * Mega-giga-tabs
 *
 * @author            Sashko
 *
 * @wordpress-plugin
 * Plugin Name:       Mega-giga-tabs
 * Description:       Making your tabs mega-giga!!! requires Smart Custom Fields plugin
 * Version:           1.3
 * Requires PHP:      5.6
 * Author:            Sashko
 * Text Domain: Mega-giga-tabs
 * Domain Path: /languages
 */


add_action('wp_enqueue_scripts', function()
{
    wp_enqueue_style('tabs', plugins_url('tabs.css', __FILE__ ));
    wp_enqueue_script('tabs', plugins_url('tabs.js', __FILE__ ));
});
add_action( 'admin_menu', 'MGTZ_fields' );

function MGTZ_fields() {
   add_options_page( 'Tabs options', 'Tabs options', 'manage_options', 'MGTZ-options', 'tabs_options_callback' );
}

function tabs_options_callback() {
?>
<div class="MGTZ_wrap">
   <h1><?=get_admin_page_title();?></h1>
   <form action="options.php" method="POST">
<?php
settings_fields( 'tabs_group' );  
do_settings_sections( 'tabs_page' ); 
submit_button();
?>
   </form>
</div>
<?php
}
add_action( 'admin_init', 'MGTZ_settings' );
function MGTZ_settings(){
   register_setting( 'tabs_group', 'tabs_data', 'sanitize_callback' );
   add_settings_section( 'tabs_section', '', '', 'tabs_page' );
   $opts = [
      'MGTZ_nmb_asps' => 'Autoscroll speed (seconds)',
   ];
   $vals = get_option( 'tabs_data' );
   foreach ( $opts as $field => $name ){
      add_settings_field( $field, $name, 'MGTZ_options', 'tabs_page', 'tabs_section', $args = [ 'field' => $field, 'vals' => $vals, 'name' => 'tabs_data' ] );
   }
}
function MGTZ_options( $args ){
   $field_name = $args['field'];
   $vals = $args['vals'];
   $name_option = $args['name'];
   if ( strpos( $field_name, 'tx' ) !== false || strpos( $field_name, 'lb' ) !== false ) {
   	if( isset( $vals[$field_name] ) )
   		$value = $vals[$field_name];
   	else $value = '';
   	echo '<textarea name="' .$name_option. '[' .$field_name. ']" id="' .$field_name. '" rows="10" cols="50" class="large-text code">' .$value. '</textarea>';
   }elseif ( strpos( $field_name, 'check' ) !== false ){
		if( isset( $vals[$field_name] ) && $vals[$field_name] == 1 ) $cheked = ' checked';
		else $cheked = '';
		echo '<input name="' .$name_option. '[' .$field_name. ']" type="checkbox" id="' .$field_name. '" value="1"' .$cheked. '/>';
	} elseif ( strpos( $field_name, 'nmb' ) !== false ) {
		if( isset( $vals[$field_name] ) )
   		$value = $vals[$field_name];
   	else $value = '';
		echo '<input name="' .$name_option. '[' .$field_name. ']" type="number" id="' .$field_name. '" value="' .$value. '" class="regular-text" />';
	} else {
		if( isset( $vals[$field_name] ) )
   		$value = $vals[$field_name];
   	else $value = '';
		echo '<input name="' .$name_option. '[' .$field_name. ']" type="text" id="' .$field_name. '" value="' .$value. '" class="regular-text" />';
	}
}
add_action('init', function()
{
    define('MGTZ_PL_T1', 'tabs');
    register_post_type(MGTZ_PL_T1, [
        'labels' => [
            'name'               => 'Tabs',
            'singular_name'      => 'Tab',
            'add_new'            => 'Add tabs block',
            'add_new_item'       => 'Add new tabs block',
            'edit_item'          => 'Edit tabs block',
            'new_item'           => 'New tabs block',
            'view_item'          => 'View tabs block',
            'search_items'       => 'Search tabs block',
            'not_found'          => 'Not found',
            'not_found_in_trash' => 'Not found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Tabs',
        ],
        'public'             => true,
        'menu_position'      => 34,
        'hierarchical'       => false,
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-editor-ol',
        'publicly_queryable' => false,
        'supports'           => ['title', 'editor'],
    ]);
});
add_action('init', 'MGTZ_tabs_scf', 20);
function MGTZ_tabs_scf()
{
    if (class_exists('SCF')) {
        add_filter('smart-cf-register-fields', 'MGTZ_tabs_add_meta_fields', 10, 5);
        function MGTZ_tabs_add_meta_fields($settings, $type, $id, $meta_type, $types)
        {
            if ($type == MGTZ_PL_T1) {
                $setting = SCF::add_setting('tabs_scf', 'Mega-giga-tabs!!!');
                $setting->add_group('tabs autoscroll', false, [
                [
                    'type' => 'boolean',
                    'name' => 'MGTZ_ascrl',
                    'label' => 'Autoscroll',
                    'true_label' => 'On',
                    'false_label' => 'Off',
                    'default' => 'Off',

                ]
            ]);
                $setting->add_group('tabs form', false, [
                    [
                        'type' => 'select',
                        'name' => 'MGTZ_tfs',
                        'label' => 'tabs form',
                        'choices' => [
                            'horizontal' => 'horizontal tabs',
                            'vertical' => 'vertical tabs',
                        ]
                    ]
                ]);
                $setting->add_group('tabs content', true, [
                    [
                        'type' => 'text',
                        'name' => 'MGTZ_th',
                        'label' => 'Tab header',
                    ],                     [
                        'type' => 'text',
                        'name' => 'MGTZ_tex',
                        'label' => 'Tab excerpt',
                    ], [
                        'type' => 'image',
                        'name' => 'MGTZ_tth',
                        'label' => 'Tab thumbnail',
                        'size' => 'thumbnail',
                    ], [
                        'type' => 'image',
                        'name' => 'MGTZ_atth',
                        'label' => 'Active tab thumbnail',
                        'size' => 'thumbnail',
                    ], [
                        'type' => 'wysiwyg',
                        'name' => 'MGTZ_ttc',
                        'label' => 'Active tab text content',
                    ],

                ]);
                $settings[] = $setting;
            }
            return $settings;
        }
    }
}
add_action('admin_head', 'MGTZ_true_add_mce_button');
function MGTZ_true_add_tinymce_script($plugin_array)
{
    $plugin_array['true_mce_button'] = get_stylesheet_directory_uri() . '/button.js';
    return $plugin_array;
}
function MGTZ_true_add_mce_button()
{
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    if ('true' == get_user_option('rich_editing')) {
        wp_enqueue_script('button', plugins_url('button.js', __FILE__));
        add_filter('mce_external_plugins', 'MGTZ_true_add_tinymce_script');
        add_filter('mce_buttons', 'MGTZ_true_register_mce_button');
    }
}
function MGTZ_true_register_mce_button($buttons)
{
    array_push($buttons, 'true_mce_button');
    return $buttons;
}
add_action('plugins_loaded', function(){
    add_shortcode('tabz', 'get_tabs');
    function get_tabs($atts)
    {
        $a = shortcode_atts([
            'title' => '"' . $atts['title'] . '"',
        ], $atts);
        $autoscroll = ( in_array('autoscroll', $atts) ) ?: false;
        $content = get_posts([
            'post_type' => MGTZ_PL_T1,
            'title' => $a['title'],
            'numberposts' => 1
        ])[0];
        $fields = get_post_custom($content->ID);
        if (isset(get_option('tabs_data')['MGTZ_nmb_asps']) && !empty(get_option('tabs_data')['MGTZ_nmb_asps']))
        $asps = get_option('tabs_data')['MGTZ_nmb_asps'] * 1000;
        else   
        $asps = 10000;
        if($fields['MGTZ_ascrl'][0] == true){
            $MGTZ_ascrl = ' MGTZ_auto';
        }else{
            $MGTZ_ascrl = '';
        }
        if (isset($fields['MGTZ_tfs'][0]) && $fields['MGTZ_tfs'][0] == 'horizontal') {
            $html = "<div class='MGTZ_tabs-block-h MGTZ_bigtab".$MGTZ_ascrl."' data = '".$asps."' ><div class='MGTZ_tabs-h MGTZ_tabs'>";
            foreach ($fields['MGTZ_th'] as $i => $th) {
                $html .=  "<div class='MGTZ_tab-h MGTZ_tab";
                if ($i == 0) $html .= ' MGTZ_active';                    
                $html .= " tab'><div class='MGTZ_shadow'>
                        <div class='MGTZ_img'>";
                if (isset($fields['MGTZ_tth'][$i]) && !empty($fields['MGTZ_tth'][$i]))
                    $html .=  "<img class ='MGTZ_def' src='" . wp_get_attachment_image_url($fields['MGTZ_tth'][$i], 'full') . "' alt=''>";
                if (isset($fields['MGTZ_atth'][$i]) && !empty($fields['MGTZ_atth'][$i]))
                    $html .=  "<img class='MGTZ_act' src='" . wp_get_attachment_image_url($fields['MGTZ_atth'][$i], 'full') . "' alt=''>";
                $html .= "</div><div class='MGTZ_text'>";
                if (isset($fields['MGTZ_th'][$i]) && !empty($fields['MGTZ_th'][$i]))
                    $html .= "<h2>" . $th . "</h2>";
                if (isset($fields['MGTZ_tex'][$i]) && !empty($fields['MGTZ_tex'][$i]))
                    $html .= "<p>" . $fields['MGTZ_tex'][$i] . "</p>";
                $html .= "</div>
                    </div>
                    <div class='MGTZ_tab-cont";
                if ($i == 0) $html .= ' MGTZ_show';
                $html .= "'><div class='MGTZ_tab-cont-inner'>" . $fields['MGTZ_ttc'][$i] . "</div></div></div>";
            }
            $html .= "</div></div>";
            return $html;
        } elseif (isset($fields['MGTZ_tfs'][0]) && $fields['MGTZ_tfs'][0] == 'vertical') {
            $html = "<div class='MGTZ_tabs-block-v MGTZ_bigtab".$MGTZ_ascrl."' data = '".$asps."'><div class='MGTZ_tabs-v  MGTZ_tabs'>";
            foreach ($fields['MGTZ_th'] as $i => $th) {
                $html .=  "<div class='MGTZ_tab-v MGTZ_tab";
                if ($i == 0) $html .= ' MGTZ_active';
                $html .= " tab'><div class='MGTZ_shadow'>
                    <div class='MGTZ_img'>";
                if (isset($fields['MGTZ_tth'][$i]) && !empty($fields['MGTZ_tth'][$i]))
                    $html .=  "<img class ='MGTZ_def' src='" . wp_get_attachment_image_url($fields['MGTZ_tth'][$i], 'full') . "' alt=''>";
                if (isset($fields['MGTZ_atth'][$i]) && !empty($fields['MGTZ_atth'][$i]))
                    $html .=  "<img class='MGTZ_act' src='" . wp_get_attachment_image_url($fields['MGTZ_atth'][$i], 'full') . "' alt=''>";
                $html .= "</div><div class='MGTZ_text'>";
                if (isset($fields['MGTZ_th'][$i]) && !empty($fields['MGTZ_th'][$i]))
                    $html .= "<h2>" . $th . "</h2>";
                if (isset($fields['MGTZ_tex'][$i]) && !empty($fields['MGTZ_tex'][$i]))
                    $html .= "<p>" . $fields['MGTZ_tex'][$i] . "</p>";
                $html .= "</div>
                    </div>
                    <div class='MGTZ_tab-cont";
                if ($i == 0) $html .= ' MGTZ_show';
                $html .= "'><div class='MGTZ_tab-cont-inner'>" . $fields['MGTZ_ttc'][$i] . "</div></div></div>";
            }
            $html .= "</div></div>";
            return $html;
        } else {
            return "";
        }
    }
}
);