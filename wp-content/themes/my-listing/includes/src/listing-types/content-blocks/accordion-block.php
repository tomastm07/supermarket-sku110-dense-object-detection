<?php

namespace MyListing\Src\Listing_Types\Content_Blocks;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Accordion_Block extends Base_Block {
	use Traits\Content_Rows;

	public function props() {
		$this->props['type'] = 'accordion';
		$this->props['title'] = 'Accordion';
		$this->props['icon'] = 'mi view_module';
		$this->props['rows'] = [];
	}

	public function get_editor_options() {
		$this->getLabelField();
		$this->getRowsField();
	}

}