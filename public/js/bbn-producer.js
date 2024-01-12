/**
 *
 * Core JS for developer
 *
 */

var $ = jQuery.noConflict();
var base_url = window.location.origin;

var App = (function() {

    const formatNumber = function(num){
        var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
        if(str.indexOf(".") > 0) {
          parts = str.split(".");
          str = parts[0];
        }
        str = str.split("").reverse();
        for(var j = 0, len = str.length; j < len; j++) {
          if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
              output.push(",");
            }
            i++;
          }
        }
        formatted = output.reverse().join("");
        return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

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

    const getListData = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/bbn-producer/show',
        success: function (response) {
          let i = 1;
          $.each(response, function(index, item) {
            $(".table tbody").append('<tr><td>'+i+'</td><td>'+item.company_name+'</td><td>'+formatNumber(item.production_capacity)+'</td><td>-</td></tr>');
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
          url: base_url+"/bbn-producer/store",
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

    var init = function() {
        
       
		
    };

    // make public function
    return {
        init: init,
        formatNumber:formatNumber,
        getProvinces:getProvinces,
        getListData:getListData,
        save:save
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    

    App.init();
    App.getListData();
    App.getProvinces();

    $("#province_id").change(function(){
      $("#regencie_id").empty();
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