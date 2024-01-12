/**
 *
 * Core JS for developer
 *
 */

const $ = jQuery.noConflict();
const base_url = window.location.origin;

const App = (function() {

    const getListData = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/cluster/show',
        success: function (response) {
          let i = 1;
          $.each(response, function(index, item) {
            $(".table tbody").append('<tr><td>'+i+'</td><td>'+item.name+'</td><td>-</td></tr>');
            i++;
          })
        }
      });
      
    };

    const save = function(event){
      event.preventDefault();
      $(".invalid-feedback").remove();
     
      var data = $('#form-data').serialize();
      $.ajax({
          type: 'post',
          url: base_url+"/cluster/store",
          data: data,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          beforeSend: function(){
              $('#save').html('Please wait...');
          },
          success: function(response){
            $( '<div id="response" class="alert alert-success" role="alert">success, the data has been saved</div>').insertBefore( ".dashboard-dialog" );
          },
          error: function(response){
            if(response.status === 422 ) {
              var errors = response.responseJSON.errors;
              $( '<div id="response" class="alert alert-danger" role="alert">Insert Failed</div>').insertBefore( ".dashboard-dialog" );
              $.each(errors, function (key, value) {
                  $("#"+key).addClass('is-invalid');
                  $('<div class="invalid-feedback">'+value+'</div>').insertAfter("#"+key);
              });
            }
          },
          complete: function(response){
              $('#save').html('Save');
          }
      });
      return false;
    };
    



    

    /*======================================================
    =            Init Function for All Function            =
    ======================================================*/

    const init = function() {
        
      dselect(document.querySelector('.select_box'), {
        search: true
      });
		
    };

    // make public function
    return {
        init: init,
        getListData:getListData,
        save:save
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    

    App.init();
    App.getListData();



})(jQuery); /*=====  End of Execute  ======*/