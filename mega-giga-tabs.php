<?php

/**
 * Mega-giga-tabs
 *
 * @author            Sashko
 *
 * @wordpress-plugin
 * Plugin Name:       Mega-giga-tabs
 * Description:       Making your tabs mega-giga!!! requires Smart Custom Fields 4.2.0
 * Version:           1.2.001
 * Requires PHP:      5.6
 * Author:            Sashko
 */
add_action('init', 'include_css_js');
function include_css_js()
{
    wp_enqueue_style('tabs', plugins_url('mega-giga-tabs/tabs.css'), []);
    wp_enqueue_script('tabs', plugins_url('mega-giga-tabs/tabs.js'), []);
}

add_action('init', 'tabs_type_reg');
function tabs_type_reg()
{
    define('PL_T1', 'tabs');
    register_post_type(PL_T1, [
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
}

add_action('init', 'tabs_scf', 20);
function tabs_scf()
{
    if (class_exists('SCF')) {
        add_filter('smart-cf-register-fields', 'tabs_add_meta_fields', 10, 5);
        function tabs_add_meta_fields($settings, $type, $id, $meta_type, $types)
        {
            $settings = [];
            if ($type == PL_T1) {
                $setting = SCF::add_setting('tabs_scf', 'Mega-giga-tabs!!!');
                $setting->add_group('tabs autoscroll', false, [
                [
                    'type' => 'boolean',
                    'name' => 'ascrl',
                    'label' => 'Autoscroll',
                    'true_label' => 'On',
                    'false_label' => 'Off',
                    'default' => 'Off',

                ]
            ]);
                $setting->add_group('tabs form', false, [
                    [
                        'type' => 'select',
                        'name' => 'tfs',
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
                        'name' => 'th',
                        'label' => 'Tab header',
                    ],                     [
                        'type' => 'text',
                        'name' => 'tex',
                        'label' => 'Tab excerpt',
                    ], [
                        'type' => 'image',
                        'name' => 'tth',
                        'label' => 'Tab thumbnail',
                        'size' => 'thumbnail',
                    ], [
                        'type' => 'image',
                        'name' => 'atth',
                        'label' => 'Active tab thumbnail',
                        'size' => 'thumbnail',
                    ], [
                        'type' => 'wysiwyg',
                        'name' => 'ttc',
                        'label' => 'Active tab text content',
                    ],

                ]);
                $settings[] = $setting;
            }
            return $settings;
        }
    }
}
add_action('admin_head', 'true_add_mce_button');
function true_add_tinymce_script($plugin_array)
{
    $plugin_array['true_mce_button'] = get_stylesheet_directory_uri() . '/button.js';
    return $plugin_array;
}
function true_add_mce_button()
{
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    if ('true' == get_user_option('rich_editing')) {
        wp_enqueue_script('button', plugins_url('mega-giga-tabs/button.js'), []);
        add_filter('mce_external_plugins', 'true_add_tinymce_script');
        add_filter('mce_buttons', 'true_register_mce_button');
    }
}
function true_register_mce_button($buttons)
{
    array_push($buttons, 'true_mce_button');
    return $buttons;
}
add_action('init', 'add_sc');
function add_sc()
{
    wp_enqueue_style('tabs', '/tabs.css');
    add_shortcode('tabz', 'get_tabs');
    function get_tabs($atts)
    {
        $a = shortcode_atts([
            'title' => '"' . $atts['title'] . '"',
        ], $atts);
        $autoscroll = ( in_array('autoscroll', $atts) ) ?: false;
        $content = get_posts([
            'post_type' => PL_T1,
            'title' => $a['title'],
            'numberposts' => 1
        ])[0];
        $fields = get_post_custom($content->ID);
        if($fields['ascrl'][0] == true){
            $ascrl = ' auto';
        }else{
            $ascrl = '';
        }
        if (isset($fields['tfs'][0]) && $fields['tfs'][0] == 'horizontal') {
            $html = "<div class='tabs-block-h bigtab".$ascrl."'><div class='tabs-h tabs'>";
            foreach ($fields['th'] as $i => $th) {
                $html .=  "<div class='tab-h";
                if ($i == 0) $html .= ' active';
                $html .= " tab'><div class='shadow'>
                        <div class='img'>";
                if (isset($fields['tth'][$i]) && !empty($fields['tth'][$i]))
                    $html .=  "<img class ='def' src='" . wp_get_attachment_image_url($fields['tth'][$i], 'full') . "' alt=''>";
                if (isset($fields['atth'][$i]) && !empty($fields['atth'][$i]))
                    $html .=  "<img class='act' src='" . wp_get_attachment_image_url($fields['atth'][$i], 'full') . "' alt=''>";
                $html .= "</div><div class='text'>";
                if (isset($fields['th'][$i]) && !empty($fields['th'][$i]))
                    $html .= "<h2>" . $th . "</h2>";
                if (isset($fields['tex'][$i]) && !empty($fields['tex'][$i]))
                    $html .= "<p>" . $fields['tex'][$i] . "</p>";
                $html .= "</div>
                    </div>
                    <div class='tab-cont";
                if ($i == 0) $html .= ' show';
                $html .= "'><div class='tab-cont-inner'>" . $fields['ttc'][$i] . "</div></div></div>";
            }
            $html .= "</div></div>";
            return $html;
        } elseif (isset($fields['tfs'][0]) && $fields['tfs'][0] == 'vertical') {
            $html = "<div class='tabs-block-v bigtab".$ascrl."'><div class='tabs-v  tabs'>";
            foreach ($fields['th'] as $i => $th) {
                $html .=  "<div class='tab-v";
                if ($i == 0) $html .= ' active';
                $html .= " tab'><div class='shadow'>
                    <div class='img'>";
                if (isset($fields['tth'][$i]) && !empty($fields['tth'][$i]))
                    $html .=  "<img class ='def' src='" . wp_get_attachment_image_url($fields['tth'][$i], 'full') . "' alt=''>";
                if (isset($fields['atth'][$i]) && !empty($fields['atth'][$i]))
                    $html .=  "<img class='act' src='" . wp_get_attachment_image_url($fields['atth'][$i], 'full') . "' alt=''>";
                $html .= "</div><div class='text'>";
                if (isset($fields['th'][$i]) && !empty($fields['th'][$i]))
                    $html .= "<h2>" . $th . "</h2>";
                if (isset($fields['tex'][$i]) && !empty($fields['tex'][$i]))
                    $html .= "<p>" . $fields['tex'][$i] . "</p>";
                $html .= "</div>
                    </div>
                    <div class='tab-cont";
                if ($i == 0) $html .= ' show';
                $html .= "'><div class='tab-cont-inner'>" . $fields['ttc'][$i] . "</div></div></div>";
            }
            $html .= "</div></div>";
            return $html;
        } else {
            return "";
        }
    }
}
