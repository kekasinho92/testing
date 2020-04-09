<?php

//Отключает верхнюю панель WordPress'а
add_filter('show_admin_bar', '__return_false');

//Для регистрации нового типа записи и таксономий
add_action('init', 'understrap_post_types');

//Регистрируем новые типы записей и таксономии
function understrap_post_types() {

	//Тип записи - недвижимость
	register_post_type('apartments', [
		'labels' => [
			'name' => 'Недвижимость',
			'singular_name' => 'Недвижимость',
			'add_new' => 'Добавить новую недвижимость',
			'add_new_item' => 'Добавление недвижимости',
			'edit_item' => 'Редактирование недвижимости',
			'new_item' => 'Новая недвижимость',
			'view_item' => 'Смотреть недвижимость',
			'search_items' => 'Искать недвижимость',
			'not_found' => 'Не найдена',
			'not_found_in_trash' => 'Не найдена в корзине',
			'parent_item_colon' => '',
			'menu_name' => 'Недвижимость'
		],
		'description' => 'Тип записи, соответствующий различным типам недвижимости',
		'public' => true,
		'menu_position' => 25,
		'menu_icon' => 'dashicons-admin-home',
		'hierarchical' => false,
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_nav_menus' => true,
		'taxonomies' => [],
		'has_archive' => true
	]);

	//Города
	register_post_type('cities', [
		'labels' => [
			'name' => 'Города',
			'singular_name' => 'Город',
			'add_new' => 'Добавить новый город',
			'add_new_item' => 'Добавление города',
			'edit_item' => 'Редактирование города',
			'new_item' => 'Новый город',
			'view_item' => 'Смотреть город',
			'search_items' => 'Искать город',
			'not_found' => 'Не найден',
			'not_found_in_trash' => 'Не найден в корзине',
			'parent_item_colon' => '',
			'menu_name' => 'Города'
		],
		'description' => 'Тип записи, соответствующий различным городам',
		'public' => true,
		'menu_position' => 26,
		'menu_icon' => 'dashicons-admin-site',
		'hierarchical' => false,
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_nav_menus' => true,
		'taxonomies' => [],
		'has_archive' => true
	]);

	//Таксономии
	//Тип недвижимости
	register_taxonomy( 'ap_type', [ 'apartments' ], [ 
		'label'                 => '', 
		'labels'                => [
			'name'              => 'Типы недвижимости',
			'singular_name'     => 'Тип недвижимости',
			'search_items'      => 'Искать тип недвижимости',
			'all_items'         => 'Все типы недвижимости',
			'view_item '        => 'Смотреть типы недвижимости',
			'edit_item'         => 'Редактирование типа',
			'update_item'       => 'Обновление типа недвижимости',
			'add_new_item'      => 'Добавить новый тип',
			'new_item_name'     => 'Новый заголовок типа недвижимости',
			'menu_name'         => 'Тип недвижимости',
		],
		'description'           => 'Тип недвижимости (квартира, дом, участок и т.д.)', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null, 
		'show_admin_column'     => true, 
		'show_in_rest'          => null, 
		'rest_base'             => null
	]);
}

function add_child_css() {
    //Слайдер
    wp_enqueue_style( 'swiper_styles', get_template_directory_uri() . '/../understrap-child/swiper-5.3.6/package/css/swiper.min.css' );
    //Fancybox
    //wp_enqueue_style( 'fancybox_styles', get_template_directory_uri() . '/../understrap-child/fancybox-2.1.7/source/jquery.fancybox.css' );
    wp_enqueue_style( 'fancybox_styles', get_template_directory_uri() . '/../understrap-child/css/fancybox.css' );
    //Доп стили
    wp_enqueue_style( 'custom_styles', get_template_directory_uri() . '/../understrap-child/css/custom_style.css' );

    //Слайдер
    wp_enqueue_script('swiper_script', get_template_directory_uri() . '/../understrap-child/swiper-5.3.6/package/js/swiper.min.js', [], '', true );
    //Fancybox
    //wp_enqueue_script('fancybox_script', get_template_directory_uri() . '/../understrap-child/fancybox-2.1.7/source/jquery.fancybox.js', [], '', true );
    //Fancybox
    wp_enqueue_script('fancybox_script', get_template_directory_uri() . '/../understrap-child/js/fancybox.min.js', [], '', true );
    //Доп скрипты
    wp_enqueue_script('custom_script', get_template_directory_uri() . '/../understrap-child/js/custom.js', [], '', true );
}
add_action( 'wp_enqueue_scripts', 'add_child_css', 9999 );