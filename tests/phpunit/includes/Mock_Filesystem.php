<?php

if ( ! class_exists( 'Mock_Filesystem' ) ) {
	class Mock_Filesystem {
		/**
		 * The number of times each method was called.
		 *
		 * @var array
		 */
		public $called = array();

		/**
		 * Gets the number of times a method was called.
		 *
		 * @param string $name The method's name.
		 * @return int The number of times the method was called.
		 */
		public function get_call_count( $name ) {
			if ( isset( $this->called[ $name ] ) ) {
				return count( $this->called[ $name ] );
			}
			return 0;
		}

		/**
		 * Adds to the call count of the called method.
		 *
		 * @param string $name The method's name.
		 * @param array  $args The method's arguments.
		 * @return void
		 */
		public function __call( $name, $args ) {
			if ( isset( $this->called[ $name ] ) ) {
				$this->called[ $name ][] = $args;
			} else {
				$this->called[ $name ] = array( $args );
			}
		}
	}
}
