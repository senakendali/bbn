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
        let i = 1;
          $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.year+'</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr>');
          $("#data-detail").append('<tfoot class="footer"><tr><td colspan="2" class="text-end">Total</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
          i++;
       
      }
    });
  };

  const createCluster = () => {
      let clusterContainer = `
          <div class="form-group mt-2">
            <table id="create-custer" class="app-table main-border-bottom">
                <thead class="header">
                    
                    <tr>
                        <td>Cluster Name</td>
                        <td>Quota</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" id="cluster_name" name="cluster_name" placeholder=""></td>
                        <td><input type="text" class="form-control number-format" id="cluster_quota" name="cluster_quota" placeholder="0.00"></td>    
                    </tr>
                    
                </tbody>
                

            </table>

            <table class="choose-delivery-point app-table main-border-bottom">
                <thead class="header">   
                    <tr>
                        
                        <td>Delivery Point</td>
                        <td>Quota</td>
                        <td width="20%">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                        <td>
                        <select name="select_box" class="form-select select_box" id="select_box">
                        <option value="">Select Country</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Sukabumi">Sukabumi</option>
                        <option value="Bekasi">Bekasi</option>
                       </select>
                    </td>
                        <td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td>
                    </tr>
                    
                    
                </tbody>
                <tfoot class="footer">
                    <tr>
                        <td colspan="3" class="add-row">
                          <button type="button" class="btn btn-primary add-delivery-point">
                              Add Delivery Point
                          </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td></td>
                    </tr>
                </tfoot>

            </table>
            
      </div>`;

      $(".cluster-container").append(clusterContainer);

     // var select_box_element = document.querySelector('.select_box');

      dselect(document.querySelector('.select_box'), {
          search: true
      });

  };

  const setDeliveryPoint = () => {
    let count = 1;

    

    let dynamicRowHTML = `
                          <tr class="rowClass""> 
                              
                              <td>
                              <input type="hidden" name="delivery_point_id[]" value=""/><input type="text" class="form-control del-p" id="cluster_name" name="cluster_name" placeholder=""></td>
                              <td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td> 
                              <td class="text-center"> 
                                  <button class="btn btn-outline-danger remove"
                                      type="button">Remove
                                  </button> 
                              </td> 
                          </tr>`;
            //$('.choose-delivery-point tbody').append(dynamicRowHTML);

            $(this).closest('table tbody').append(dynamicRowHTML); 

            

            
            
            count++;

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
                  $(".total-in").html(App.formatNumber(sum));
                  $(".difference").html(App.formatNumber(bbn_quota-sum));
                });
              }
            });
            break;

          case "view":
              getDetail();
              $.ajax({
                type: 'GET',
                dataType:"json",
                url: base_url+'/tenders/getDeliveryPoint/'+tender_id,
                success: function (response) {
                  let i = 1;
                  let total_quota = 0;
                  $.each(response, function(index, item) {
                    $("#delivery-point tbody").append('<tr><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="'+App.formatNumber(item.bbn_quota)+'" placeholder="0.00"></td></tr>');
                    total_quota += item.bbn_quota;
                    i++;
                  })
                  $("#delivery-point tfoot").append('<tr><td colspan="2">Total</td><td>'+App.formatNumber(total_quota)+'</td></tr>');
                }
              });
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
        setDeliveryPoint,
        createCluster
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    Clustered.init();
    

    $(document).on('click', '.add-delivery-point', function () {

      let dynamicRowHTML = `
                            <tr class="rowClass""> 
                                
                                <td>
                                  <select name="select_box" class="form-select select_box" id="select_box">
                                    <option value="">Select Country</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Sukabumi">Sukabumi</option>
                                    <option value="Bekasi">Bekasi</option>
                                  </select>
                                </td>
                                <td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td> 
                                <td class="text-center"> 
                                    <button class="btn btn-outline-danger remove"
                                        type="button">Remove
                                    </button> 
                                </td> 
                            </tr>`;
                            

              $(this)
              .closest( "table" )
              .append(dynamicRowHTML);

             
              dselect(document.querySelector('.select_box'), {
                search: true
              });

              
              

              
    
    });

    $(document).on('click', '.remove', function () {
      $(this).closest('tr').remove(); 
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