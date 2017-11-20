<?php

/*
 * This class contains helper methods for reading excel sheet.
 */

/**
 * Description of HelperMethods
 *
 * @author bisjo
 */
class HelperMethods {
    
  
    /**
     * This method will return the values in the sheet as an associative array
     * @param type $objPHPExcel
     * @return type
     */
    
    public function getSpreadSheetValuesAsArray(PHPExcel $objPHPExcel){
        
        $returnObj = array();
        $headingsArray = array();
        foreach ($objPHPExcel->getSheet()->getRowIterator() as $row){
            
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $headingsArray = (count($headingsArray)>0)?$headingsArray:$this->getHeadingsArray($cellIterator);
            if(count($headingsArray)>0){
                $returnCellObj = $this->getCellValuesAsArray($cellIterator, $headingsArray);
            }else{
                return null;
            }
            if(count($returnCellObj)>0){
                $returnObj[$row->getRowIndex()] = $returnCellObj;
            }
        }
        return array_values($returnObj);
    }
    
    /**
     * Get cell values as array
     * @param PHPExcel_Worksheet_CellIterator $cellIterator
     * @param type $headingsArray
     * @return type
     */
    public function getCellValuesAsArray(PHPExcel_Worksheet_CellIterator $cellIterator, $headingsArray) {
        $returnCellObj = array();
        foreach ($cellIterator as $cell) {
            if($cell->getRow() === 1){
                continue;
            }
            $columnIndex = $cell->columnIndexFromString($cell->getColumn());
            $returnCellObj[$headingsArray[$columnIndex-1]] = $cell->getCalculatedValue();
        }
        return $returnCellObj;
    }
    
    
    
    /**
     * Returns heading as array
     * @param PHPExcel_Worksheet_CellIterator $cellIterator
     * @return type
     */
    public function getHeadingsArray(PHPExcel_Worksheet_CellIterator $cellIterator) {
        $headingsArray = array();
        foreach ($cellIterator as $cell) {
            if($cell->getRow() === 1){
                $headingsArray[] = $cell->getValue();
            }else if(count($headingsArray)>0){
                break;
            }else{
                continue;
            }
        }
        return $headingsArray;
    }
    
    
    
}
