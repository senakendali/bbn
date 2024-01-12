/**
 *
 * Core JS for developer
 *
 */



const Registration = (function() {

    

    const getProvinces = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/getProvinces',
        success: function (response) {
          response.forEach((item) => {
            $("#province_id").append('<option value="'+item.id+'">'+item.name+'</option>');
            
          })
        }
      });
      
    };

    const getSupplyPoint = function(){
        $.ajax({
            type:'POST',
            url:'/getSupplyPoint',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(response) {
            $("#supply_point_id").html('<option value="">Please Choose Supply Point</option>');
            response.forEach((item) => {
                $("#supply_point_id").append('<option value="'+item.id+'">'+item.bbu_bbn_location+'</option>');
                
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
          url: base_url+"/vendors/submitRegistrationData",
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
              $( '<div id="response" class="alert alert-danger" role="alert">Registration Failed</div>').insertBefore( "#form-data" );
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

    var init = function() {
        
        getSupplyPoint();
		
    };

    // make public function
    return {
        init: init,
        getProvinces:getProvinces,
        getSupplyPoint:getSupplyPoint,
        save:save
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    

    Registration.init();
   
    Registration.getProvinces();

    $("#province_id").change(function(){
      $("#regencie_id").empty();
      //$("#supply_point_id").empty();
        $.ajax({
            type:'POST',
            url:'/getRegencies',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
            "province_id": $(this).val()
            },
            success:function(response) {
                $("#regencie_id").html('<option value="">Please Choose Regency</option>');
                response.forEach((item) => {
                $("#regencie_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                
                })
                
            }
        });

        
    });

    $(".number-format").keyup(function(e){
        $(this).val(BbnProducer.formatNumber($(this).val()));
    });


})(jQuery); /*=====  End of Execute  ======*/