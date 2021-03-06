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

use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class ConfiguredSheetTest extends TestCase {

	public function testSetters() {
		$translator = $this->getMockBuilder(TranslatorInterface::class)->setMethods(array('trans'))->getMockForAbstractClass();
		$translator->method('trans')->willReturn('translated');
		
		$excel = new ConfiguredExcel($translator);
		$sheet = $excel->addSheet('TestSheet');
		$sheet->setData($this->getArrayData(10));
		
		
		$simpleBinding = new ColumnBinding();
		$simpleBinding->setBinding('[1]');
		$simpleBinding->setLabel('simpleBinding');
		$simpleBinding->setLinkUrl('http://www.google.de');
		$sheet->addColumnBinding($simpleBinding);

		$index = $sheet->getIndexForBinding($simpleBinding);
		$this->assertEquals(0, $index);
		
		$sheet->applyData();
		
	
	}

	protected function getArrayData($count = 10, $columns = 10) {
		$data = array();
		for($i = 0; $i < $count; $i++) {
			$item = array();
			for($j = 0; $j < $columns; $j++) {
				$item[$j] = 'Test ' . $i . ':' . $j;
			}
			$data[] = $item;
		}
		return $data;
	}
}