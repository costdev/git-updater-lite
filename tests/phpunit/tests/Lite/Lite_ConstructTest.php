<?php
/**
 * Class Lite_ConstructTest
 *
 * @package git-updater-lite
 */

/**
 * Tests for Lite::__construct()
 *
 * @covers \Fragen\Git_Updater\Lite::__construct
 */
class Lite_ConstructTest extends GitUpdater_UnitTestCase {
	/**
	 * Tests that the 'slug' property is set.
	 *
	 * @dataProvider data_file_paths_and_slugs
	 *
	 * @param string $file_path The file path.
	 * @param string $slug      The expected slug.
	 */
	public function test_should_set_slug_property( $file_path, $slug ) {
		$this->assertSame(
			$slug,
			$this->get_property_value( new \Fragen\Git_Updater\Lite( $file_path ), 'slug' )
		);
	}

	/**
	 * Data provider.
	 *
	 * @return array[]
	 */
	public function data_file_paths_and_slugs() {
		return array(
			'a theme'  => array(
				'file_path' => $this->test_files['theme'],
				'slug'      => 'my-theme',
			),
			'a plugin' => array(
				'file_path' => $this->test_files['plugin'],
				'slug'      => 'my-plugin',
			),
		);
	}

	/**
	 * Tests that the 'file' property is set.
	 *
	 * @dataProvider data_file_paths_and_files
	 *
	 * @param string $file_path The file path.
	 * @param string $file      The expected file.
	 */
	public function test_should_set_file_property( $file_path, $file ) {
		$this->assertSame(
			$file,
			$this->get_property_value( new \Fragen\Git_Updater\Lite( $file_path ), 'file' )
		);
	}

	/**
	 * Data provider.
	 *
	 * @return array[]
	 */
	public function data_file_paths_and_files() {
		return array(
			'a theme'  => array(
				'file_path' => $this->test_files['theme'],
				'file'      => 'my-theme/style.css',
			),
			'a plugin' => array(
				'file_path' => $this->test_files['plugin'],
				'file'      => 'my-plugin/my-plugin.php',
			),
		);
	}

	/**
	 * Tests that the 'local_version' property is set.
	 *
	 * @dataProvider data_file_paths_and_versions
	 *
	 * @param string $file_path The file path.
	 * @param string $version   The expected version.
	 */
	public function test_should_set_local_version_property( $file_path, $version ) {
		$this->assertSame(
			$version,
			$this->get_property_value( new \Fragen\Git_Updater\Lite( $file_path ), 'local_version' )
		);
	}

	/**
	 * Data provider.
	 *
	 * @return array[]
	 */
	public function data_file_paths_and_versions() {
		return array(
			'a theme'  => array(
				'file_path' => $this->test_files['theme'],
				'version'   => '1.0.1',
			),
			'a plugin' => array(
				'file_path' => $this->test_files['plugin'],
				'version'   => '1.0.2',
			),
		);
	}

	/**
	 * Tests that the 'update_server' property is set.
	 *
	 * @dataProvider data_file_paths_and_servers
	 *
	 * @param string $file_path The file path.
	 * @param string $server   The expected server.
	 */
	public function test_should_set_local_server_property( $file_path, $server ) {
		$this->assertSame(
			$server,
			$this->get_property_value( new \Fragen\Git_Updater\Lite( $file_path ), 'update_server' )
		);
	}

	/**
	 * Data provider.
	 *
	 * @return array[]
	 */
	public function data_file_paths_and_servers() {
		return array(
			'a theme'                        => array(
				'file_path' => $this->test_files['theme'],
				'server'    => 'https://github.com/afragen/git-updater-lite/my-theme',
			),
			'a plugin'                       => array(
				'file_path' => $this->test_files['plugin'],
				'server'    => 'https://github.com/afragen/git-updater-lite/my-plugin',
			),
			'a theme with no update server'  => array(
				'file_path' => $this->test_files['theme_no_server'],
				'server'    => '',
			),
			'a plugin with no update server' => array(
				'file_path' => $this->test_files['plugin_no_server'],
				'server'    => '',
			),
		);
	}
}
