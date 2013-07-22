<?php

namespace wiro\modules\csv\components;

use CComponent;
use Yii;
use ZipArchive;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class CsvExporter extends CComponent
{
    private $outputFile;
    private $tables = array();
    
    public function setOutputFile($filename)
    {
	$this->outputFile = $filename;
	return $this;
    }
    
    public function setTables(array $tables)
    {
	$this->tables = $tables;
	return $this;
    }
    
    public function export()
    {
	$files = $this->generateCsvFiles();
	$this->downloadZipFile($files);
    }
    
    private function generateCsvFiles()
    {
	$files = array();
	foreach($this->tables as $table) 
	    $files[$table.'.csv'] = $this->generateCsvFile($table);
	return $files;
    }
    
    private function generateCsvFile($table)
    {
	$tableSchema = Yii::app()->db->schema->tables[$table];
	$columns = array_map(function($column) {
	    return $column->name;
	}, $tableSchema->columns);
	
	$filename = tempnam(sys_get_temp_dir(), uniqid());
	$file = fopen($filename, 'w+');
	fputcsv($file, $columns);
	
	$result = Yii::app()->db->createCommand()->select('*')->from($table)->query();
	foreach($result as $row) 
	    fputcsv($file, $row);
	
	fclose($file);
	return $filename;
    }
    
    private function downloadZipFile($files)
    {
	$zipfile = tempnam(sys_get_temp_dir(), uniqid());
	$zip = new ZipArchive();
        $zip->open($zipfile, ZipArchive::CREATE);
        foreach($files as $table => $file)
            $zip->addFile($file, $table);
        $zip->close();
	
	Yii::app()->request->sendFile($this->outputFile, file_get_contents($zipfile));
    }
}