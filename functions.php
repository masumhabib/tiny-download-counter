<?php

/*
 * Gets the file path from database, sends the file and updates the count.
 */
function tdc_do_download($file_name){
    $database = tdc_open_database(TDC_DATABASE_FILE);
    $filenode = tdc_find_filenode($database, $file_name);

    if($filenode != null){
        $file_path = TDC_DOC_ROOT . tdc_get_filepath($filenode);
        $file_name = tdc_get_filename($filenode);
        if(tdc_send_file($file_path, $file_name)){
            tdc_update_count($database, $filenode, TDC_DATABASE_FILE);
        }
    }
}

/** 
 * Returns information about the requested file.
 */
function tdc_get_fileinfo($file_name){
    $link = TDC_PLUGIN_URL."download.php?file_name=".$file_name;
    $label = $file_name;

    $database = tdc_open_database(TDC_DATABASE_FILE);
    $filenode = tdc_find_filenode($database, $file_name);
    $count = tdc_get_count($filenode);
    $size = tdc_get_filesize($filenode);

    return array($link, $label, $size, $count);
}


/**
 * Calculates and returns file size.
 */
function tdc_get_filesize($filenode){
    $file_path = tdc_get_filepath($filenode);
    $file_name = tdc_get_filename($filenode);
    $full_path = TDC_DOC_ROOT . $file_path . "/" .$file_name;
    $size = filesize($full_path);
    return human_filesize($size);
}

/**
 * Returns file path from file node.
 */
function tdc_get_filepath($filenode){
    return $filenode->path[0];
}

/**
 * Returns file name from file node.
 */
function tdc_get_filename($filenode){
    return $filenode['name'];
}

/**
 * Returns download count from file node.
 */
function tdc_get_count($filenode){
    return $filenode->downloadcount[0]; 
}

/**
 * Find the requested file in the database.
 */
function tdc_find_filenode($database, $file_name){
    $file = $database->xpath('//file[@name="'.$file_name.'"]');
    if($file != False){
        return $file[0];
    }
}

/**
 * Increases the download count field.
 */
function tdc_update_count($database, $filenode, $database_file){
    $count = (int)$filenode->downloadcount[0] + 1;
    $filenode->downloadcount[0] = (string)$count;
    if ($database->asXML($database_file) === false){
        throw new Exception('Cannot save values into "'.$database_file.'"',99);
    }
}

/**
 * This function sends the requested file for download.
 */
function tdc_send_file($file_path, $file_name){
    if (file_exists($file_path."/".$file_name)) {
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
        header("Cache-Control: public"); // needed for i.e.
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length:".filesize($file_path."/".$file_name));
        header("Content-Disposition: attachment; filename=".$file_name);
        readfile($file_path."/".$file_name);
        return True;
    }
}

/**
 * Opens database and return xml schema.
 */
function tdc_open_database($database_file){
    // if database file does not exist, create one.
    if(!file_exists($database_file)){
        $xml = "
            <?xml version='1.0' encoding='UTF-8'?>
                <downloads>
                </downloads>
        ";
        $file = fopen($database_file, "w") or die("ERROR: Tiny Download Counter - unable to open database file!");
        fwrite($file, $xml);
        fclose($file);
    }

    $xml = simplexml_load_file($database_file) or die("ERROR: Tiny Download Counter - unable to open database file!");
    return $xml; 
}

/**
 * Human readable file size.
 */
function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

?>
