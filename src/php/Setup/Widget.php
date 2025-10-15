<?php

namespace Strt\Theme\Setup;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Strt\Theme\Widget' ) ) {

	class Widget {

		public function init(): void {
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		}

		public function widgets_init() {
			register_sidebar(
				[
					'id'            => 'strt-sidebar-left',
					'name'          => 'Боковая панель слева',
					'description'   => '',
					'before_widget' => '<section id="%1$s" class="card mb-4 widget %2$s shadow-sm">',
					'after_widget'  => '</div></section>',
					'before_title'  => '<h4 class="card-header fs-5 widget-title rounded-top-2">',
					'after_title'   => '</h4><div class="card-body">',
				]
			);

			register_sidebar(
				[
					'id'            => 'strt-sidebar-right',
					'name'          => 'Боковая панель справа',
					'description'   => '',
					'before_widget' => '<section id="%1$s" class="card mb-4 widget %2$s shadow-sm">',
					'after_widget'  => '</div></section>',
					'before_title'  => '<h4 class="card-header fs-5 widget-title rounded-top-2">',
					'after_title'   => '</h4><div class="card-body">',
				]
			);
		}
	}
}
