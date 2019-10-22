<?php

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

Route::view('/', 'welcome');
    Auth::routes();
    Route::get('/','Auth\LoginController@login');
    Route::get('/admin','Auth\LoginController@login');
    Route::get('abc', 'Auth\LoginController@showAdminLoginForm');
    Route::get('writer-login', 'Auth\LoginController@showWriterLoginForm');
    Route::get('admin-register', 'Auth\RegisterController@showAdminRegisterForm');
    Route::get('writer-register', 'Auth\RegisterController@showWriterRegisterForm');

    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::post('/login/writer', 'Auth\LoginController@writerLogin');
    Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
    Route::post('/register/writer', 'Auth\RegisterController@createWriter');

    Route::view('/home', 'home')->middleware('auth');
    Route::view('/admin', 'admin');
    Route::view('/writer', 'writer');
    
    //user mgt
Route::get('user_mgt','UserController@userList');
Route::get('add-user','UserController@addUser');
Route::post('add-user','UserController@saveUser');
Route::get('edit-user','UserController@ediUser');
Route::put('update-user/{id}','UserController@updateUser');
Route::get('delete-user/{id}','UserController@deletUser');

//Get masterdata
Route::get('type_data','MasterController@getTypeData');
Route::get('category_data','MasterController@getCategoryData');
Route::get('subscription_data','MasterController@getSubscriptionData');
Route::get('item_data','MasterController@getItemData');
Route::get('customer_data','MasterController@getCustomerData');
Route::get('add_type','MasterController@getType');
Route::get('add_category','MasterController@getCategory');
Route::get('add_subscription','MasterController@getSubscription');
Route::get('add_item','MasterController@getItem');
Route::get('add_customer','MasterController@getCustomer');
//Add masterdata
Route::post('add_type','MasterController@addType');
Route::post('add_category','MasterController@addCategory');
Route::post('add_subscription','MasterController@addSubscription');
Route::post('add_item','MasterController@addItem');
Route::post('add_customer','MasterController@addCustomer');

//edit masterdata
Route::get('edit-type','MasterController@editType');
Route::post('edit-type','MasterController@updateType');
Route::get('edit-category','MasterController@editCategory');
Route::post('edit-category','MasterController@updateCategory');
Route::get('edit-subscription','MasterController@editSubscription');
Route::post('edit-subscription','MasterController@updateSubscription');
Route::get('edit-item','MasterController@editItem');
Route::post('edit-item','MasterController@updateItem');
Route::get('edit-customer','MasterController@editCustomer');
Route::post('edit-customer','MasterController@updateCustomer');
//delete masterdata
Route::get('delete-type/{type_id}','MasterController@deleteType');
Route::get('delete-category/{cat_id}','MasterController@deleteCategory');
Route::get('delete-subscription/{sub_id}','MasterController@deleteSubscription');
Route::get('delete-item/{item_id}','MasterController@deleteItem');
Route::get('delete-customer/{cust_id}','MasterController@deleteCustomer');
//check location
Route::get('check_location','UserController@checkLocation');


//Report
Route::get('sale_report','ReportController@getSale');

Route::prefix('admin')->group(function () {
 //Route::get('/', 'Auth\LoginController@showAdminLoginForm');
  Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
  Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('admin.register');
  Route::post('register', 'AdminController@store')->name('admin.register.store');
  Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin.auth.login');
  Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
  Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
});

//dealer data
Route::get('dealer_data','DealerController@getDealerData');
Route::get('add_dealer','DealerController@getDealer');
Route::post('add_dealer','DealerController@addDealer');
Route::get('delete-dealer/{dealer_id}','DealerController@deleteDealer');
Route::get('edit-dealer','DealerController@editDealer');
Route::post('edit-dealer','DealerController@updateDealer');
Route::get('get_dealer_code','DealerController@getDealerCode');

//machine data
Route::get('machine_data','DealerController@getMachineData');
Route::get('add_machine','DealerController@getMachine');
Route::post('add_machine','DealerController@addMachine');
Route::get('delete-machine/{machine_id}','DealerController@deleteMachine');
Route::get('edit-machine','DealerController@editMachine');
Route::post('edit-machine','DealerController@updateMachine');

//customer data
//Route::get('customer_data','CustomerController@getCustomerData');

//client data
Route::get('client_data','ClientController@getClientData');


//Admin login
Route::get('admin-login','AdminController@login');
Route::post('alogin', 'AdminController@adminLogin');
Route::post('logout', 'Auth\LoginController@logout');

//Employee login
Route::get('employee-login','AdminController@emplogin');
Route::post('elogin', 'AdminController@employeeLogin');

//Dealer Login
Route::get('dealer-login','DealerController@login');
Route::post('dealer_login', 'DealerController@dealerLogin');

//Purchase
Route::get('inventory','PurchaseController@getInventory');
Route::post('add_inventory','PurchaseController@addInventory');
Route::get('get_item_id','PurchaseController@getItemid');