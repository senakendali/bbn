/**
 *
 * Core JS for developer
 *
 */


const Apply = (function() {
    const getDetail = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/tenders/detail/'+tender_id,
        success: function (response) {
          
            $("#method").val(response.method);
            $.getScript('/js/admin/app.js', function(jd) {
                      
              App.getDetailCopmany();
              
            });
            $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.method+'</td><td>'+response.currency+'</td><td>'+response.year+'</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr>');
            //$("#data-detail").append('<tfoot class="footer"><tr><td colspan="4" class="text-end">Total</td><td>'+App.formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
            
            if(response.method === 'centralized'){
              let is_apply = response.is_join === 'yes' ? '<td class="text-start">'+App.formatNumber(response.detail.offered_volume)+'</td><td class="text-cestartnter">'+App.formatNumber(response.detail.offered_price)+'</td><td>Joined</td>' : '<td><input type="text" id="offered_volume" name="offered_volume" placeholder="" class="form-control number-format"></td><td><input type="text" id="offered_price" name="offered_price" class="form-control number-format" placeholder=""></td><td>&nbsp;</td>';
              let row_class = (response.is_join === 'yes' ? 'joined': '');
              let centralized_form = `
              <table id="delivery-point" class="app-table main-border-bottom mt-2">
                      <thead class="header">
                          <tr>
                              <td>Offered Volume</td>
                              <td>Offered Price</td>
                              <td>Status</td>
                              
                          </tr>
                      </thead>
                      <tbody> 
                         
                        <tr class="`+row_class+`">
                            `+is_apply+`
                            
                        </tr>   
                      </tbody>
                      <tfoot class="footer">
                          
                      </tfoot>

                  </table>

              `;
              $(centralized_form).insertAfter("#data-detail");
              if(response.is_join === 'yes'){
                $(".auto-sum").hide();
              }

            }else if(response.method === 'scattered'){
              $("#delivery-point").remove();
              let delivery_point_list = `
                  <table id="delivery-point" class="app-table main-border-bottom mt-2">
                      <thead class="header">
                          <tr>
                              <td colspan="6">Delivery Point</td>
                          </tr>
                          <tr>
                              <td>No</td>
                              <td>Delivery Point</td>
                              <td>Quota</td>
                              <td>Offered Volume</td>
                              <td>Offered Offered Price</td>
                              <td>Status</td>
                          </tr>
                      </thead>
                      <tbody>    
                      </tbody>
                      <tfoot class="footer">
                          
                      </tfoot>

                  </table>`;

                  $(delivery_point_list).insertAfter("#data-detail");

                  getAppliedDeliveryPointByTender();


            }else if(response.method === 'clustered'){
              

              let cluster_list = `
                  <table id="clusters-table" class="app-table main-border-bottom mt-2">
                      <thead class="header">
                          <tr>
                              <td colspan="6">Clusters</td>
                          </tr>
                          <tr>
                              
                              <td width="25%">Cluster Name</td>
                              <td>Cluster Quota</td>
                              <td>Offered Volume</td>
                              <td>Offered Offered Price</td>
                              <td width="25%">Delivery Point</td>
                              <td>Quota</td>
                              
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot class="footer">
                      </tfoot>
                  </table>`;

              let delivery_point_list = `
                    <table id="delivery-point-list" class="app-table main-border-bottom mt-2">
                      <thead class="header">
                          <tr>
                              <td colspan="5">Delivery Point</td>
                          </tr>
                          <tr>
                              <td>No</td>
                              <td>Delivery Point</td>
                              <td>Quota</td>
                              <td>Offered Volume</td>
                              <td>Offered Offered Price</td>
                          </tr>
                      </thead>
                      <tbody>    
                      </tbody>
                      <tfoot class="footer">
                      </tfoot>
                  </table>`;

                 
                $(cluster_list).insertAfter("#data-detail"); 
                $(delivery_point_list).insertAfter("#clusters-table");

                getCluster();
                getUnclusteredDeliveryPoint();
            }
            
            
        }
      });
        
    };

    const getCluster = function(){
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
                let appply_cluster = (cluster_name != item.name ? '<td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td>' : '<td colspan="2">&nbsp;</td>');
                $("#clusters-table tbody").append('<tr class="border-bottom"><td>'+name+'</td><td class="text-end">'+App.formatNumber(cluster_quota)+'</td>'+appply_cluster+'<td>'+item.delivery_point+'</td><td class="text-end">'+App.formatNumber(item.bbn_quota)+'</td><!--td><button id="'+item.id+'" type="button" class="btn btn-outline-success view">Show Delivery Point</button></td--!></tr>');
               
                cluster_name = item.name;
                total += item.bbn_quota;
  
                i++;
            })
  
            $("#clusters-table tfoot").append(`
            <tr>
                    <td colspan="5">Total</td>
                    <td class="text-end">`+App.formatNumber(total)+`</td>
                </tr>`);
          }else{
            $("#clusters-table tbody").append('<tr><td colspan="4" class="text-center">There is no data to be displayed.</td></tr>');
          }
         
        }
      });
    }

    const getAppliedDeliveryPointByTender = function(){
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/tenders/getAppliedDeliveryPointByTender/'+tender_id,
        success: function (response) {
          let i = 1;
          let total_quota = 0;
          $.each(response, function(index, item) {
            let quotation = (item.is_join === 'yes' ? '<td class="text-center"><input type="hidden" name="offered_quota[]" value=""><input type="hidden" name="offered_price[]">'+item.detail.offered_volume+'</td><td>'+item.detail.offered_price+'</td><td>Joined</td>' : '<td><input type="text" class="form-control number-format d-quota" id="offered_quota" name="offered_quota[]" value="" placeholder="0.00"></td><td><input type="text" class="form-control number-format d-quota" id="offered_price" name="offered_price[]" value="" placeholder="0.00"></td><td>-</td>');
            let row_class = (item.is_join === 'yes' ? 'joined': '');
            $("#delivery-point tbody").append('<tr class="border-bottom '+row_class+'"><td>'+i+'</td><td><input type="hidden" name="scattered_id[]" value="'+item.id+'"/><input type="hidden" name="delivery_point_id[]" value="'+item.delivery_point_id+'"/>'+item.delivery_point+'</td><td class="text-end">'+App.formatNumber(item.bbn_quota)+'</td>'+quotation+'</tr>');
          
            total_quota += item.bbn_quota;
            i++;
          })

          $("#delivery-point tfoot").append('<tr><td colspan="3">Total</td><td class="text-end">'+App.formatNumber(total_quota)+'</td><td>&nbsp;</td><td>&nbsp;</td></tr>');
         
        }
      });
    }

    const getUnclusteredDeliveryPoint = function(){
      let total = 0;
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/tenders/showDeliveryPointByTender/' + tender_id,
        success: function (response) {
          
          if(response.length > 0){
            let i = 1;
            $.each(response, function(index, item) {
              $("#delivery-point-list tbody").append('<tr class="border-bottom"><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td class="text-end">'+App.formatNumber(item.bbn_quota)+'</td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="" placeholder="0.00"></td></tr>');
              i++;
              total += item.bbn_quota;
            })

            $("#delivery-point-list tfoot").append(`
                                    <tr>
                                            <td colspan="2">Total</td>
                                            <td class="text-end">`+App.formatNumber(total)+`</td>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>`);
          }else{
            $("#delivery-point-list tbody").append('<tr><td colspan="5" class="text-center">There is no data to be displayed.</td></tr>');
          }
        }
      });
    }

    const submitQuotation = function(event){
      event.preventDefault();
      $(".invalid-feedback").remove();
      $('#response').remove();
     
      var data = $('#form-data').serialize();
      $.ajax({
          type: 'post',
          url: base_url+"/tenders/submitQuotation",
          data: data,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          beforeSend: function(){
              $('#save').html('Please wait...');
          },
          success: function(response){
            getDetail();
            $( '<div id="response" class="alert alert-success" role="alert">success, the data has been saved</div>').insertBefore( ".dashboard-dialog" );
          },
          error: function(response){
            if(response.status === 422 ) {
              var errors = response.responseJSON.errors;
              $( '<div id="response" class="alert alert-danger" role="alert">Sorry, We cannot process Your request. There Seems to Be an Issue with Your Form Submission.</div>').insertBefore( ".dashboard-dialog" );
              $.each(errors, function (key, value) {
                  $("#"+key).addClass('is-invalid');
                  $('<div class="invalid-feedback">'+value+'</div>').insertAfter("#"+key);
              });
            }
          },
          complete: function(response){
              $('#save').html('Submit Quotation');
          }
      });
      return false;
    };

    const applyCentralizedAuction = function(event){
      event.preventDefault();
      $(".invalid-feedback").remove();
      $('#response').remove();
     
      var data = $('#form-data').serialize();
      $.ajax({
          type: 'post',
          url: base_url+"/tenders/applyCentralizedAuction",
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
              $( '<div id="response" class="alert alert-danger" role="alert">Sorry, We cannot process Your request. There Seems to Be an Issue with Your Form Submission.</div>').insertBefore( ".dashboard-dialog" );
              $.each(errors, function (key, value) {
                  $("#"+key).addClass('is-invalid');
                  $('<div class="invalid-feedback">'+value+'</div>').insertAfter("#"+key);
              });
            }
          },
          complete: function(response){
              $('#save').html('Submit Quotation');
          }
      });
      return false;
    };

    /*======================================================
    =            Init Function for All Function            =
    ======================================================*/

    const init = function() {
        
      getDetail();
    };

    return {
        init: init,
        applyCentralizedAuction:applyCentralizedAuction,
        getDetail:getDetail,
        getCluster:getCluster,
        getUnclusteredDeliveryPoint:getUnclusteredDeliveryPoint,
        submitQuotation:submitQuotation,
        getAppliedDeliveryPointByTender:getAppliedDeliveryPointByTender
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    Apply.init();


    

    

    


     
})(jQuery); /*=====  End of Execute  ======*/