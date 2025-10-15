<?php
/**
 * Класс Setup для инициализации и настройки.
 *
 * Этот класс отвечает за инициализацию, подключение стилей и поддержку WooCommerce.
 *
 * @class  Setup
 * @package Strt\Theme\Setup
 * @version 1.0.0
 */

namespace Strt\Theme\Setup;

defined( 'ABSPATH' ) || exit;

use Strt\Theme\Utils\Helper;

if ( ! class_exists( 'Strt\Theme\Setup' ) ) {

	/**
	 * Класс Setup.
	 *
	 * Выполняет настройки.
	 */
	class Setup {

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
			//add_action( 'init', [ $this, 'register_nav_menus' ] );
			add_action( 'after_setup_theme', [ $this, 'setup' ] );
		}

		public function register_nav_menus(): void {
			register_nav_menus(
				[
					'strt-nav-menu-header'   => 'Главное меню',
					'strt-nav-menu-footer-1' => 'Футер меню 1',
					'strt-nav-menu-footer-2' => 'Футер меню 2',
				]
			);
		}

		/**
		 * Настраивает тему, добавляя поддержку различных функций WordPress.
		 *
		 * @return void
		 */
		public function setup(): void {
			add_theme_support( 'post-formats', [ 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ] );
			add_theme_support( 'menus' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'wp-block-styles' );

			add_editor_style(
				[
					'assets/css/fonts.min.css',
					'assets/css/bootstrap-icons.min.css',
					'assets/css/bootstrap.min.css',
					'assets/css/bootstrap-editor.min.css',
				]
			);

			add_image_size( 'strt-theme-logo-200x40', 200, 40, true );
		}
	}
}