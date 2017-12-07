<?php

if ( ! function_exists( 'functions_file_loader' ) ) :
	function functions_file_loader( $path = '', $pattern = '', $flags = '' ) {
		if ( empty( $path ) ) {
			return FALSE;
		} else {
			$path = 'functions/' . $path;
		}
		if ( empty( $pattern ) ) {
			$pattern = '{*/,}[!_]*.php';
		}
		if ( empty( $flags ) ) {
			$flags = GLOB_BRACE;
		}

		$args = array(
				'path'    => $path,
				'pattern' => $pattern,
				'flags'   => $flags
		);
		$file_loader_obj = new Functions_File_Loader( $args );
		$filelist = $file_loader_obj->get_sorted_files();

	// 	if ( $path == 'func/setup' ) {
	// 		echo '<pre>'; print_r( $file_loader_obj->get_sorted_files() ); echo '</pre>';
	// 	}

		foreach ( $file_loader_obj as $file ) {
			$file_loader_obj->load_file( $file );
		}
	}
endif;