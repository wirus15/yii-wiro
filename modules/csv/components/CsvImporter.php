<?php

namespace wiro\modules\csv\components;

use CComponent;
use Yii;
use ZipArchive;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class CsvImporter extends CComponent
{
    public function import($zipFile)
    {
	$files = $this->extractZip($zipFile);
	foreach($files as $file) 
	    $this->importFromFile($file);
    }
    
    private function extractZip($file)
    {
	$dir = tempnam(sys_get_temp_dir(), uniqid());
	if(file_exists($dir))
	    unlink($dir);
	mkdir($dir);
	
	$zip = new ZipArchive();
	$zip->open($file);
	$zip->extractTo($dir);
	$zip->close();
	
	$files = array();
	foreach(scandir($dir) as $file) {
	    if(is_dir($file="$dir/$file"))
		continue;
	    $files[] = $file;
	}
	return $files;
    }
    
    private function importFromFile($file)
    {
	$tableName = pathinfo($file, PATHINFO_FILENAME);
	$tableSchema = Yii::app()->db->schema->tables[$tableName]; 
	$primaryKey = $tableSchema->primaryKey;
	$existingPks = array_flip(Yii::app()->db->createCommand()->select($primaryKey)->from($tableName)->queryColumn());
	
	$file = fopen($file, 'r');
	$columnNames = fgetcsv($file);
	$keyPos = array_search($primaryKey, $columnNames);
	
	while($row=fgetcsv($file)) {
	    $pkValue = $row[$keyPos];
	    $columns = array_combine($columnNames, $row);
	    array_walk($columns, function(&$item, $key) use ($tableSchema) {
		if($item === '' && $tableSchema->getColumn($key)->allowNull)
		    $item = null;
	    });
	    
	    $cmd = Yii::app()->db->createCommand();
	    if(isset($existingPks[$pkValue])) {
		unset($columns[$primaryKey]);
		$cmd->update($tableName, $columns, $primaryKey.'=:pk', array(':pk' => $pkValue));
	    } else {
		$cmd->insert($tableName, $columns);
	    }
	}
	fclose($file);
    }
}