<?php
/**
 * Функции и определения темы.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Strt\Theme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Определение констант
if ( ! defined( 'STRT_THEME_FILE' ) ) {
	define( 'STRT_THEME_FILE', __FILE__ );
}

if ( ! defined( 'STRT_THEME_VERSION' ) ) {
	define( 'STRT_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
}

// Проверяем версию PHP
if ( version_compare( PHP_VERSION, '8.3.0', '<' ) ) {
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-error"><p>Start Theme: Ваша версия PHP ниже 8.3.0. Пожалуйста, обновите её для использования этой темы.</p></div>';
	} );

	return;
}

// Автозагрузка через Composer
$autoload_path = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoload_path ) ) {
	require $autoload_path;
} else {
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-error"><p>Start Theme: Не найден autoload.php. Проверьте установку Composer.</p></div>';
	} );

	return;
}

if ( ! class_exists( 'Strt\Theme\Setup\Container' ) || ! class_exists( 'Strt\Theme\Setup\ServiceProvider' ) ) {
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-error"><p>Start Theme: Не найдены классы Container или ServiceProvider. Возможно, ошибка в autoload или namespace.</p></div>';
	} );

	return;
}

use Strt\Theme\Setup\Container;
use Strt\Theme\Setup\ServiceProvider;

if ( ! class_exists( 'StrtThemeContainer' ) ) {

	/**
	 * StrtThemeContainer класс для хранения экземпляра контейнера зависимостей.
	 */
	final class StrtThemeContainer {

		/**
		 * Единственный экземпляр контейнера.
		 *
		 * @var Container|null
		 */
		private static ?Container $instance = null;

		/**
		 * Получает или создаёт экземпляр контейнера.
		 *
		 * @return Container Экземпляр контейнера.
		 */
		public static function getInstance(): Container {
			if ( null === self::$instance ) {
				self::$instance = new Container();
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'strt_theme_get_container' ) ) {

	/**
	 * Возвращает глобальный экземпляр контейнера.
	 *
	 * @return Container Экземпляр контейнера.
	 */
	function strt_theme_get_container(): Container {
		return StrtThemeContainer::getInstance();
	}
}

// Инициализация сервис-провайдера
try {
	$service_provider = new ServiceProvider( strt_theme_get_container() );
	$service_provider->register();
	$service_provider->boot();
} catch ( Exception $e ) {
	add_action( 'admin_notices', function () use ( $e ) {
		printf( '<div class="notice notice-error"><p>Start Theme: %s</p></div>', esc_html( $e->getMessage() ) );
	} );
}

