<?php
/**
 * Class Lite_AddAuthHeaderTest
 *
 * @package git-updater-lite
 */

/**
 * Tests for Lite::add_auth_header()
 *
 * @covers \Fragen\Git_Updater\Lite::add_auth_header
 */
class Lite_AddAuthHeaderTest extends GitUpdater_UnitTestCase {
	/**
	 * Tests that the original args value is returned when 'api_data'
	 * has no 'auth_header' property.
	 */
	public function test_should_return_original_args_when_api_data_has_no_auth_header_property() {
		$lite = new \Fragen\Git_Updater\Lite( $this->test_files['plugin'] );
		$this->set_property_value( $lite, 'api_data', (object) array( 'slug' => 'my-plugin' ) );

		$args = array( 'test' => 'args' );
		$this->assertSame(
			$args,
			$lite->add_auth_header( $args, 'http://my-plugin.com' )
		);
	}

	/**
	 * Tests that the original args value is returned when the slug in 'api_data'
	 * is not in the URL.
	 */
	public function test_should_return_original_args_when_the_slug_in_api_data_is_not_in_the_url() {
		$lite = new \Fragen\Git_Updater\Lite( $this->test_files['plugin'] );
		$this->set_property_value(
			$lite,
			'api_data',
			(object) array(
				'auth_header' => 'Bearer: MY_API_KEY',
				'slug'        => 'my-plugin',
			)
		);

		$args = array( 'test' => 'args' );
		$this->assertSame(
			$args,
			$lite->add_auth_header( $args, 'http://a-different-slug.com' )
		);
	}

	/**
	 * Tests that the authorization header is merged into the original args value.
	 */
	public function test_should_merge_authorization_header_into_the_original_args() {
		$lite = new \Fragen\Git_Updater\Lite( $this->test_files['plugin'] );
		$this->set_property_value(
			$lite,
			'api_data',
			(object) array(
				'slug'        => 'my-plugin',
				'auth_header' => array( 'Authorization' => 'Bearer: MY_API_KEY' ),
			)
		);

		$this->assertSame(
			array(
				'test'          => 'args',
				'Authorization' => 'Bearer: MY_API_KEY',
			),
			$lite->add_auth_header( array( 'test' => 'args' ), 'http://my-plugin.com' )
		);
	}
}
