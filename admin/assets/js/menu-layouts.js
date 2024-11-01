jQuery(document).ready(function($) {

  'use strict';
  
  let idToDelete = null;

  $('#layout-id').select2();
  $('#player-show-1').select2();
  $('#player-show-2').select2();
  $('#player-show-3').select2();
  $('#player-show-4').select2();
  $('#player-show-5').select2();
  $('#player-show-6').select2();
  $('#player-show-7').select2();
  $('#player-show-8').select2();
  $('#player-show-9').select2();
  $('#player-show-10').select2();
  $('#player-show-11').select2();

  removeBorderLastTableTr();

  $(document.body).on('click', '.group-trigger' , function(){

    'use strict';

    //open and close the various sections of the tables area
    const target = $(this).attr('data-trigger-target');
    $('.' + target).toggle();

    $(this).find('.expand-icon').toggleClass('arrow-down');

    removeBorderLastTableTr();

    /**
     * Prevent a bug that causes the "All" text (used in the chosen multiple when there are no items selected) to be
     * hidden.
     */
    $('.chosen-container-multi .chosen-choices .search-field input').each(function() {

      'use strict';

      $(this).css('width', 'auto');

    });

  });

  $(document.body).on('click', '#cancel' , function(event){

    'use strict';

    //reload the menu
    event.preventDefault();
    window.location.replace(window.DAEXTVFFVE_PARAMETERS.admin_url + 'admin.php?page=daextvffve-layouts');

  });

  /*
 Remove the bottom border on the last visible tr included in the form
 */
  function removeBorderLastTableTr() {

    'use strict';

    $('table.daext-form-table tr > *').css('border-bottom-width', '1px');
    $('table.daext-form-table tr:visible:last > *').css('border-bottom-width', '0');

  }

  //Dialog Confirm ---------------------------------------------------------------------------------------------------
  $(document.body).on('click', '.menu-icon.delete' , function(event){

    'use strict';

    event.preventDefault();
    idToDelete = $(this).prev().val();
    $('#dialog-confirm').dialog('open');

  });

  /**
   * Dialog confirm initialization.
   */
  $(function() {

    'use strict';

    $('#dialog-confirm').dialog({
      autoOpen: false,
      resizable: false,
      height: 'auto',
      width: 340,
      modal: true,
      buttons: {
        [objectL10n.deleteText]: function() {

          'use strict';

          $('#form-delete-' + idToDelete).submit();

        },
        [objectL10n.cancelText]: function() {

          'use strict';

          $(this).dialog('close');

        },
      },
    });

  });

});