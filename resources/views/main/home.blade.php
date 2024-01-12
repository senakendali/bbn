@extends("layouts.main")
@section("container")
<div id="tender-announcement" class="scroll-section">
    <div class="container-1280">
        <div class="row">
            <div class="col-lg-12 align-middle">
                Tender Announcement
                <p>In this section you can see the ongoing tenders and you can participate to the tenders that suit your company capacity.</p>
            </div>
        </div>
    </div>  
</div>
<div class="container-1280 company-profile mt-2" data-company-id="{{ auth()->user()->company_id }}">

</div>


<div class="container-1280 mt-2">
    <div class="row">
        <div class="col-lg-12">
            <table id="centralized" class="app-table main-border-bottom">
                <thead class="header">
                    <tr>
                        <td colspan="4">Tender List</td>
                    </tr>
                    <tr>      
                        <td>Tender Number</td>
                        <td>Method</td>
                        <td>National BBN Quota</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody> 
                </tbody>
            </table>
        </div>
    </div>
</div> 
@endsection