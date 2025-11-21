<?php
    function organizeData(){
        $file = fopen("UserDatabase.txt","r");
        if($file == false){
            return null;
        }
        //$criteria = $_POST["userRole"];
        $fileHeader = explode("\t",fgets($file)); // Read and discard the header line
        $i = 0;
        $headerIndex = [];

        foreach($fileHeader as $header){
            $headerIndex[trim($header)] = $i;
            $i++;
        }
        $lines = file("UserDatabase.txt") ;  // Read the file into an array of lines
        array_shift($lines); // Remove the header line
        $mids = [];
        $i = 0;
        foreach($lines as $line){
            $data = explode("\t",$line);
            $mids[$i] = $data;
            $i++;
        }
        fclose($file);
        return [$headerIndex,$mids];
    }

?>