<?php
namespace ohryan\TeeVee;

Class TeeVee {
	
	public function get_episodes( $grouped_by_series = true ) {

		if ( $grouped_by_series ) {
			$series = self::get_series();

			for( $i = 0; $i < count( $series ); $i++ ) {

				$args = array(
					'posts_per_page'	=>	-1,
			        'tax_query' => array(
			            array(
			                'taxonomy' => 'teevee_series',
			                'field' => 'slug',
			                'terms' => array( $series[$i]->slug ),
			                'operator' => 'IN'
			            )
			        )
			    );

			    $episodes = get_posts( $args );
			    $series[$i]->episodes = $episodes;
			}

			
			return array( 'series' => $series);

		} else {
			// nothing. for now
		}
	
	}

	public function get_latest_episodes() {
		$terms = get_terms( 'teevee_series', 'fields=names' ); 

		$args = array(
			'posts_per_page'	=>	10,
			'tax_query'			=>	array(
										array(
										'taxonomy'	=>	'teevee_series',
										'field'		=>	'slug',
										'terms'		=>	$terms
										)
									)
			);

		$posts = get_posts( $args );
		$posts = self::set_episode_meta($posts);

		return $posts;
	}

	public function get_episodes_by_series( $series_id ) {

		if ( is_numeric($series_id) ) {
			$args = array(
				'posts_per_page'	=>	20, //this value is entirely arbitrary
				'tax_query'			=> array(
									array(
										'taxonomy'	=>	'teevee_series',
										'field'		=>	'term_id',
										'terms'		=>	$series_id
										)
									)
				);
			$posts = get_posts( $args );
			$posts = self::set_episode_meta($posts);
			return $posts;
		} else {
			return false;
		}
	}

	public function set_episode_meta( $posts ) {
		if ( is_array($posts) ) {
			

			for ( $i = 0; $i < count($posts); $i++ ) {

				
				$post = $posts[$i];


				if ( is_numeric($post->ID) ) {
					
					$title_override = get_post_meta( $post->ID, '_teevee_title_override', true );
					$post->video_title = ($title_override !== '' ) ? $title_override : $post->title;

					$post->subtitle = get_post_meta( $post->ID, '_teevee_subtitle', true );
					$post->desc = get_post_meta( $post->ID, '_teevee_desc', true );
					$post->video_uri = get_post_meta( $post->ID, '_teevee_video_uri', true );


					if ( has_post_thumbnail( $post->ID ))
						$cover_uri = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					else 
						$cover_uri[0] = '';

					$post->cover_uri = $cover_uri[0];
				}
				
			}

			return $posts;

		}

		return false;
		
	}

	public function get_series() {
		return get_terms( 'teevee_series' );
	}

	public function get_series_title( $ID ) {
		return get_term( $ID, 'teevee_series' );
	}

	public function load_template ( $template, $content, $template_title = '' ) {
		// let's whitelist the template files, because we're paranoid. 
		$valid_templates = array( 'list.xml', 'menubar.xml' );
		if ( in_array( $template, $valid_templates ) ) {
			header('content-type: application/x-javascript');
			include plugin_dir_path( __FILE__ ) . '../xml/'.$template.'.js.php';	
			return '';
		} else {
			header('HTTP/1.0 403 Forbidden');
			exit;
		}

	}

	public function http_error() {
		header("HTTP/1.0 404 Not Found");
		return '';
	}
}