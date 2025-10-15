<?php
/**
 * Класс вспомогательных методов для плагина.
 *
 * Этот класс содержит статические методы для работы с настройками темы,
 * генерации URL и путей к ресурсам, а также другие утилитарные функции.
 *
 * @class  Helper
 * @package Strt\Theme\Utils
 * @version 1.0.0
 */

namespace Strt\Theme\Utils;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Strt\Theme\Utils\Helper' ) ) {

	/**
	 * Класс Helper.
	 *
	 * Предоставляет вспомогательные методы для работы с темой.
	 */
	class Helper {

		/**
		 * Получить название сайта.
		 *
		 * @return string Название сайта.
		 */
		public static function get_site_name(): string {
			return get_bloginfo( 'name' );
		}

		/**
		 * Получить имя плагина.
		 *
		 * @return string Имя плагина.
		 */
		public static function get_name(): string {
			return wp_get_theme()->get( 'Name' );
		}

		/**
		 * Получить путь к файлу плагина.
		 *
		 * @return string Путь к файлу плагина.
		 */
		public static function get_file(): string {
			return basename( STRT_THEME_FILE );
		}

		/**
		 * Получить путь к директории плагина.
		 *
		 * @param  string  $path  Путь, который добавляется к корню директории.
		 *
		 * @return string Путь к директории.
		 */
		public static function get_dir_path( string $path = '' ): string {
			return trailingslashit( get_stylesheet_directory() ) . ltrim( $path, '/' );
		}

		/**
		 * Получить URL директории плагина.
		 *
		 * @param  string  $path  Путь, который добавляется к URL директории.
		 *
		 * @return string URL директории плагина.
		 */
		public static function get_dir_url( string $path = '' ): string {
			return trailingslashit( get_stylesheet_directory_uri() ) . ltrim( $path, '/' );
		}

		/**
		 * Получить URL директории с CSS файлами.
		 *
		 * @param  string  $path  Путь к конкретному CSS файлу.
		 *
		 * @return string URL директории с CSS файлами.
		 */
		public static function get_dir_url_css( string $path = '' ): string {
			return self::get_dir_url( 'assets/css/' . ltrim( $path, '/' ) );
		}

		/**
		 * Получить URL директории с JS файлами.
		 *
		 * @param  string  $path  Путь к конкретному JS файлу.
		 *
		 * @return string URL директории с JS файлами.
		 */
		public static function get_dir_url_js( string $path = '' ): string {
			return self::get_dir_url( 'assets/js/' . ltrim( $path, '/' ) );
		}

		/**
		 * Получить URL директории с IMG файлами.
		 *
		 * @param  string  $path  Путь к конкретному IMG файлу.
		 *
		 * @return string URL директории с JS файлами.
		 */
		public static function get_dir_url_img( string $path = '' ): string {
			return self::get_dir_url( 'assets/img/' . ltrim( $path, '/' ) );
		}

		/**
		 * Получить slug плагина.
		 *
		 * @return string Slug плагина.
		 */
		public static function get_slug(): string {
			return 'start-theme';
		}

		/**
		 * Генерирует уникальный идентификатор (handle) с префиксом `re-theme`.
		 * Если параметр `$handle` пустой, возвращается только `re-theme`.
		 *
		 * @param  string|null  $handle  Идентификатор, который будет добавлен к префиксу (необязательный).
		 *
		 * @return string Сформированный идентификатор.
		 */
		public static function handle( ?string $handle = null ): string {
			return $handle ? self::get_slug() . '-' . $handle : self::get_slug();
		}

		/**
		 * Получить версию плагина.
		 *
		 * @return string Версия плагина.
		 */
		public static function get_version(): string {
			return STRT_THEME_VERSION;
		}
	}
}
