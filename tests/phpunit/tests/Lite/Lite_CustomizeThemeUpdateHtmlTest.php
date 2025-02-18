<?php
/**
 * Class Lite_CustomizeThemeUpdateHtmlTest
 *
 * @package git-updater-lite
 */

/**
 * Tests for Lite::customize_theme_update_html()
 *
 * @covers \Fragen\Git_Updater\Lite::customize_theme_update_html
 */
class Lite_CustomizeThemeUpdateHtmlTest extends GitUpdater_UnitTestCase {
	/**
	 * Tests that the original value is returned when the type of
	 * asset is not a theme.
	 */
	public function test_should_return_original_value_when_type_is_not_theme() {
		$lite = new \Fragen\Git_Updater\Lite( $this->test_files['plugin'] );
		$this->set_property_value(
			$lite,
			'api_data',
			(object) array(
				'type' => 'plugin',
				'slug' => 'my-plugin',
			)
		);

		$original_value = array( 'my-theme' => array( 'hasUpdate' => true ) );
		$this->assertSame(
			$original_value,
			$lite->customize_theme_update_html( $original_value )
		);
	}

	/**
	 * Tests that the 'update' key is set when the theme has an update.
	 */
	public function test_should_set_update_key_when_the_theme_has_an_update() {
		$lite = new \Fragen\Git_Updater\Lite( $this->test_files['theme'] );
		$this->set_property_value(
			$lite,
			'api_data',
			(object) array(
				'name'        => 'My Theme',
				'type'        => 'theme',
				'slug'        => 'my-theme',
				'description' => 'A theme.',
			)
		);

		set_site_transient(
			'update_themes',
			(object) array(
				'response' => array(
					'my-theme' => array(
						'name'           => 'My Theme',
						'slug'           => 'my-theme',
						'package'        => 'http://example.org/my-theme.zip',
						'remote_version' => '1.0.3',
					),
				),
			)
		);

		$original_value = array( 'my-theme' => array( 'hasUpdate' => true ) );
		$actual         = $lite->customize_theme_update_html( $original_value );

		$this->assertIsArray(
			$actual,
			'The returned themes are not an array.'
		);

		$this->assertArrayHasKey(
			'my-theme',
			$actual,
			'The theme is not in the array of themes.'
		);

		$this->assertIsArray(
			$actual['my-theme'],
			'The value for the theme is not an array.'
		);

		$this->assertArrayHasKey(
			'update',
			$actual['my-theme'],
			'The update key was not added for the theme.'
		);
	}

	/**
	 * Tests that the 'description' key has content added to it when the theme has no update.
	 */
	public function test_should_add_to_description_when_the_theme_has_no_update() {
		$lite        = new \Fragen\Git_Updater\Lite( $this->test_files['theme'] );
		$description = 'A theme.';
		$this->set_property_value(
			$lite,
			'api_data',
			(object) array(
				'name' => 'My Theme',
				'type' => 'theme',
				'slug' => 'my-theme',
			)
		);

		set_site_transient(
			'update_themes',
			(object) array(
				'response' => array(
					'my-theme' => array(
						'name'           => 'My Theme',
						'slug'           => 'my-theme',
						'package'        => 'http://example.org/my-theme.zip',
						'remote_version' => '1.0.3',
					),
				),
			)
		);

		$original_value = array(
			'my-theme' => array(
				'hasUpdate'   => false,
				'description' => $description,
			),
		);
		$actual         = $lite->customize_theme_update_html( $original_value );

		$this->assertIsArray(
			$actual,
			'The returned themes are not an array.'
		);

		$this->assertArrayHasKey(
			'my-theme',
			$actual,
			'The theme is not in the array of themes.'
		);

		$this->assertIsArray(
			$actual['my-theme'],
			'The value for the theme is not an array.'
		);

		$this->assertArrayHasKey(
			'description',
			$actual['my-theme'],
			'The description key was not added for the theme.'
		);

		$this->assertIsString(
			$actual['my-theme']['description'],
			'The description is not a string.'
		);

		$this->assertGreaterThan(
			strlen( $description ),
			strlen( $actual['my-theme']['description'] ),
			'Nothing was added to the description.'
		);
	}
}
