<?php
/**
 * Класс Assets для регистрации скриптов и стилей.
 *
 * @class  Assets
 * @package Strt\Theme\Assets
 * @version 1.0.0
 */

namespace Strt\Theme\Assets;

defined( 'ABSPATH' ) || exit;

use Strt\Theme\Utils\Helper;

if ( ! class_exists( 'Strt\Theme\Assets\Asset' ) ) {

	/**
	 * Класс Assets.
	 *
	 * Регистрирует скрипты и стили.
	 */
	class Asset {

		/**
		 * Экземпляр вспомогательного класса.
		 *
		 * @var Helper
		 */
		protected Helper $helper;

		/**
		 * Конструктор.
		 *
		 * @param  Helper  $helper  Экземпляр класса Helper.
		 */
		public function __construct( Helper $helper ) {
			$this->helper = $helper;
		}

		/**
		 * Инициализация.
		 *
		 * @return void
		 */
		public function init(): void {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_editor_assets' ], 1 );
		}

		/**
		 * Подключает зарегистрированные скрипты.
		 *
		 * @return void
		 */
		public function enqueue_scripts(): void {
			$this->enqueue_style( 'fonts' );
			$this->enqueue_style( 'bootstrap' );
			$this->enqueue_style( 'bootstrap-icons' );

			if ( is_page( 'doc' ) ) {
				$this->enqueue_style( 'prism-okaidia' );
				$this->enqueue_style( 'doc' );

				$this->enqueue_script( 'bootstrap', 'bootstrap.bundle' );
				$this->enqueue_script( 'prism' );
				$this->enqueue_script( 'doc' );
			}

			//$this->enqueue_script( 'bootstrap', 'bootstrap.bundle' );
			//$this->enqueue_script( 'app' );
		}

		/**
		 * Подключает стили и скрипты для блоков Gutenberg.
		 *
		 * Этот метод вызывается через хук `enqueue_block_assets` и используется
		 * как для фронтенда, так и редактора.
		 */
		public function enqueue_block_editor_assets(): void {
			if ( wp_should_load_block_editor_scripts_and_styles() ) {
				$this->enqueue_style( 'fonts' );
				$this->enqueue_style( 'bootstrap-editor' );
				$this->enqueue_style( 'bootstrap-icons' );
			}
		}

		public function register_style(
			string $handle,
			?string $file_name = null,
			array $deps = [],
			?string $version = null,
			string $media = 'all'
		): void {
			[ $handle, $src, $version ] = $this->get_asset_props( $handle, $file_name, 'css', $version );

			wp_register_style( $handle, $src, $deps, $version, $media );
		}

		/**
		 * Регистрирует стиль (без непосредственного подключения).
		 *
		 * @param  string  $handle  Уникальный идентификатор стиля.
		 * @param  string|null  $file_name  Имя файла без расширения (если отличается от $handle).
		 * @param  array  $deps  Массив зависимостей.
		 * @param  string|null  $version  Версия файла (по умолчанию версия темы).
		 * @param  string  $media  Медиа-тип (по умолчанию 'all').
		 *
		 * @return void
		 */
		public function enqueue_style(
			string $handle,
			?string $file_name = null,
			array $deps = [],
			?string $version = null,
			string $media = 'all'
		): void {
			[ $handle, $src, $version ] = $this->get_asset_props( $handle, $file_name, 'css', $version );

			wp_enqueue_style( $handle, $src, $deps, $version, $media );
		}


		/**
		 * Регистрирует скрипт (без непосредственного подключения).
		 *
		 * @param  string  $handle  Уникальный идентификатор скрипта.
		 * @param  string|null  $file_name  Имя файла без расширения (если отличается от $handle).
		 * @param  array  $deps  Массив зависимостей.
		 * @param  string|null  $version  Версия файла (по умолчанию версия темы).
		 * @param  bool  $in_footer  Подключать скрипт в футере (по умолчанию true).
		 *
		 * @return void
		 */
		public function register_script(
			string $handle,
			?string $file_name = null,
			array $deps = [],
			?string $version = null,
			bool $in_footer = true
		): void {
			[ $handle, $src, $version ] = $this->get_asset_props( $handle, $file_name, 'js', $version );

			wp_register_script( $handle, $src, $deps, $version, $in_footer );
		}

		/**
		 * Подключает скрипт (регистрирует и подключает, если нужно).
		 *
		 * @param  string  $handle  Уникальный идентификатор скрипта.
		 * @param  string|null  $file_name  Имя файла без расширения (если отличается от $handle).
		 * @param  array  $deps  Массив зависимостей.
		 * @param  string|null  $version  Версия файла (по умолчанию версия темы).
		 * @param  bool  $in_footer  Подключать скрипт в футере (по умолчанию true).
		 *
		 * @return void
		 */
		public function enqueue_script(
			string $handle,
			?string $file_name = null,
			array $deps = [],
			?string $version = null,
			bool $in_footer = true
		): void {
			[ $handle, $src, $version ] = $this->get_asset_props( $handle, $file_name, 'js', $version );

			wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );
		}

		/**
		 * Добавляет данные к скрипту (например, type="module").
		 *
		 * @param  string  $handle  Уникальный идентификатор скрипта.
		 * @param  string  $key  Ключ параметра.
		 * @param  mixed  $value  Значение.
		 *
		 * @return void
		 */
		public function script_add_data( string $handle, string $key, mixed $value ): void {
			[ $handle ] = $this->get_asset_props( $handle );

			wp_script_add_data( $handle, $key, $value );
		}

		/**
		 * Локализует данные для скрипта.
		 *
		 * @param  string  $handle  Уникальный идентификатор скрипта.
		 * @param  string  $object_name  Имя JS-объекта.
		 * @param  array  $data  Массив данных для передачи в скрипт.
		 *
		 * @return void
		 */
		public function localize_script( string $handle, string $object_name, array $data ): void {
			[ $handle ] = $this->get_asset_props( $handle );

			wp_localize_script( $handle, $object_name, $data );
		}

		/**
		 * Добавляет инлайновый скрипт.
		 *
		 * @param  string  $handle  Уникальный идентификатор скрипта.
		 * @param  string  $data  Код скрипта.
		 * @param  string  $position  Позиция вставки ('before' или 'after', по умолчанию 'after').
		 *
		 * @return void
		 */
		public function add_inline_script( string $handle, string $data, string $position = 'after' ): void {
			[ $handle ] = $this->get_asset_props( $handle );

			wp_add_inline_script( $handle, $data, $position );
		}

		/**
		 * Генерирует URL и версию для ассета.
		 *
		 * @param  string  $handle  Уникальный идентификатор ассета.
		 * @param  string|null  $file_name  Имя файла без расширения (по умолчанию равно $handle).
		 * @param  string|null  $ext  Расширение файла ('js' или 'css').
		 * @param  string|null  $version  Версия ассета (если не указано, берётся версия темы).
		 *
		 * @return array [ $handle, $src, $version ]
		 */
		protected function get_asset_props( string $handle, ?string $file_name = null, ?string $ext = 'js', ?string $version = null ): array {
			$suffix    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			$version   = $version ?? $this->helper::get_version();
			$file_name = $file_name ?? $handle;
			$handle    = $this->helper::handle( $handle );

			if ( $ext === 'js' ) {
				$src = $this->helper::get_dir_url_js( "{$file_name}{$suffix}.js" );
			} elseif ( $ext === 'css' ) {
				$src = $this->helper::get_dir_url_css( "{$file_name}{$suffix}.css" );
			} else {
				$src = '';
			}

			return [ $handle, $src, $version ];
		}
	}
}
