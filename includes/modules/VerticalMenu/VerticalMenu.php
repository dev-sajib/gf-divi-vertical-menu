<?php

class DFV_DFVerticalMenu extends ET_Builder_Module
{
    public $slug = 'dfv_vertical_menu';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => '#',
        'author' => 'Gutefy',
        'author_uri' => 'portfolio.gutefy.com',
    );

    public function init()
    {
        $this->name = esc_html__('Vertical Menu', 'dfv-vertical-menu');
    }




    // Get menu list
    public function get_menu_list()
    {
        $menus = wp_get_nav_menus();
        $list = ['select' => 'Select']; // Default option

        foreach ($menus as $menu) {
            $list[$menu->slug] = $menu->name;
        }

        return $list;
    }

    // Define fields in Divi builder
    public function get_fields()
    {
        return array(
            'df_vertical_menu_id' => array(
                'label' => esc_html__('Select Menu', 'dfv-vertical-menu'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'description' => esc_html__('Select a menu to display.', 'dfv-vertical-menu'),
                'toggle_slug' => 'main_content',
                'options' => $this->get_menu_list(),
                'default' => 'select',
            ),
        );
    }

    // Render the selected menu
    public function render($attrs, $content = null, $render_slug)
    {
        // Fetch the selected menu slug
        $menu_slug = $this->props['df_vertical_menu_id'];
        $menu_items = wp_get_nav_menu_items($menu_slug);

        if (!$menu_items) {
            return '<p>' . esc_html__('No menu items found.', 'dfv-vertical-menu') . '</p>';
        }

        // Initialize markup and parent stack
        $markup = '';
        $parent_stack = [];

        foreach ($menu_items as $single_menu_item) {
            $current_parent_id = $single_menu_item->menu_item_parent;
            $item_title = $single_menu_item->title;
            $item_url = $single_menu_item->url;

            // If item is a parent
            if ($current_parent_id == 0) {
                // Close unclosed parents
                while (!empty($parent_stack) && end($parent_stack) != $current_parent_id) {
                    $markup .= '</ul></li>';
                    array_pop($parent_stack);
                }

                // Add parent menu item
                $markup .= sprintf(
                    '<li><a href="%1$s">%2$s</a>',
                    esc_url($item_url),
                    esc_html($item_title)
                );

                $parent_stack[] = $single_menu_item->ID; // Add parent to stack
            } else {
                // Add submenu if it's not already opened
                if (!in_array($current_parent_id, $parent_stack)) {
                    $markup .= '<ul>';
                    $parent_stack[] = $current_parent_id;
                }

                // Add submenu item
                $markup .= sprintf(
                    '<li><a href="%1$s">%2$s</a>',
                    esc_url($item_url),
                    esc_html($item_title)
                );
            }
        }

        // Close any remaining open tags
        while (!empty($parent_stack)) {
            $markup .= '</ul></li>';
            array_pop($parent_stack);
        }

        return sprintf('<ul>%1$s</ul>', $markup);
    }
}

new DFV_DFVerticalMenu;
