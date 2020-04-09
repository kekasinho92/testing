<?php
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] .'/wp-blog-header.php');
global $wpdb;

//die( json_encode($_POST['uploaded_files']) );

//if(isset($_POST['sended']) == '1') {
	//Основная информация
	$post_type = 'apartments';
	$post_author = 2;
	$post_title = esc_sql($_POST['title']);
	$post_content = esc_sql($_POST['description']);
 
	$new_post = array(
		'post_type' => $post_type,
		'post_author' => $post_author,
		'post_content' => $post_content,
		'post_title' => $post_title,
		'comment_status' => 'closed',
		'post_status' => 'pending'
	);
	 
	$post_id = wp_insert_post($new_post);



	//Тип недвижимости
	if ($_POST['ac_type']) {
		$type_id = substr($_POST['ac_type'], 7);
	    $wpdb->insert('wp_term_relationships', 
	    	[
	    		'object_id' => $post_id,
		        'term_taxonomy_id' => $type_id,
		        'term_order' => 0
		    ]
	    );
    }

	//Адрес
	if ($_POST['address']) {
	    $wpdb->insert('wp_postmeta', 
	    	[
		        'post_id' => $post_id,
		        'meta_key' => 'address',
		        'meta_value' => esc_sql($_POST['address'])
		    ]
	    );
    }
 
    //Площадь
    if ($_POST['area']) {
	    $wpdb->insert('wp_postmeta', 
	    	[
		        'post_id' => $post_id,
		        'meta_key' => 'area',
		        'meta_value' => esc_sql($_POST['area'])
		    ]
	    );
    }

    //Жилая площадь
    if ($_POST['livingArea']) {
	    $wpdb->insert('wp_postmeta', 
	    	[
		        'post_id' => $post_id,
		        'meta_key' => 'livingArea',
		        'meta_value' => esc_sql($_POST['livingArea'])
		    ]
	    );
    }

    //Город
    if ($_POST['city']) {
    	$city_id = substr($_POST['city'], 7);
    	$city_value = 'a:1:{i:0;s:2:"'.$city_id.'";}';
	    $wpdb->insert('wp_postmeta', 
	    	[
		        'post_id' => $post_id,
		        'meta_key' => 'cities',
		        'meta_value' => $city_value
		    ]
	    );
    }

    //Этаж
    if ($_POST['floor']) {
	    $wpdb->insert('wp_postmeta', 
	    	[
		        'post_id' => $post_id,
		        'meta_key' => 'floor',
		        'meta_value' => esc_sql($_POST['floor'])
		    ]
	    );
    }

    //Стоимость
    $wpdb->insert('wp_postmeta', 
    	[
	        'post_id' => $post_id,
	        'meta_key' => 'price',
	        'meta_value' => esc_sql($_POST['price'])
	    ]
    );

    //Фотографии
    if(isset($_POST['uploaded_files'])) {
    	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/2020/04/';

    	//$uploaddir = './uploads'; 

    	//cоздадим папку если её нет
    	if(!is_dir( $uploaddir )) {
    		mkdir($uploaddir, 0777);
    	}

    	$files = $_FILES; //полученные файлы
    	$done_files = array();

    	$flag = 0;

    	//переместим файлы из временной директории в указанную
		foreach( $files as $file ){
			$file_name = $file['name'];

			if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
				$done_files[] = realpath( "$uploaddir/$file_name" );
			}
		

			if ($done_files) {				
				$info = pathinfo("$uploaddir/$file_name");
				$thumb_name = $info['filename'];
				$thumb_type = $info['extension'];
				$thumb_mime = mime_content_type("$uploaddir/$file_name");
				$thumb_guid = str_replace('/home/k50803/public_html/','http://', $uploaddir).$file['name'];

				// файл должен находиться в директории загрузок WP.
				$filename = $uploaddir . $file['name'];

				// ID поста, к которому прикрепим вложение.
				$parent_post_id = $post_id;

				// Проверим тип поста, который мы будем использовать в поле 'post_mime_type'.
				$filetype = wp_check_filetype( basename( $filename ), null );

				// Получим путь до директории загрузок.
				$wp_upload_dir = wp_upload_dir();

				// Подготовим массив с необходимыми данными для вложения.
				$attachment = array(
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Вставляем запись в базу данных.
				$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

				if ($flag == 0) {
					// Подключим нужный файл, если он еще не подключен
					// wp_generate_attachment_metadata() зависит от этого файла.
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Создадим метаданные для вложения и обновим запись в базе данных.
					$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
					wp_update_attachment_metadata( $attach_id, $attach_data );

				    set_post_thumbnail($post_id, $attach_id);
			    } else {
					$count = $flag;

					//
				    $wpdb->insert('wp_postmeta', 
				    	[
					        'post_id' => $post_id,
					        'meta_key' => 'img_'.$count,
					        'meta_value' => $attach_id
					    ]
				    );
			    }
	    	}
		    $flag++;
		}

		//$data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

		die( json_encode( $thumb_id ) );
    }

	 
	//$post = get_post($post_id);
	//wp_redirect($post->guid);
//}

die( json_encode($post_id) );