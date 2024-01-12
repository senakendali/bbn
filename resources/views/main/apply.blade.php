@extends("layouts.main")
@section("container")


<div id="tender-announcement" class="scroll-section">
    <div class="container-1280">
        <div class="row">
            <div class="col-lg-12 align-middle">
                Submit Quotation
                <p>Please feel free to send Your offered price and volume</p>
            </div>
        </div>
    </div>  
</div>

<div class="container-1280 company-profile mt-2" data-company-id="{{ auth()->user()->company_id }}">

</div>
<form id="form-data" method="post" enctype="multipart/form-data" class="mt-3">
    @csrf
    <input type="hidden" name="tender_id" value="{{ Request::segment(3) }}" autocomplete="off"> 
    <input type="hidden" id="method" name="method" value="" autocomplete="off"> 
    <div class="container-1280 mt-2">
        <div class="row">  
            <div class="col-lg-12">
                <table id="data-detail" class="app-table main-border-bottom">
                    <thead class="header">
                        <tr>
                            <td colspan="5">National BBN Quota</td>
                        </tr>
                        <tr>
                            <td>Tender Number</td>
                            <td>Method</td>
                            <td>Currency</td>
                            <td>Year</td>
                            <td>Quota</td>
                        </tr>
                    </thead>
                    <tbody>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<div class="fixed-bottom auto-sum">
  <div class="container-1280">
    <div class="row">
        
        <div class="col-lg-12 text-end"><button class="btn btn-light" onclick="Apply.submitQuotation(event)" >Submit Quotation</button></div>
    </div>
   
  </div>
</nav>
@endsection