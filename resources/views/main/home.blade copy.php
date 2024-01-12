@extends("layouts.main")
@section("container")
<div id="welcome" class="welcome">
    <div class="container-1280">
        <div class="row">
            <div class="col-lg-12">
                Hello and welcome to BBN E-Bidding Website! We're thrilled to have you here.
            </div>
        </div>
    </div>


    
</div>
<div class="container-1280">
    <div class="row mt-3">
        <div class="col-lg-7">
            <img src="{{ asset('images/main/welcome.png') }}" class="img-fluid" alt="">
        </div>
        <div class="col-lg-5">
            <div class="welcome-container">
                <div class="welcome-text">
                    <p>BBN E-Bidding is a web-based application system that provides various conveniences and information in relation to the BBN Procurement Process. This application system was built to increase the efficiency and effectiveness of Procurement.</p>
                    <p>Available information that can be accessed by vendors via E-Bidding includes the latest news regarding the BBN Procurement Process, Procurement Information, and applicable Procurement Policies. Through this E-Bidding Web, Vendors can also register online to take part in BBN procurement.</p>
                    <div><button class="btn button-green" onclick="App.save(event)" >Browse Tender</button></div>
                </div>
                
               
               
            </div>
          
        </div>
    </div>
</div>
<div id="tender-announcement" class="scroll-section">
    <div class="container-1280">
        <div class="row">
            <div class="col-lg-12 align-middle">
                <strong>Tender Announcement.</strong>
                <p>In this section you can see the ongoing tenders and you can participate to the tenders that suit your company capacity.</p>
            </div>
        </div>
    </div>  
</div>

<div class="container-1280 mt-3">

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Centralized Auctiont</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Scattered Auction</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Clustered Auction</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="app-table main-border-bottom">
                        <thead class="header">
                            <tr>
                                <td colspan="3">National BBN Quota for 1 Year</td>
                            </tr>
                            <tr>
                                <td>No</td>
                                <td>Year</td>
                                <td>Quota</td>
                            </tr>
                        </thead>
                        <tbody>
                            
                            
                        </tbody>
                        <tfoot class="footer">
                            <tr>
                                <td colspan="2">Total</td>
                                <td></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    
                     <table class="app-table main-border-bottom">
                            <thead class="header">
                                <tr>
                                    <td colspan="3">National BBN Quota for 1 Year</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td>Year</td>
                                    <td>Quota</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                    </table>
                    <table class="app-table main-border-bottom mt-3">
                            <thead class="header">
                                
                                <tr>
                                    <td colspan="3">Delivery Point</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td>Delivery Point</td>
                                    <td>Quota</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                    </table>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <table class="app-table main-border-bottom">
                            <thead class="header">
                                <tr>
                                    <td colspan="3">National BBN Quota for 1 Year</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td>Year</td>
                                    <td>Quota</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                    </table>
                    <table class="app-table main-border-bottom mt-3">
                            <thead class="header">
                                
                                <tr>
                                    <td colspan="3">Cluster Sulawesi</td>
                                </tr>
                                <tr>
                                    <td>No</td>
                                    <td>Delivery Point</td>
                                    <td>Quota</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                            <tfoot class="footer">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                    </table>           
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection