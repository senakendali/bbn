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


const App = (function() {

    const chart = function() {
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
            }
        });
    };

    const pieChart = function() {
        const ctx = document.getElementById('pieChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                  'rgb(255, 99, 132)',
                  'rgb(54, 162, 235)',
                  'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
              }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
            }
        });
    };

    const doughnutChart = function() {
        const ctx = document.getElementById('doughnutChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels: [
            'Red',
            'Blue',
            'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
            }
        });
    };

    const setDashboard = function(event){
        event.preventDefault();
        $(".invalid-feedback").remove();
       
        var data = $('#form-data').serialize();
        $.ajax({
            type: 'post',
            url: base_url+"/setDashboardType",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('#save').html('Please wait...');
            },
            success: function(response){  
                const obj = JSON.parse(response);
                window.location.href = obj.redirect;
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
                $('#save').html('Next');
            }
        });
        return false;
      };



    

    /*======================================================
    =            Init Function for All Function            =
    ======================================================*/

    const init = function() {
        switch(pathArray[2]){
            case undefined:
                //chart();
                //pieChart();
                //doughnutChart();
            case 'choose-type':


        }
        
        
		
    };

    // make public function
    return {
        init: init,
        setDashboard:setDashboard
    } /*=====  End of Init Function for All Function  ======*/


})();

(function($) {

    // USE STRICT
    "use strict";

    App.init();

})(jQuery); /*=====  End of Execute  ======*/