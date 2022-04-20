<?php

use App\Http\Controllers\admin\BankingAccountGroupsController;
use App\Http\Controllers\admin\BankingAccountLedgersController;
use App\Http\Controllers\admin\BanksController;
use App\Http\Controllers\admin\BankServiceChargeController;
use App\Http\Controllers\admin\BankServiceCommissionGroupsController;
use App\Http\Controllers\admin\BankTransactionsController;
use App\Http\Controllers\admin\CommonController;
use App\Http\Controllers\admin\CustomerBankAccountsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\StatesController;
use App\Http\Controllers\admin\DistrictController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\CareersController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// FRONT ROUTES STARTS HERE
// Route::get('/', [WebController::class, 'index']);
// Route::get('/our-company', [WebController::class, 'our_company'])->name('our-company');
// Route::get('/management', [WebController::class, 'management'])->name('management');
// Route::get('/quality-policy', [WebController::class, 'quality_policy'])->name('quality-policy');
// Route::get('/safety', [WebController::class, 'safety'])->name('safety');
// Route::get('/quality-assurance', [WebController::class, 'quality_assurance'])->name('quality-assurance');
// Route::get('/regulatory-and-compliance', [WebController::class, 'regulatory_and_compliance'])->name('regulatory-and-compliance');
// Route::get('/products-list', [WebController::class, 'products'])->name('products-list');
// Route::get('/products-view/{id}', [WebController::class, 'products_view'])->name('products-view');
// Route::get('/overview', [WebController::class, 'overview'])->name('overview');
// Route::get('/generics', [WebController::class, 'generics'])->name('generics');
// Route::get('/biosimilars', [WebController::class, 'biosimilars'])->name('biosimilars');
// Route::get('/novel-biologics', [WebController::class, 'novel_biologics'])->name('novel-biologics');
// Route::get('/research-services', [WebController::class, 'research_services'])->name('research-services');
// Route::get('/manufacturing', [WebController::class, 'manufacturing'])->name('manufacturing');
// Route::get('/lab', [WebController::class, 'lab'])->name('lab');
// Route::get('/rd-facility', [WebController::class, 'rd_facility'])->name('rd-facility');
// Route::get('/analytical-development', [WebController::class, 'analytical_development'])->name('analytical-development');
// Route::get('/open-positions', [WebController::class, 'open_positions'])->name('open-positions');
// Route::get('/news-info', [WebController::class, 'news'])->name('frontend.news');
// Route::get('/contacts', [WebController::class, 'contacts'])->name('contacts');
// Route::post('/subscribe', [WebController::class, 'subscribe'])->name('subscribe');


//FRONT END ROUTES ENDS HERE

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login2', [App\Http\Controllers\HomeController::class, 'login2'])->name('login2');


Route::get('backend', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Route::get('/contact-us', [WebController::class, 'contact_us']);
Route::get('/gallery', [WebController::class, 'gallery']);
Route::get('/gallery/{id}', [WebController::class, 'events']);
Route::get('/trivandrum-social-service-society', [WebController::class, 'tsss']);
Route::get('/the-board-of-education', [WebController::class, 'boe']);
Route::get('/kerala-catholic-youth-movement', [WebController::class, 'kcym']);
Route::get('/history', [WebController::class, 'history']);
Route::get('/maintenance-on', [CommonController::class, 'maintenance_on']);
Route::get('/maintenance-off', [CommonController::class, 'maintenance_off']);

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/settings', [SettingsController::class, 'index']);
        Route::match(['get', 'post'], '/change-password',[SettingsController::class, 'change_password'])->name('change_password');
        Route::post('/update-settings', [SettingsController::class, 'update']);
        Route::resource('news', NewsController::class);
        Route::resource('sliders', SlidersController::class);
        Route::post('sliders-sortable',[SlidersController::class,'order']);
        Route::resource('managements', ManagementController::class);
        Route::post('management-sortable',[ManagementController::class,'order']);
        Route::resource('products', ProductsController::class);
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('qualifications', QualificationController::class);
        Route::resource('job_types', JobTypeController::class);
        Route::resource('careers', CareersController::class);

        //zencare routes
        Route::resource('bank-service-commission-groups', BankServiceCommissionGroupsController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UsersController::class);
        //for common delete modal
        Route::get('delete/{route}/{id}', [CommonController::class, 'delete'])->name('delete');
        //For States CRUD : routes
        Route::resource('states', StatesController::class);
        //For Districts CRUD : routes
        Route::resource('districts', DistrictController::class);
        //For Banks CRUD : routes
        Route::resource('banks', BanksController::class);
        
        Route::resource('bank-service-charges', BankServiceChargeController::class);
        Route::resource('banking-account-ledgers', BankingAccountLedgersController::class);
        Route::resource('banking-account-groups', BankingAccountGroupsController::class);
        Route::resource('customer-bank-accounts', CustomerBankAccountsController::class);
        
        Route::resource('bank-transactions', BankTransactionsController::class);
        Route::match(['get', 'post'], 'get-customer-account',[BankTransactionsController::class, 'get_customer_account'])->name('get-customer-account');
        Route::match(['get', 'post'], 'get-service-charge',[BankTransactionsController::class, 'get_service_charge'])->name('get-service-charge');
        
        
    });
});