<?php
/**
 * ServiceProvider — регистратор и загрузчик сервисов.
 *
 * Отвечает за регистрацию зависимостей в контейнере и их инициализацию.
 * Используется как центральный класс для управления сервисами.
 *
 * @class  ServiceProvider
 * @package Strt\Theme\Setup
 * @version 1.0.0
 */

namespace Strt\Theme\Setup;

defined( 'ABSPATH' ) || exit;

use Strt\Theme\Assets\Asset;
use Strt\Theme\Hooks\ThemeHook;
use Strt\Theme\Utils\Helper;

if ( ! class_exists( 'Strt\Theme\Setup\ServiceProvider' ) ) {

	/**
	 * Класс ServiceProvider.
	 *
	 * Позволяет регистрировать и загружать сервисы в контейнере.
	 */
	class ServiceProvider {

		/**
		 * Экземпляр контейнера зависимостей.
		 *
		 * @var Container
		 */
		protected Container $container;

		/**
		 * Список классов для регистрации.
		 *
		 * @var array
		 */
		protected array $services = [

			// Базовые сервисы ядра темы.
			'helper'           => Helper::class,
			'setup'            => Setup::class,
			'widget'           => Widget::class,
			'asset'            => Asset::class,

			// Сервисы для регистрации хуков.
			'theme_hook'       => ThemeHook::class,
		];

		/**
		 * Конструктор класса ServiceProvider.
		 *
		 * @param  Container  $container  Экземпляр контейнера для управления зависимостями.
		 */
		public function __construct( Container $container ) {
			$this->container = $container;
		}

		/**
		 * Регистрация сервисов.
		 *
		 * @return void
		 */
		public function register(): void {
			foreach ( $this->services as $key => $service_class ) {
				$this->container->bind( $key, function () use ( $service_class ) {
					return $this->container->make( $service_class );
				} );
			}
		}

		/**
		 * Инициализация зарегистрированных сервисов.
		 *
		 * @return void
		 */
		public function boot(): void {
			foreach ( $this->services as $key => $service_class ) {
				if ( $this->container->has( $key ) ) {
					$instance = $this->container->make( $key );

					if ( is_object( $instance ) && method_exists( $instance, 'init' ) ) {
						$instance->init();
					}
				}
			}
		}
	}
}
