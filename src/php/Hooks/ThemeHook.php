<?php
/**
 * Класс ThemeHook для подключения фильтров и хуков WordPress в теме.
 * Используется внутри темы через контейнер зависимостей.
 *
 * @class   ThemeHook
 * @package Strt\Theme\Hooks
 * @version 1.0.0
 */

namespace Strt\Theme\Hooks;

defined( 'ABSPATH' ) || exit;

use Strt\Theme\Setup\Container;
use Strt\Theme\Utils\Helper;

if ( ! class_exists( 'Strt\Theme\Hooks\ThemeHook' ) ) {

	/**
	 * Класс ThemeHook.
	 *
	 * Управляет подключением действий и фильтров темы.
	 */
	class ThemeHook {

		/**
		 * Контейнер зависимостей.
		 *
		 * @var Container
		 */
		protected Container $container;

		/**
		 * Экземпляр вспомогательного класса.
		 *
		 * @var Helper
		 */
		protected Helper $helper;

		/**
		 * Конструктор класса ThemeHook.
		 *
		 * @param  Container  $container  Экземпляр контейнера зависимостей.
		 * @param  Helper  $helper  Вспомогательный объект.
		 */
		public function __construct( Container $container, Helper $helper ) {
			$this->container = $container;
			$this->helper    = $helper;
		}

		/**
		 * Инициализирует регистрацию всех фильтров и действий темы.
		 *
		 * Вызывается при старте темы, подключает фильтры и действия.
		 */
		public function init(): void {
			$this->add_filters();
			$this->remove_filters();

			$this->add_actions();
			$this->remove_actions();
		}

		/**
		 * Регистрирует фильтры WordPress.
		 */
		public function add_filters(): void {

		}

		/**
		 * Удаляет ранее зарегистрированные фильтры (если требуется).
		 */
		public function remove_filters() {

		}

		/**
		 * Регистрирует действия WordPress.
		 */
		public function add_actions(): void {

		}

		/**
		 * Удаляет ранее зарегистрированные действия.
		 */
		public function remove_actions() {

		}
	}
}