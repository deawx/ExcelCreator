<?php

/*
 * This file is part of the Stinger Excel Creator package.
 *
 * (c) Oliver Kotte <oliver.kotte@stinger-soft.net>
 * (c) Florian Meyer <florian.meyer@stinger-soft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StingerSoft\ExcelCreator;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Abstraction class to represent a single excel file
 */
class ConfiguredExcel {
	
	use Helper;

	/**
	 * The sheets of this excel file
	 *
	 * @var ArrayCollection|ConfiguredSheet[]
	 */
	protected $sheets;

	/**
	 * The underyling excel file of PHPExcel
	 *
	 * @var \PHPExcel
	 */
	protected $phpExcel;

	/**
	 * Default contructor
	 */
	public function __construct(TranslatorInterface $translator) {
		$this->phpExcel = new \PHPExcel();
		$this->sheets = new ArrayCollection();
		$this->translator = $translator;
	}

	/**
	 * Adds and returns a new sheet
	 *
	 * @param string $title
	 *        	The title of the new sheet
	 * @return \StingerSoft\ExcelCreator\ConfiguredSheet
	 */
	public function addSheet($title) {
		$excelSheet = null;
		if($this->sheets->isEmpty()) {
			$excelSheet = $this->phpExcel->getActiveSheet();
		} else {
			$excelSheet = $this->phpExcel->createSheet($this->sheets->count());
		}
		$this->setSheetTitle($excelSheet, $title);
		$sheet = new ConfiguredSheet($this, $excelSheet, $this->translator);
		$this->sheets->add($sheet);
		return $sheet;
	}

	/**
	 * Returns the worksheets of this excel file
	 *
	 * @return ConfiguredSheet[]
	 */
	public function getSheets() {
		return $this->sheets;
	}

	/**
	 * Returns the title of this excel file
	 *
	 * @return string The title of this excel file
	 */
	public function getTitle() {
		return $this->phpExcel->getProperties()->getTitle();
	}

	/**
	 * Sets the title of this excel file
	 *
	 * @param string $title
	 *        	The title of this excel file
	 */
	public function setTitle($title) {
		$this->phpExcel->getProperties()->setTitle($title);
	}

	/**
	 * Get the author of this excel file
	 * 
	 * @return string The author of this excel file
	 */
	public function getCreator() {
		return $this->phpExcel->getProperties()->getCreator();
	}

	/**
	 * Sets the author of this excel file
	 * 
	 * @param string $creator
	 *        	The author of this excel file
	 */
	public function setCreator($creator) {
		$this->phpExcel->getProperties()->setCreator($creator);
	}

	/**
	 * Returns the underyling PHPExcel object
	 *
	 * @return PHPExcel The underyling PHPExcel object
	 */
	public function getPhpExcel() {
		return $this->phpExcel;
	}
}