/**
 *
 * Core JS for developer
 *
 */



const Scattered = (function() {

  const getDetail = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/detail/'+tender_id,
      success: function (response) {
        
        $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.status+'</td><td>'+response.year+'</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr>');
        $("#data-detail").append('<tfoot class="footer"><tr><td colspan="3" class="text-end">Total</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
        
        if(response.status != "New"){
          $(".tool-bar").remove();
        }
       
      }
    });
  };

  const showDeliveryPointByTender = function(){
    
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/showDeliveryPointByTender/'+tender_id,
      success: function (response) {
        let i = 1;
        let total_quota = 0;
        $.each(response, function(index, item) {
          
          $("#delivery-point tbody").append('<tr class="border-bottom"><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td class="text-end">'+App.formatNumber(item.bbn_quota)+'</td></tr>');
          
          
          total_quota += item.bbn_quota;
          i++;
        })

       
        $("#delivery-point tfoot").append('<tr><td colspan="2">Total</td><td class="text-end">'+App.formatNumber(total_quota)+'</td></tr>');
        
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

        $("#tender_number").val('SC/'+newDate+'/'+App.makeid(5));


        switch(pathArray[2]){
          case "create":
            $.ajax({
              type: 'GET',
              dataType:"json",
              url: base_url+'/delivery-point/show',
              success: function (response) {
                
                let i = 1;
                $.each(response, function(index, item) {
                  $("#delivery-point tbody").append('<tr><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td></tr>');
                  i++;
                })
              },
              complete: function(response){
                $(".number-format").keyup(function(e){
                  $(this).val(App.formatNumber($(this).val()));
                });

                $( ".d-quota" ).on( "keydown keyup", function() {
                  var sum = 0;
                  var bbn_quota = $("#bbn_quota").val().split(",").join("");
                  //iterate through each textboxes and add the values
                  $(".d-quota").each(function() {
                      var quota = this.value.split(",").join("");
                      //add only if the value is number
                      if (!isNaN(quota) && quota.length != 0) {
                          sum += parseFloat(quota);
                          $(this).css("background-color", "#FEFFB0");
                      }
                      else if (quota.length != 0){
                          $(this).css("background-color", "red");
                      }
                  });
                  $(".delivery-point-total").html(App.formatNumber(sum));
                  $(".total-in").html(App.formatNumber(sum));
                  $(".difference").html(App.formatNumber(bbn_quota-sum));
                 
                });

                $( ".d-quota" ).on( "change", function() {
                  var bbn_quota = $("#bbn_quota").val().split(",").join("");
                  var quota = this.value.split(",").join("");
                  let sum =  $(".total-in").html().split(",").join("");
                  
                  if(parseInt(sum) > parseInt(bbn_quota)){
                    
                    $(this).css("background-color", "red");
                    $("#warning-message").html('Nilai yang di input tidak boleh lebih dari Quota Nasional');
                    var myModal = new bootstrap.Modal(document.getElementById('warning-modal'), {})
                    myModal.show()
                    sum -= (sum - this.value.split(",").join(""));
                    
                  }

                  /*if(sum > bbn_quota){
                    var myModal = new bootstrap.Modal(document.getElementById('warning-modal'), {})
                    myModal.show() 
                  }*/

                  

                });
              }
            });
            break;

          case "view":
              getDetail();
              showDeliveryPointByTender();
              
              break;
    
        }


        $(window).on("scroll", function() {
          var limiter = document.getElementById("choose-delivery-point");
          var scrollPos = $(window).scrollTop() - 100 ;
          if (scrollPos < 100) {
              $(".auto-sum").fadeOut();
              $(".dashboard-dialog").css("margin-bottom",  0);
          } else {
              $(".auto-sum").fadeIn();
              $(".dashboard-dialog").css("margin-bottom",  $(".auto-sum").height());
          }
        });

        
        
        
    };

    return {
        init: init,
        save:save,
        getDetail:getDetail,
        showDeliveryPointByTender:showDeliveryPointByTender
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    Scattered.init();
    App.getTenderlogs();
    

    $(document).on("keyup",'.number-format',function(){
        $(this).val(App.formatNumber($(this).val()));
        
    });

    

    $(document).on("click",'.delete',function(){
      $(this).closest('tr').remove(); 
    });

    $(document).on("click",'.view',function(){
      $("#cluster-delivery-point").show(); 
    });

    $(document).on("keyup",'#bbn_quota',function(){
      $(".quota").html(App.formatNumber($(this).val()));
    });

    $(document).on("keyup",'#cluster_name',function(){
      $(".cluster-name").html($(this).val());
    });

    $(document).on("keyup",'#cluster_quota',function(){
      $(".total-cluster-sum").html($(this).val());
    });


    


     
})(jQuery); /*=====  End of Execute  ======*/