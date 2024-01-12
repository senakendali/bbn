/**
 *
 * Core JS for developer
 *
 */

const $ = jQuery.noConflict();
const newURL =
window.location.protocol +
"://" +
window.location.host +
"/" +
window.location.pathname;
const pathArray = window.location.pathname.split("/");
const base_url = window.location.origin;
const method = $("#method").val();
const tender_id = pathArray[3];

const App = (function() {

  const getListData = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/show/',
      success: function (response) {
        if(response.length > 0){
          let i = 1;
          $.each(response, function(index, item) {
              $("#data-list tbody").append('<tr><td>'+i+'</td><td>'+item.tender_number+'</td><td>'+item.method+'</td><td>'+formatNumber(item.bbn_quota)+'</td><td>'+item.date_start+'</td><td>'+item.date_end+'</td><td><a href="'+base_url+'/tenders/view/'+item.tender_id+'" class="btn button-green">Open</a></td></tr>');
            i++;
          })
        }else{
          $("#data-list tbody").append('<tr><td colspan="7" class="text-center">There is no data to be displayed.</td></tr>');
        }
      }
    });
  };

  const getDetail = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/detail/'+tender_id,
      success: function (response) {
        let i = 1;
          $("#data-detail tbody").append('<tr><td>'+response.tender_number+'</td><td>'+response.year+'</td><td>'+formatNumber(response.bbn_quota)+'</td></tr>');
          $("#data-detail").append('<tfoot class="footer"><tr><td colspan="2" class="text-end">Total</td><td>'+formatNumber(response.bbn_quota)+'</td></tr></tfoot>');
          i++;
       
      }
    });

    switch(method){
      case "scattered":
        $.ajax({
          type: 'GET',
          dataType:"json",
          url: base_url+'/tenders/getDeliveryPoint/'+tender_id,
          success: function (response) {
            let i = 1;
            $.each(response, function(index, item) {
              $("#delivery-point tbody").append('<tr><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" value="'+formatNumber(item.bbn_quota)+'" placeholder="0.00"></td></tr>');
              i++;
            })
          }
        });
        break;

      case 'clustered':
        $.ajax({
          type: 'GET',
          dataType:"json",
          url: base_url+'/tenders/getCluster/'+tender_id,
          success: function (response) {
            if(response.length > 0){
              
              let i = 1;
              $.each(response, function(index, item) {
                  $("#clusters-table tbody").append('<tr><td>'+i+'</td><td>'+item.name+'</td><td>'+formatNumber(item.quota)+'</td><td><button type="button" class="btn btn-outline-success view">Show Delivery Point</button></td></tr>');
                i++;
              })
            }else{
              $("#clusters-table tbody").append('<tr><td colspan="4" class="text-center">There is no data to be displayed.</td></tr>');
            }
           
          }
        });
      break;


    }
    
    
  };

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

        
        switch(method){
          case "centralized":
            $(".scatered-auction").hide();
            $(".clustered-auction").hide();
            $(".cluster-bbn-total").hide();
            break;
          case "scattered":
           
            
            
              $(".clustered-auction").hide();
              $(".cluster-bbn-total").hide();
              $(".scatered-auction").show();

              getProvinces();
            if(pathArray[2] != 'view'){
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
            break;
          case 'clustered':
            $(".scatered-auction").hide();
            $(".clustered-auction").show();
            $(".cluster-bbn-total").show();


            $("#province_id").on("change", function(){
              $.ajax({
                type: 'GET',
                dataType:"json",
                url: base_url+'/delivery-point/show/' + $(this).val(),
                success: function (response) {
                  let i = 1;
                  $.each(response, function(index, item) {
                    
                    $("#choose-delivery-point tbody").append('<tr><td>'+i+'</td><td><input type="hidden" name="delivery_point_id[]" value="'+item.id+'"/>'+item.delivery_point+'</td><td><input type="text" class="form-control number-format d-quota" id="quota" name="quota[]" placeholder="0.00"></td><td><button type="button" class="btn btn-outline-danger delete">Remove</button></td></tr>');
                    i++;
                  })
                },
                complete: function(response){
                  $(".number-format").keyup(function(e){
                    $(this).val(App.formatNumber($(this).val()));
                  });
  
                  $( ".d-quota" ).on( "keydown keyup", function() {
                    var sum = 0;
                    var bbn_quota = $("#cluster_quota").val().split(",").join("");
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
            });

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
            //alert(method);

        }
        
    };

    return {
        init: init,
        formatNumber:formatNumber,
        save:save,
        getListData:getListData,
        getDetail:getDetail,
        getProvinces:getProvinces
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    App.init();
    App.getListData();
    App.getDetail();
    App.getProvinces();

    $(".number-format").keyup(function(e){
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