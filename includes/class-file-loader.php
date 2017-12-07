<?php
defined( 'ABSPATH' ) or
	 exit();

/**
 * Functions_File_Loader
 * Makes it possible to clutter the functions.php into single files.
 *
 * @author kaiser
 * @author Nicolai
 * @link http://wordpress.stackexchange.com/q/111970/22534
 */

if ( ! class_exists( 'Functions_File_Loader' ) ) :
	class Functions_File_Loader implements IteratorAggregate {

		/**
		 *
		 * @var array
		 */
		private $parameter = array();

		/**
		 *
		 * @var string
		 */
		private $path;

		/**
		 *
		 * @var string
		 */
		private $pattern;

		/**
		 *
		 * @var integer
		 */
		private $flags;

		/**
		 *
		 * @var array
		 */
		private $files = array();

		/**
		 * __construct
		 *
		 * @access public
		 * @param array $parameter
		 */
		public function __construct( $parameter ) {
			$this->set_parameter( $parameter );
			$this->set_path( $this->parameter[ 'path' ] );
			$this->set_pattern( $this->parameter[ 'pattern' ] );
			$this->set_flags( $this->parameter[ 'flags' ] );
			$this->set_files();
		}

		/**
		 * set_parameter
		 *
		 * @access public
		 * @param array $parameter
		 */
		public function set_parameter( $parameter ) {
			if ( empty( $parameter ) )
				$this->parameter = array(
					'',
					'',
					''
				);
			else
				$this->parameter = $parameter;
		}

		/**
		 * get_parameter
		 *
		 * @access public
		 * @return array
		 */
		public function get_parameter() {
			return $this->parameter;
		}

		/**
		 * set_path
		 * defaults to get_stylesheet_directory()
		 *
		 * @access public
		 * @param string $path
		 */
		public function set_path( $path ) {
			if ( empty( $path ) )
				$this->path = get_stylesheet_directory() .
					 '/';
			else
				$this->path = get_stylesheet_directory() .
					 '/' .
					 $path .
					 '/';
		}

		/**
		 * get_path
		 *
		 * @access public
		 * @return string
		 */
		public function get_path() {
			return $this->path;
		}

		/**
		 * set_pattern
		 * defaults to path plus asterisk »*«
		 *
		 * @access public
		 * @param string $pattern
		 */
		public function set_pattern( $pattern ) {
			if ( empty( $pattern ) )
				$this->pattern = $this->get_path() .
					 '*';
			else
				$this->pattern = $this->get_path() .
					 $pattern;
		}

		/**
		 * get_pattern
		 *
		 * @access public
		 * @return string
		 */
		public function get_pattern() {
			return $this->pattern;
		}

		/**
		 * set_flags
		 *
		 * @access public
		 * @param integer $flags
		 */
		public function set_flags( $flags ) {
			if ( empty( $flags ) )
				$this->flags = '0';
			else
				$this->flags = $flags;
		}

		/**
		 * get_flags
		 *
		 * @access public
		 * @return integer
		 */
		public function get_flags() {
			return $this->flags;
		}

		/**
		 * set_files
		 *
		 * @access public
		 */
		public function set_files() {
			$pattern = $this->get_pattern();
			$flags = $this->get_flags();
			$files = glob( $pattern, $flags );
			$this->files = $files;
		}

		/**
		 * get_files
		 *
		 * @access public
		 * @return array
		 */
		public function get_files() {
			return $this->files;
		}

		/**
		 * sort_compare
		 * compare callback
		 *
		 * @access public
		 * @param mixed $a
		 * @param mixed $b
		 * @return integer
		 */
		public function sort_compare( $a, $b ) {
			$a = basename( $a );
			$b = basename( $b );
			if ( $a == $b ) {
				return 0;
			} elseif ( $a < $b ) {
				return -1;
			} else {
				return 1;
			}
		}

		/**
		 * sort_files
		 * sorting function
		 *
		 * @access public
		 * @param array $files_array
		 * @return array
		 */
		public function sort_files( $files_array ) {
			usort(
				$files_array,
				array(
					$this,
					'sort_compare'
				)
			);
			return $files_array;
		}

		/**
		 * get_sorted_files
		 * return sorted files array
		 *
		 * @access public
		 * @return array
		 */
		public function get_sorted_files() {
			$files_array = $this->get_files();
			$sorted_array = $this->sort_files( $files_array );
			return $sorted_array;
		}

		/**
		 * getIterator
		 * This function name has to be kept
		 *
		 * @access public
		 * @return void
		 */
		public function getIterator() {
			$iterator = new ArrayIterator( $this->get_sorted_files() );
			return $iterator;
		}

		/**
		 * load_file
		 *
		 * @access public
		 * @param string $file
		 */
		public function load_file( $file ) {
	// 		echo '<pre>'; print_r($file); echo '</pre>';
			include_once "{$file}";
		}
	}
endif;
