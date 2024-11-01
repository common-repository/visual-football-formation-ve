jQuery(document).ready(function($) {

    'use strict';

    //set the CSS position based on the value of the hidden input fields (30 is half player)
    //remove 30 ( half player ) to set the position from the top left corner of the player
    $("#daextvffve-field-player-1").css("left", ( $("#player-x-1").val() - 30 ) + "px" );
    $("#daextvffve-field-player-1").css("top", ( $("#player-y-1").val() - 30 ) + "px" );
    $("#daextvffve-field-player-2").css("left", ( $("#player-x-2").val() - 30 ) + "px" );
    $("#daextvffve-field-player-2").css("top", ( $("#player-y-2").val() - 30 ) + "px" );
    $("#daextvffve-field-player-3").css("left", ( $("#player-x-3").val() - 30 ) + "px" );
    $("#daextvffve-field-player-3").css("top", ( $("#player-y-3").val() - 30 ) + "px" );
    $("#daextvffve-field-player-4").css("left", ( $("#player-x-4").val() - 30 ) + "px" );
    $("#daextvffve-field-player-4").css("top", ( $("#player-y-4").val() - 30 ) + "px" );
    $("#daextvffve-field-player-5").css("left", ( $("#player-x-5").val() - 30 ) + "px" );
    $("#daextvffve-field-player-5").css("top", ( $("#player-y-5").val() - 30 ) + "px" );
    $("#daextvffve-field-player-6").css("left", ( $("#player-x-6").val() - 30 ) + "px" );
    $("#daextvffve-field-player-6").css("top", ( $("#player-y-6").val() - 30 ) + "px" );
    $("#daextvffve-field-player-7").css("left", ( $("#player-x-7").val() - 30 ) + "px" );
    $("#daextvffve-field-player-7").css("top", ( $("#player-y-7").val() - 30 ) + "px" );
    $("#daextvffve-field-player-8").css("left", ( $("#player-x-8").val() - 30 ) + "px" );
    $("#daextvffve-field-player-8").css("top", ( $("#player-y-8").val() - 30 ) + "px" );
    $("#daextvffve-field-player-9").css("left", ( $("#player-x-9").val() - 30 ) + "px" );
    $("#daextvffve-field-player-9").css("top", ( $("#player-y-9").val() - 30 ) + "px" );
    $("#daextvffve-field-player-10").css("left", ( $("#player-x-10").val() - 30 ) + "px" );
    $("#daextvffve-field-player-10").css("top", ( $("#player-y-10").val() - 30 ) + "px" );
    $("#daextvffve-field-player-11").css("left", ( $("#player-x-11").val() - 30 ) + "px" );
    $("#daextvffve-field-player-11").css("top", ( $("#player-y-11").val() - 30 ) + "px" );

    //Display the field
    $('#daextvffve-container').show();

    //from the field to the input on the "dropped" event -----------------------
    $( ".daextvffve-field-player" ).draggable({

        //snap to grid
        grid: [ 1, 1 ],
        
        //contain inside parent
        containment: "#daextvffve-containment-wrapper", scroll: false,

        //position where is dropped
        stop: function() {

            'use strict';

            //get the drop position
            //add 30 to get the position of the center, 30 is half player
            const stop_pos_left = parseInt( $(this).position().left + 30, 10);
            const stop_pos_top = parseInt( $(this).position().top + 30 , 10);
            
            //assign value to the related input fields
            const id = $(this).attr("data-id");
            $("#player-x-"+id).val(stop_pos_left);
            $("#player-y-"+id).val(stop_pos_top);
            
            //assign value to the position at the right side of the screen
            $("#position-player-x-"+id).text(stop_pos_left);
            $("#position-player-y-"+id).text(stop_pos_top);
            
            //decrease z-index of the dropped player
            $(this).css("z-index","0");
            
            //set the default color for the dropped player
            $(this).css("background","#237d0a");

        },
        
        drag: function() {

            'use strict';
            
            //increase z-index of the dragged player
            $(this).css("z-index","999998");
            
            //change background color of the dragged player
            $(this).css("background","#237d0a");
            
        }
        
    });
    
    //hide players with the checkbox
    $(document.body).on('change', '.player-show' , function(){

        'use strict';

        if( parseInt($(this).val(), 10) === 0 ){
            $("#daextvffve-field-player-" + parseInt( $(this).attr("data-id") ) ).hide();
        }else{
            $("#daextvffve-field-player-" + parseInt( $(this).attr("data-id") ) ).show();
        }
        
    });

});