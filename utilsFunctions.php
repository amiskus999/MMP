<?php
    /**
     * These utility functions are used across multiple files to handle user data and what items to render on the BuyPage
     * when a user is performing a search to see what items match the name they are searching for.
     */
    function organizeData(){
        $file = fopen("data/UserDatabase.txt","r");
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
        $lines = file("data/UserDatabase.txt") ;  // Read the file into an array of lines
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

    function renderItem($value){
        $imagePath = $value['image_paths'][0];
        $encoded = urlencode($value['id']);
        $altText = htmlspecialchars($value['title']); // Escape title for alt attribute
        $results = <<<HTML
        <!-- // Print each product card -->
        <a href="BuyItem.php?id={$encoded}" class="product-link">
        <div class="product-card">
        <div class="image-placeholder">
        <img src="{$imagePath}" alt="{$altText}" style="height: 160px; width: 100%; object-fit: cover;">
        </div> <div class="product-details">
        <p class="price">\${$value['price']}</p>
        <p class="name">{$value['title']}</p>
        </div>
        </div>
        </a>
        HTML;
        echo $results;
    }
?>