<?php


use App\Models\Province;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\DeliveryPointController;
use App\Http\Controllers\BbnProducerController;
use App\Http\Controllers\SupplyPointController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\JoinTenderController; 
use Illuminate\Support\Facades\Auth;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [PageController::class, 'index']);
Route::get('/vendors/registration', [PageController::class, 'registration']);
Route::get('/vendors/login', [PageController::class, 'login']);
Route::get('/order', [OrderController::class, 'index']);
Route::get('confirm/{transaction_no}/{snapToken}', [OrderController::class, 'show']);
Route::get('/payment-status/{transaction_no}', [OrderController::class, 'status']);
Route::post('/vendors/submitRegistrationData',[PageController::class, 'submitRegistrationData']);


Route::post('/update_payment_status',[OrderController::class, 'update_payment_status']);
Route::post('/order/submit',[OrderController::class, 'submit']);

Route::get('midtrans', [OrderController::class, 'midtrans']);

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::post('/vendor/login', [PageController::class, 'authenticate'])->name('vendor.login');
Route::post('/vendor/logout', [PageController::class, 'logout'])->name('vendor.logout');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');

Route::get('/dashboard/choose-type', [DashboardController::class, 'choose'])->name('login')->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('login')->middleware('auth');
Route::get('/view/order/{transaction_no}', [OrderController::class, 'DetailOrder']);
Route::get('export-to-excel', [DashboardController::class, 'ExportToExcel']);
Route::post('setDashboardType',[DashboardController::class, 'setDashboardType']);

Route::get('/tenders', [TenderController::class, 'index'])->middleware('auth');
Route::get('/tenders/create', [TenderController::class, 'create'])->middleware('auth');
Route::get('/tenders/view/{tender_id}', [TenderController::class, 'view']);
Route::get('/tenders/detail/{tender_id}', [TenderController::class, 'getDetail']);
Route::get('/tenders/getTenderLogs/{tender_id}', [TenderController::class, 'getTenderLogs']);
Route::get('/tenders/getDeliveryPoint/{tender_id}', [TenderController::class, 'getDeliveryPoint']);
Route::get('/tenders/getCluster/{tender_id}', [TenderController::class, 'getCluster']);
Route::get('/tenders/showDeliveryPointByCluster/{cluster_id}',[TenderController::class, 'showDeliveryPointByCluster']);
Route::get('/tenders/chooseDeliveryPointForCluster/{tender_id}',[TenderController::class, 'chooseDeliveryPointForCluster']);
Route::get('/tenders/showDeliveryPointByTender/{tender_id}',[TenderController::class, 'showDeliveryPointByTender']);
Route::get('/tenders/getAppliedDeliveryPointByTender/{tender_id}',[TenderController::class, 'getAppliedDeliveryPointByTender']);
Route::get('/tenders/apply/{tender_id}', [PageController::class, 'apply']);

Route::get('/tenders/view_centralized_submissions/{tender_id}', [TenderController::class, 'view_centralized_submissions']);
Route::get('/tenders/getCentralizedBid/{tender_id}', [TenderController::class, 'getCentralizedBid']);



Route::post('/tenders/store',[TenderController::class, 'store']);
Route::post('/tenders/publish',[TenderController::class, 'publish']);
Route::post('/tenders/storeCluster',[TenderController::class, 'storeCluster']);
Route::post('/tenders/storeDeliveryPoint',[TenderController::class, 'storeDeliveryPoint']);
Route::post('/tenders/submitQuotation',[JoinTenderController::class, 'submitQuotation']);



Route::get('/tenders/show', [TenderController::class, 'show']);
Route::get('/tenders/showTender', [TenderController::class, 'showTender']);


Route::get('/delivery-point', [DeliveryPointController::class, 'index'])->middleware('auth');
Route::get('/delivery-point/create', [DeliveryPointController::class, 'create'])->middleware('auth');
Route::get('/delivery-point/view/{transaction_no}', [DeliveryPointController::class, 'DetailOrder']);
Route::post('/delivery-point/store',[DeliveryPointController::class, 'store']);
Route::get('/delivery-point/show', [DeliveryPointController::class, 'show']);
Route::get('/delivery-point/show/{province_id}', [DeliveryPointController::class, 'show']);

Route::get('/bbn-producer', [BbnProducerController::class, 'index'])->middleware('auth');
Route::get('/bbn-producer/create', [BbnProducerController::class, 'create'])->middleware('auth');
Route::get('/bbn-producer/view/{transaction_no}', [BbnProducerController::class, 'DetailOrder']);
Route::post('/bbn-producer/store',[BbnProducerController::class, 'store']);
Route::get('/bbn-producer/show', [BbnProducerController::class, 'show']);


Route::get('/supply-point', [SupplyPointController::class, 'index'])->middleware('auth');
Route::get('/supply-point/create', [SupplyPointController::class, 'create'])->middleware('auth');
Route::get('/supply-point/view/{transaction_no}', [SupplyPointController::class, 'DetailOrder']);
Route::post('/supply-point/store',[SupplyPointController::class, 'store']);
Route::get('/supply-point/show', [SupplyPointController::class, 'show']);

Route::get('/cluster', [ClusterController::class, 'index'])->middleware('auth');
Route::get('/cluster/create', [ClusterController::class, 'create'])->middleware('auth');
Route::get('/cluster/view/{transaction_no}', [ClusterController::class, 'DetailOrder']);
Route::post('/cluster/store',[ClusterController::class, 'store']);
Route::get('/cluster/show', [ClusterController::class, 'show']);

// Logout
Route::get('/logout', [AuthController::class, 'logout']);



//Calling resources api
Route::get('getProvinces', [ResourcesController::class, 'getProvinces']);
Route::get('/getCompanyDetail/{company_id}', [ResourcesController::class, 'getCompanyDetail']);
Route::post('getRegencies',[ResourcesController::class, 'getRegencies']);
Route::post('getSupplyPoint',[ResourcesController::class, 'getSupplyPoint']);








