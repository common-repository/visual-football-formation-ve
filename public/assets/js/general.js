jQuery(document).ready(function($) {

    'use strict';

    //set player size on document ready event
    daextvffve_set_player_size();
    
    //set player size on window resize event
    $(window).resize(function() { daextvffve_set_player_size(); });

    //set player size and style
    function daextvffve_set_player_size(){

        'use strict';

        //parse all the fields
        $(".daextvffve-container").each(function(){

            'use strict';

            //get the id selector of this specific field, this will be used in all the selections
            const field_id = "#" + $(this).attr("id");
            
            //CALCULATE PARAMETERS -------------------------------------------------

            //get field width
            const field_width = $(field_id + " .daextvffve-field-image").width();

            //calculate player diameter
            const player_diameter = daextvffve_multiple_of_2(field_width * 0.1577490774907749);

            //calculate border
            const player_border = daextvffve_multiple_of_2(field_width * 0.0129151291512915);

            //calculate shadows
            const h_shadow = field_width * 0.0023062730627306;
            const v_shadow = field_width * 0.0039944649446494;
            const blur = field_width * 0.0046125461254613;

            //calculate player font size
            const font_size = field_width * 0.025830258302583;

            //APPLY PARAMETERS -----------------------------------------------------

            //set width, height and radius to player border
            $(field_id + " .daextvffve-player").
            css("width", player_diameter + "px").
            css("height", player_diameter + "px").
            css("border-radius", player_diameter/2 + "px");

            //set width, height, radius and border to player image
            $(field_id + " .daextvffve-player-image, " + field_id + " .daextvffve-player-image-overlay").
            css("width", (player_diameter - player_border) + "px").
            css("height", (player_diameter - player_border) + "px").
            css("border-radius", player_diameter + "px").
            css("margin", player_border/2 + "px");

            //set player box shadow
            $(field_id + " .daextvffve-player").
            css("box-shadow", h_shadow + "px " + v_shadow + "px " + blur + "px 0px rgba(0, 0, 0, 0.894)");

            //set image overlay inset box shadow
            $(field_id + " .daextvffve-player-image-overlay").
            css("box-shadow", "inset " + h_shadow + "px " + v_shadow + "px " + blur + "px 0px rgba(0, 0, 0, 0.294)");

            //set player name container width
            $(field_id + " .daextvffve-player-name").
            css("width", ( player_diameter * 2 ) + "px");

            //set player name font size
            $(field_id + " .daextvffve-player-name").
            css("font-size", font_size + "px");

            //set player name font shadow
            $(field_id + " .daextvffve-player-name").
            css("text-shadow", h_shadow + "px " + v_shadow + "px " + blur + "px rgba(0, 0, 0, 0.894)");

            //show the players image and name
            $(field_id + " .daextvffve-player, " + field_id + " .daextvffve-player-name").not(".daextvffve-hidden-player").css('display','block');
            
        });
        
    }
    
    //get the multiple of 2 of a number
    function daextvffve_multiple_of_2(number){

        'use strict';

        let value = parseInt(number, 10);
        
        //if the integer part is not a multiple of 2 increase the integer part by 1
        if((value % 2) != 0){value = value + 1;}       
        
        return value;
        
    }

});