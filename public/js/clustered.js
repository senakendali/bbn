/**
 *
 * Core JS for developer
 *
 */



const Clustered = (function() {
  const getDetail = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/detail/'+tender_id,
      success: function (response) {
        
        $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.status+'</td><td>'+response.year+'</td><td class="national_quota">'+App.formatNumber(response.bbn_quota)+'</td></tr>');
        $("#data-detail").append('<tfoot class="footer"><tr><td colspan="3" class="text-end">Total</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
        $(".quota").html(App.formatNumber(response.bbn_quota));
        $( "#cluster_quota" ).on( "change", function() {
          
      
          var bbn_quota = $(".national_quota").html().split(",").join("");
          var quota = this.value.split(",").join("");
         
          
          if(parseInt(quota) > parseInt(bbn_quota)){
            
            $(this).css("background-color", "red");
            $( '<div id="response" class="alert alert-danger" role="alert">Nilai yang di input tidak boleh lebih dari Quota Nasional</div>').insertBefore( "#form-data" );
            sum -= (sum - this.value.split(",").join(""));
            
          }else{
            $(this).css("background-color", "#FEFFB0");
            $("#response").remove();
          }
    
          
          
    
        });

        if(response.is_having_cluster == 'no' && response.is_having_delivery_point == 'no'){
          $(".add-cluster").addClass('btn-primary');
          $(".add-delivery-point").addClass('btn-secondary disabled');
          $(".publish").addClass('btn-secondary disabled');
        }else if(response.is_having_cluster == 'yes' && response.is_having_delivery_point == 'no'){
          $(".add-cluster").removeClass('btn-primary').addClass('btn-secondary disabled');
          $(".add-delivery-point").removeClass('btn-secondary disabled').addClass('btn-primary');
          $(".publish").addClass('btn-secondary disabled');
        }else{
          $(".add-cluster").removeClass('btn-primary').addClass('btn-secondary disabled');
          $(".add-delivery-point").removeClass('btn-primary').addClass('btn-secondary disabled');
          $(".publish").removeClass('btn-secondary disabled').addClass('btn-primary');
        }


        if(response.status != "New"){
          $(".tool-bar").remove();
        }
        
      }
    });

    showClusterList();
    showDeliveryPointByTender();
    
      
  };

  const chooseDeliveryPointForCluster = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/chooseDeliveryPointForCluster/' + tender_id,
      success: function (response) {
        $.each(response, function(index, item) {
          $("#select-delivery-point").append('<option value="'+item.id+'">'+item.delivery_point+'</option>');
          
        })
      }
    });
    
  };

  const showClusterList = function(){
    $("#clusters-table tbody").empty();
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/getCluster/'+tender_id,
      success: function (response) {
        if(response.length > 0){
          
          let i = 1;
          let total = 0;
          let cluster_name = '';
          $.each(response, function(index, item) {

              let name = (cluster_name != item.name ? item.name : '');
              let cluster_quota = (cluster_name != item.name ? item.quota : '');
              $("#clusters-table tbody").append('<tr class="border-bottom"><td>'+name+'</td><td class="text-end">'+App.formatNumber(cluster_quota)+'</td><td>'+item.delivery_point+'</td><td>'+App.formatNumber(item.bbn_quota)+'</td><!--td><button id="'+item.id+'" type="button" class="btn btn-outline-success view">Show Delivery Point</button></td--!></tr>');
             
              cluster_name = item.name;
              total += item.bbn_quota;
  
              i++;
          })

          $("#clusters-table tfoot").append(`
          <tr>
                  <td colspan="3">Total</td>
                  <td class="total-all-cluster">`+App.formatNumber(total)+`</td>
              </tr>`);

          var total_cluster = $(".total-all-cluster").html().split(",").join("");
          $(".total-in").html(App.formatNumber(total_cluster));

          var bbn_quota = $(".quota").html().split(",").join("");
          var total_in = $(".total-in").html().split(",").join("");
        
      
          $(".difference").html(App.formatNumber(bbn_quota-total_in));
         
        
        }else{
          $("#clusters-table tbody").append('<tr><td colspan="4" class="text-center">There is no data to be displayed.</td></tr>');
        }
       
      }
    });
  }

  const showDeliveryPointByTender = function(){
    
    let total = 0;
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/showDeliveryPointByTender/' + tender_id,
      success: function (response) {
        
        if(response.length > 0){
          let i = 1;
          $.each(response, function(index, item) {
            $("#delivery-point-list tbody").append('<tr class="border-bottom"><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td>'+App.formatNumber(item.bbn_quota)+'</td></tr>');
            i++;
            total += item.bbn_quota;
          })

          $("#delivery-point-list tfoot").append(`
                                  <tr>
                                          <td colspan="2">Total</td>
                                          <td class="total-all-delivery-point">`+App.formatNumber(total)+`</td>
                                      </tr>`);

          var total_cluster = $(".total-all-cluster").html().split(",").join("");
          var total_delivery_point = $(".total-all-delivery-point").html().split(",").join("");

          $(".total-in").html(App.formatNumber(parseInt(total_cluster) + parseInt(total_delivery_point)));

          var bbn_quota = $(".quota").html().split(",").join("");
          var total_in = $(".total-in").html().split(",").join("");
          $(".difference").html(App.formatNumber(bbn_quota-total_in));

        }else{
          $("#delivery-point-list tbody").append('<tr><td colspan="3" class="text-center">There is no data to be displayed.</td></tr>');
        }
      }
    });
  }

  const showDeliveryPointByCluster = function(cluster_id){
    $("#clustered-delivery-point tbody tr").remove();
    let total = 0;
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/showDeliveryPointByCluster/' + cluster_id,
      success: function (response) {
        
        let i = 1;
        $.each(response, function(index, item) {
          $("#clustered-delivery-point tbody").append('<tr><td>'+i+'</td><td><input type="hidden" name="clustered_delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td>'+App.formatNumber(item.bbn_quota)+'</td></tr>');
          i++;
          total += item.bbn_quota;
        })

        $("#clustered-delivery-point tfoot").append(`
                                <tr>
                                        <td colspan="2">Total</td>
                                        <td>`+App.formatNumber(total)+`</td>
                                    </tr>`);
      }
    });
  };

  const addDeliveryPointToTenders = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/chooseDeliveryPointForCluster/' + tender_id,
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

        var total_in = parseInt($(".total-in").html().split(",").join(""));

        $( ".d-quota" ).on( "keydown keyup", function() {
         
         

          var sum = total_in;
          var bbn_quota = $(".quota").html().split(",").join("");
          
         
          
          $(".d-quota").each(function() {
              var quota = this.value.split(",").join("");
              
              
              if (!isNaN(quota) && quota.length != 0) {
                  sum += parseFloat(quota);
                  $(this).css("background-color", "#FEFFB0");
              }
              else if (quota.length != 0){
                  $(this).css("background-color", "red");
              }
          });
          
          $(".total-in").html(App.formatNumber(sum));
          $(".difference").html(App.formatNumber(bbn_quota-sum));
        });

        $( ".d-quota" ).on( "change", function() {
          var bbn_quota = $(".quota").html().split(",").join("");
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

  const storeCluster = function(event){
    event.preventDefault();
    $(".invalid-feedback").remove();
   
    var data = $('#form-data').serialize();
    $.ajax({
        type: 'post',
        url: base_url+"/tenders/storeCluster",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
            $('#save').html('Please wait...');
        },
        success: function(response){
          $( '<div id="response" class="alert alert-success" role="alert">success, the data has been saved</div>').insertBefore( "#form-data" );
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
          showClusterList();
        }
    });
    return false;
  };


  const storeDeliveryPoint = function(event){
    event.preventDefault();
    $(".invalid-feedback").remove();
   
    var data = $('#form-data-delivery_point').serialize();
    $.ajax({
        type: 'post',
        url: base_url+"/tenders/storeDeliveryPoint",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
            $('#save').html('Please wait...');
        },
        success: function(response){
          $( '<div id="response" class="alert alert-success" role="alert">success, the data has been saved</div>').insertBefore( "#form-data-delivery_point" );
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
          showDeliveryPointByTender();
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

      Clustered.chooseDeliveryPointForCluster();
      Clustered.addDeliveryPointToTenders();

      $("#tender_number").val('CL/'+newDate+'/'+App.makeid(5))


      $( ".cluster_quota" ).on( "keydown keyup", function() {
        var sum = 0;
        var quota = this.value.split(",").join("");
        
        sum += parseFloat(quota);
        $(".total-in").html(App.formatNumber(sum));

        var bbn_quota = $(".quota").html().split(",").join("");
        var total_in = $(".total-in").html().split(",").join("");
        
      
        $(".difference").html(App.formatNumber(bbn_quota-total_in));
       
        
        
        
        
       
      });

     

      /*$(window).on("scroll", function() {
        var limiter = document.getElementById("choose-delivery-point");
        var scrollPos = $(window).scrollTop() - 100 ;
        if (scrollPos < 100) {
            $(".auto-sum").fadeOut();
            $(".dashboard-dialog").css("margin-bottom",  0);
        } else {
            $(".auto-sum").fadeIn();
            $(".dashboard-dialog").css("margin-bottom",  $(".auto-sum").height());
        }
      });*/
      
  };

  return {
      init: init,
      save:save,
      getDetail:getDetail,
      chooseDeliveryPointForCluster:chooseDeliveryPointForCluster,
      storeCluster,
      storeDeliveryPoint,
      showClusterList,
      addDeliveryPointToTenders,
      showDeliveryPointByCluster
  } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

  // USE STRICT
  "use strict";

  Clustered.init();
  Clustered.getDetail();
  App.getTenderlogs();

  
  $(document).on("change",'#select-delivery-point',function(){
    
    $("#choose-delivery-point tbody").append('<tr><td><input type="hidden" name="delivery_point_id[]" value="'+$(this).val()+'"/>'+$("#select-delivery-point :selected").text()+'</td><td><input type="text" class="form-control number-format c-quota" id="quota" name="quota[]" placeholder="0.00"></td><td><button type="button" class="btn btn-outline-danger delete">Remove</button></td></tr>');

    $( ".c-quota" ).on( "keydown keyup", function() {
      var sum = 0;
      var cluster_quota = $("#cluster_quota").val().split(",").join("");
      //iterate through each textboxes and add the values
      $(".c-quota").each(function() {
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
      $(".total-cluster").html(App.formatNumber(sum));

      
      //$(".difference").html(App.formatNumber(bbn_quota-sum));
    });

    $( ".c-quota" ).on( "change", function() {
      
      var cluster_quota = $("#cluster_quota").val().split(",").join("");
      var quota = this.value.split(",").join("");
      let sum =  $(".total-cluster").html().split(",").join("");
      
      if(parseInt(sum) > parseInt(cluster_quota)){
        
        $(this).css("background-color", "red");
        
       $("#response").show(); 
       sum -= (sum - this.value.split(",").join(""));
        return false;
        
      }else{
        $("#response").hide(); 
      }

      
      

    });
  });

  $(document).on("click",'.delete',function(){
    $(this).closest('tr').remove(); 
  });

  $(document).on("click",'.view',function(){
    Clustered.showDeliveryPointByCluster($(this).attr('id'));
    $("#clustered-delivery-point").show(); 
  });

  


  

  

  


   
})(jQuery); /*=====  End of Execute  ======*/