<?php

include_once(APPPATH . "third_party/PhpWord/Autoloader.php");

use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();
Settings::loadConfig();

class Phpword {

	private $php_word;
	private $font_style_heading = array(
		"name" => "Arial",
		"size" => 26
	);
	private $font_style_heading_1 = array(
		"name" => "Arial",
		"size" => 14,
		"bold" => true
	);
	private $font_style_heading_2 = array(
		"name" => "Arial",
		"size" => 13,
		"bold" => true
	);
	private $font_style_heading_3 = array(
		"name" => "Arial",
		"size" => 11,
		"bold" => true
	);
	private $font_style_heading_4 = array(
		"name" => "Arial",
		"size" => 11,
		"bold" => true,
		"italic" => true
	);
	private $font_style_heading_5 = array(
		"name" => "Arial",
		"size" => 11
	);
	private $font_style_heading_6 = array(
		"name" => "Arial",
		"size" => 11,
		"italic" => true
	);
	private $table_style_name = 'Table style';
	private $table_style = array(
		"borderSize" => 6,
		"borderColor" => "A5A5A5"
	);
	private $table_first_row_style = array(
		"borderBottomSize" => 30,
		"borderColor" => "3C3C3C",
		"bgColor" => "E1E1E1"
	);

	public function __construct() {
		$this->php_word = new \PhpOffice\PhpWord\PhpWord();
		$this->php_word->addTitleStyle(1, $this->font_style_heading_1);
		$this->php_word->addTitleStyle(2, $this->font_style_heading_2);
		$this->php_word->addTitleStyle(3, $this->font_style_heading_3);
		$this->php_word->addTitleStyle(4, $this->font_style_heading_4);
		$this->php_word->addTitleStyle(5, $this->font_style_heading_5);
		$this->php_word->addTitleStyle(6, $this->font_style_heading_6);
		$this->php_word->addTableStyle($this->table_style_name, $this->table_style, $this->table_first_row_style);
	}

	public function get_section() {
		$section = $this->php_word->addSection();

		return $section;
	}

	public function add_document_title($text, $section = FALSE) {
		if (!$section) {
			$section = $this->php_word->addSection();
		}

		$section->addText($text, $this->font_style_heading);
	}

	public function add_title($text, $depth, $section = FALSE) {
		if (!$section) {
			$section = $this->php_word->addSection();
		}

		$section->addTitle($text, $depth);
	}

	public function add_text($text, $section = FALSE) {
		if (!$section) {
			$section = $this->php_word->addSection();
		}

		$section->addText($text);
	}

	public function add_table($firstRow, $data, $section = FALSE) {
		if (!$section) {
			$section = $this->php_word->addSection();
		}

		$table = $section->addTable($this->table_style_name);

		$table->addRow();
		foreach ($firstRow as $cell) {
			$table->addCell(9000 / sizeof($firstRow))->addText($cell);
		}

		$cell = NULL;

		foreach ($data as $row) {
			$table->addRow();
			foreach ($row as $cell) {
				$table->addCell(9000 / sizeof($row))->addText($cell);
			}
		}
	}

	public function add_unordered_list_item($text, $section) {
		$section->addListItem($text);
	}

	public function download($filename) {
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->php_word, "Word2007");
		$objWriter->save($filename);
		header("Content-Description: File Transfer");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . $filename);
		header("Content-Transfer-Encoding: binary");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Content-Length: " . filesize($filename));
		flush();
		readfile($filename);
		unlink($filename);
		exit;
	}

}
