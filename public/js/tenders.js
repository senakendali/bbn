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


const dateObj = new Date();
const month   = dateObj.getUTCMonth() + 1; // months from 1-12
const day     = dateObj.getUTCDate();
const year    = dateObj.getUTCFullYear();
const newDate = year + "/" + month + "/" + day;

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

  const getTenderlogs = function(){

    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/getTenderLogs/'+tender_id,
      success: function (response) {
        let i = 1;
        
        $.each(response, function(index, item) {
          $("#logs-detail tbody").append('<tr class="border-bottom"><td>'+i+'</td><td>'+item.tender_log+'</td><td>'+item.user_created+'</td><td>'+item.created_at+'</td></tr>');
          
          i++;
        })

        
        
      }
    });

    
  };

  const makeid = (length) => {
      let result = '';
      const characters = '0123456789';
      const charactersLength = characters.length;
      let counter = 0;
      while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
      }
      return result;
  }

  

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
        
    };

    return {
        init: init,
        formatNumber:formatNumber,
        getListData:getListData,
        makeid:makeid,
        getTenderlogs:getTenderlogs
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    App.init();
    App.getListData();
    

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