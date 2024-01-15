/**
 *
 * Core JS for developer
 *
 */



const Centralized = (function() {
    const getDetail = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/tenders/detail/'+tender_id,
        success: function (response) {
          
          $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.status+'</td><td>'+response.year+'</td><td class="text-end national-quota">'+App.formatNumber(response.bbn_quota)+'</td></tr>');
          $("#data-detail").append('<tfoot class="footer"><tr><td colspan="3" class="text-end">Total</td><td class="text-end">'+App.formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
           
          if(response.status != "New"){
            $(".tool-bar").remove();
          }
        }
      });
        
    };

    const getOfferedVolumeAndPrice = function(){
      let total_volume = 0;
      let total_price = 0;
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/tenders/getCentralizedBid/'+tender_id,
        success: function (response) {
          if(response.length > 0){
            let i = 1;
            
            $.each(response, function(index, item) {
              $("#participant tbody").append('<tr class="border-bottom"><td>'+i+'</td><td>'+item.company_name+'</td><td class="text-end">'+App.formatNumber(item.offered_volume)+'</td><td class="text-end">'+App.formatNumber(item.offered_price)+'</td></tr>');
              total_volume += item.offered_volume;
              total_price += item.offered_price;
              i++;
            })

            let national_quota = $(".national-quota").html().split(",").join("");

            $("#participant tfoot").append(`
                                  <tr>
                                          <td colspan="2">Total Volume</td>
                                          <td class="text-end">`+App.formatNumber(total_volume)+`</td>
                                          <td class="text-end">`+App.formatNumber(total_price)+`</td>
                                      </tr>
                                      <tr>
                                          <td colspan="2">Remaining Volume</td>
                                          <td class="text-end">`+App.formatNumber(national_quota - total_volume)+`</td>
                                          <td class="text-end">&nbsp;</td>
                                      </tr>`);
          }else{
            $("#participant tbody").append('<tr><td colspan="4" class="text-center">There is no data to be displayed.</td></tr>');
          }
        }
      });
    };


    const save = function(event){
      event.preventDefault();
      $(".invalid-feedback").remove();
     
      var data = $('#form-data').serialize();
      $.ajax({
          type: 'post',
          url: base_url+"/tenders/store",
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
        $( "#date_start" ).datepicker({
          dateFormat: 'dd-mm-yy'
        });
        $( "#date_end" ).datepicker({
            dateFormat: 'dd-mm-yy'
        });

        $( "#closing_date" ).datepicker({
          dateFormat: 'dd-mm-yy'
      });
       
        $("#tender_number").val('CT/'+newDate+'/'+App.makeid(5));
        
    };

    return {
        init: init,
        save:save,
        getDetail:getDetail,
        getOfferedVolumeAndPrice:getOfferedVolumeAndPrice
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    Centralized.init();
    Centralized.getDetail();
    Centralized.getOfferedVolumeAndPrice();
    App.getTenderlogs();



    

    

    


     
})(jQuery); /*=====  End of Execute  ======*/