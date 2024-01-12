/**
 *
 * Core JS for developer
 *
 */



const Home = (function() {

  const GetTenderList = function(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: base_url+'/tenders/showTender',
      success: function (response) {
        if(response.status ==200){
          let i = 1;
          $.each(response.data, function(index, item) {
              
              $("#centralized tbody").append('<tr><td>'+item.tender_number+'</td><td>'+item.method+'</td><td>'+App.formatNumber(item.bbn_quota)+'</td><td><a href="'+base_url+'/tenders/apply/'+item.tender_id+'" class="btn button-green">Open</a></td></tr>');
            i++;
          })
        }else{
          $("#centralized tbody").append('<tr><td colspan="7" class="text-center">There is no data to be displayed.</td></tr>');
        }
      }
    });
  };

   

  

    

    

    /*======================================================
    =            Init Function for All Function            =
    ======================================================*/

    const init = function() {
      $.getScript('/js/admin/app.js', function(jd) {          
        App.getDetailCopmany();
      });
       
    };

    return {
        init: init,
        GetTenderList:GetTenderList
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    Home.init();
    Home.GetTenderList();
    

    $(document).on("keyup",'.number-format',function(){
      $(this).val(Home.formatNumber($(this).val()));
    });

    

    $(document).on("click",'.delete',function(){
      $(this).closest('tr').remove(); 
    });

    $(document).on("click",'.view',function(){
      $("#cluster-delivery-point").show(); 
    });

    $(document).on("keyup",'#bbn_quota',function(){
      $(".quota").html(Home.formatNumber($(this).val()));
    });

    $(document).on("keyup",'#cluster_name',function(){
      $(".cluster-name").html($(this).val());
    });

    $(document).on("keyup",'#cluster_quota',function(){
      $(".total-cluster-sum").html($(this).val());
    });


     
})(jQuery); /*=====  End of Execute  ======*/