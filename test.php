<?php
require 'bind.php';

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

function Search ($string, $spreadsheet){
    $worksheet = $spreadsheet->getActiveSheet();

    $x = 0;
    $y = 0;
    $firstCoord[][] = "";

    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);

       foreach ($cellIterator as $cell) {
            $text = $cell->getValue();
            $check = strpos($text, $string);
            if ($check !== false){
                $firstCoord[$x][0] = Coordinate::columnIndexFromString($cell->getColumn());
                $firstCoord[$x][1] = $cell->getRow();
                $x++;
            }
            $boobs = Coordinate::columnIndexFromString($cell->getColumn())." ".$cell->getRow();
        }
    }

    return $firstCoords;
}

function selectArea($firstCoord, $spreadsheet) {
    $check = 1;
    $x = int($firstCoord[0][1]) + 1;
    while($check = 1) {
        $cell = $spreadsheet->getActiveSheet()->getCell('A
    }
    
}



$reader = IOFactory::createReader("Xls");
$spreadsheet = $reader->load("spo.xls");

var_dump(Search("ИСП-220р", $spreadsheet));


?>