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

    const getDetailCopmany = function(){
      let company_id = $(".company-profile").attr("data-company-id");
  
      $.ajax({
        type: 'GET',
        dataType:"json",
        url: base_url+'/getCompanyDetail/'+company_id,
        success: function (response) {
          let total_alocated = response.data.total_alocated.total_offered_volume;
          let capacity_left = (parseInt(response.data.production_capacity) - parseInt(total_alocated));
          let remaining_quota = Math.round(parseInt(capacity_left) / parseInt(response.data.production_capacity) * 100);
          
          
          let companyProfile = `
          <div class="ui-title">Profile Highlight</div>
          <div class="dashboard-dialog mt-2">
              
              <div class="row">
                  <div class="col-4">              
                      <div class="mb-3">
                          <label for="company_name" class="form-label">Company Name</label>
                          <input type="text" class="form-control" id="company_name" readonly>
                      </div>             
                  </div>
                  <div class="col-8">             
                    <div class="mb-3">
                        <label for="supply_point" class="form-label">Supply Point</label>
                        <input type="text" class="form-control" id="supply_point" readonly>
                    </div>                 
                  </div>
                  <div class="col-4"> 
                    <div class="mb-3">
                      <label for="production_capacity" class="form-label">Production Capacity</label>
                      <input type="text" class="form-control" id="production_capacity" readonly>
                    </div>
                  </div>
                  <div class="col-4"> 
                    <div class="mb-3">
                      <label for="total_allocated" class="form-label">Total allocated</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="total_allocated" value="`+App.formatNumber(total_alocated)+`"  aria-describedby="button-addon2">
                        <button class="btn btn-outline-success show-detail" type="button" id="button-addon2">Detail</button>
                    
                      </div>
                    </div>
                  </div>
                  <div class="col-4"> 
                    <div class="mb-3">
                        <label for="remaining_capacity" class="form-label">Remaining Capacity</label>
                        <input type="text" class="form-control" id="remaining_capacity" readonly>
                    </div> 
                  </div>
              </div>
              <div class="progress" style="height: 40px;">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: `+remaining_quota+`%;" aria-valuenow="`+remaining_quota+`" aria-valuemin="0" aria-valuemax="100">`+remaining_quota+`% Remaining Capacity</div>
              </div> 
          </div>`;
          
          $(".company-profile").html(companyProfile);
          if($("#total_allocated").val() == 0){
            $(".show-detail").hide();
          }
          $("#company_name").val(response.data.company_name);
          $("#supply_point").val(response.data.bbu_bbn_location);
          $("#production_capacity").val(App.formatNumber(response.data.production_capacity));
          $("#remaining_capacity").val(App.formatNumber(response.data.production_capacity - total_alocated));
        }
      });
    };

    

    

    /*======================================================
    =            Init Function for All Function            =
    ======================================================*/

    const init = function() {
       
        
    };

    return {
        init: init,
        formatNumber:formatNumber,
        getDetailCopmany:getDetailCopmany
    } /*=====  End of Init Function for All Function  ======*/


})();



(function($) {

    // USE STRICT
    "use strict";

    App.init();
   
    

    $(document).on("keyup",'.number-format',function(){
      $(this).val(App.formatNumber($(this).val()));
    });

    

    


     
})(jQuery); /*=====  End of Execute  ======*/