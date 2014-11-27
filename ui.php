<?php

function create_button($link, $label, $file_size, $dl_count, $icon_name){
    $image_link = TDC_PLUGIN_URL ."images/".$icon_name.".png";
    $image = "<img src=\"$image_link\" style=\"float:left;width:50px;height: auto;\">";
    $image = "<a href=".$link.">".$image."</a>";

    $line1 = "<a href=".$link."><strong>".$label."</strong></a>";

    $line2 = "<span style=\"font-size: 12px\">";
    if($file_size != null){
        $line2 = $line2." ($file_size"."B, ";
    }
    if($dl_count != null){
        $line2 = $line2. $dl_count." downloads)";
    }
    $line2 = $line2."</span>";

    $button = "
        <div style=\"width: 200px;moz-border-radius: 10px;-webkit-border-radius: 10px;border: 1px solid #C0C0C0;padding: 5px;background-color: #EEEEEE;\">
            <div style=\"float:left;\">".$image."</div>
            <div>
                <div>".$line1."</div>
                <div>".$line2."</div>
            </div>
        </div>";

    return $button;
}

?>
