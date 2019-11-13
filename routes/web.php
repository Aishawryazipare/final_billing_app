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

Route::get('/home', 'HomeController@index');


Route::get('client-register','Auth\ClientController@showRegform');
Route::post('client-register','Auth\ClientController@create');

//Route::get('admin-login', 'Auth\LoginController@showLoginForm');
Route::post('admin-login', ['as'=>'admin-login','uses'=>'Auth\AdminController@login']);
Route::post('/admin-logout', 'Auth\AdminController@logout');//->name('admin.logout');





Route::get('/','Auth\AdminController@showLoginForm');
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
//Route::get('admin-login','Auth\AdminController@showLoginForm');
//Route::post('admin-login', 'Auth\AdminController@login');

Route::get('home-admin','HomeController@indexAdmin')->name('admin');
//Route::post('logout', 'Auth\LoginController@logout');

//Employee login
Route::get('employee-login','Auth\EmployeeController@showLoginForm');
Route::post('employee-login','Auth\EmployeeController@login');
Route::get('employee-home','HomeController@empIndex');
Route::post('/employee-logout', 'Auth\EmployeeController@logout');

//Dealer login
Route::get('dealer-login','Auth\DealerLoginController@showLoginForm');
Route::post('dealer-login','Auth\DealerLoginController@login');
Route::get('dealer-home','HomeController@dealerIndex');
Route::post('/dealer-logout', 'Auth\DealerLoginController@logout');
Route::get('dealer-clients','HomeController@showClients');

//Dealer Login
//Route::get('dealer-login','Auth\DealerLoginController@showLoginForm');
//Route::post('dealer_login', 'DealerController@dealerLogin');



//User List
Route::get('register','UserController@addEmployee');
Route::post('register','UserController@saveUser');
Route::get('user-list','UserController@userList');
Route::get('edit-user','UserController@userEdit');
Route::put('update-user/{id}','UserController@updateUser');
Route::get('delete-user/{id}','UserController@deletUser');

Route::get('/home', 'ClientController@index');
//Route::post('/login' , 'Auth\AuthController@authenticate');
//Enquiry
Route::get('enquiry-list','EnquiryController@enquiryList');
Route::get('add-enquiry','EnquiryController@addEnquiry');
Route::post('add-enquiry','EnquiryController@saveEnquiry');
Route::get('edit-enquiry','EnquiryController@editEnquiry');
Route::put('update-enquiry/{id}','EnquiryController@updateEnquiry');
Route::get('delete-enquiry/{id}','EnquiryController@deletEnquiry');
Route::get('mobile-validate/{id}','EnquiryController@validateMobile');

Route::get('product_val/{id}','EnquiryController@getProduct');


Route::get('get_city/{id}','MasterController@getCity');
//Enquiry Status
Route::get('enquiry-status','EnquiryStatusController@statusList');
Route::get('add-enquiry-status','EnquiryStatusController@addEnquirystatus');
Route::post('add-enquiry-status','EnquiryStatusController@saveStatus');
Route::get('edit-enquiry-status','EnquiryStatusController@editStatus');
Route::put('update-enquiry-status/{id}','EnquiryStatusController@updateStatus');
Route::get('delete-enquiry-status/{id}','EnquiryStatusController@deleteStatus');


//Get masterdata
Route::get('item_data','MasterController@getItemData');
Route::get('add_item','MasterController@getItem');
Route::post('add_item','MasterController@addItem');
Route::get('edit-item','MasterController@editItem');
Route::post('edit-item','MasterController@updateItem');
Route::get('delete-item/{item_id}','MasterController@deleteItem');


Route::get('cust_data','MasterController@getCustData');
Route::get('add_cust','MasterController@getCust');
Route::post('add_cust','MasterController@addCust');
Route::get('edit-cust','MasterController@editCust');
Route::post('edit-cust','MasterController@updateCust');
Route::get('delete-cust/{cust_id}','MasterController@deleteCust');

//Enquiry Status
Route::get('active-inactive','ActiveInactiveController@statusList');
Route::get('add-active-inactive','ActiveInactiveController@addEnquirystatus');
Route::post('add-active-inactive','ActiveInactiveController@saveStatus');
Route::get('edit-active-inactive','ActiveInactiveController@editStatus');
Route::put('update-active-inactive/{id}','ActiveInactiveController@updateStatus');
Route::get('delete-active-inactive/{id}','ActiveInactiveController@deleteStatus');

Route::get('email-validate/{id}','UserController@validateEmail');
Route::get('dashboard_enq_list','MasterController@dashboard_enq_list');


//Billing App
//user mgt
//Route::get('user_mgt','UserController@userList');
//Route::get('add-user','UserController@addUser');
//Route::post('add-user','UserController@saveUser');
//Route::get('edit-user','UserController@ediUser');
//Route::put('update-user/{id}','UserController@updateUser');
//Route::get('delete-user/{id}','UserController@deletUser');

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
//check master if already 
Route::get('check-exist','MasterController@check');
//Supplier
Route::get('supplier_data','MasterController@getSupplierData');
Route::get('add_supplier','MasterController@getSupplier');
Route::post('add_supplier','MasterController@addSupplier');
Route::get('edit-supplier','MasterController@editSupplier');
Route::post('edit-supplier','MasterController@updateSupplier');
Route::get('delete-supplier/{sup_id}','MasterController@deleteSupplier');


//check location
Route::get('check_location','UserController@checkLocation');


//Report
Route::get('sale_report','ReportController@getSale');
Route::get('get_employees','ReportController@getEmployee');
Route::post('sale_report','ReportController@fetchSale');

//Route::prefix('admin')->group(function () {
// //Route::get('/', 'Auth\LoginController@showAdminLoginForm');
//  Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
//  Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('admin.register');
//  Route::post('register', 'AdminController@store')->name('admin.register.store');
//  Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin.auth.login');
//  Route::post('login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');
//  Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');
//});

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
Route::get('get_serial_no','DealerController@getSerialNo');

//customer data
//Route::get('customer_data','CustomerController@getCustomerData');

//client data
Route::get('client_data','ClientController@getClientData');
Route::get('active_link/{id}/{val}','ClientController@getActivate');

//Purchase
Route::get('inventory','PurchaseController@getInventory');
Route::post('add_inventory','PurchaseController@addInventory');
Route::get('get_item_id','PurchaseController@getItemid');

Route::get('sale_report','ReportController@getSale');
Route::post('sale_report','ReportController@fetchSale');
Route::post('download_sale','ReportController@downloadSale');

//Cancel Bill report
Route::get('cancel_bill_report','ReportController@getCancelSale');
Route::post('cancel_bill_report','ReportController@fetchCancelSale');
Route::post('download_cancel_bill_report','ReportController@downloadCancelSale');
//inventory report
Route::get('inventory_report','ReportController@getInventory');
Route::post('inventory_report','ReportController@fetchInventory');
Route::post('download_inventory','ReportController@downloadInventory');
//item_report
Route::get('item_report','ReportController@getItem');
Route::get('download_item','ReportController@downloadItem');

//Brand 
Route::get('brand_list','BrandController@getBrandData');
Route::get('add_brand','BrandController@getBrand');
Route::post('add_brand','BrandController@addBrandData');
Route::get('delete-brand/{id}','BrandController@deleteBrand');
Route::get('edit-brand','BrandController@editBrand');
Route::post('edit-brand','BrandController@updateBrand');

////Admin login
//Route::get('admin-login','AdminController@login');
//Route::post('alogin', 'AdminController@adminLogin');
//Route::post('logout', 'Auth\LoginController@logout');
//
////Employee login
//Route::get('employee-login','AdminController@emplogin');
//Route::post('elogin', 'AdminController@employeeLogin');
//Route::get('employee-home','AdminController@empHome');

//Dealer Login
//Route::get('dealer-login','DealerController@login');
//Route::post('dealer_login', 'DealerController@dealerLogin');
//Clinet
Route::get('client_data','ClientController@getClientData');
//sale item report
Route::get('item_sale_report','ReportController@getItemSale');
Route::post('item_sale_report','ReportController@fetchItemSale');
Route::post('download_item_sale_report','ReportController@downloadItemSale');

//thumbnail wise
Route::get('thumbnail','SalesController@getThumb');
Route::get('get-item','SalesController@getItems');
Route::get('check-code','SalesController@checkItems');
Route::get('get-list','SalesController@getItems1');
Route::post('add_bill','SalesController@saveBill');

//settings
Route::get('settings','SettingController@getSetting');
Route::get('get_setting_details','SettingController@getSettingDetails');
//Route::get('get_header_footer','SettingController@getHeaderFooter');
Route::get('show-settings','SettingController@showSetting');
Route::post('add_header_footer','SettingController@addHeaderFooter');

Route::get('bill_print', 'SettingController@print_bill');
Route::get('get_header','SettingController@getHeader');
Route::get('get_footer','SettingController@getFooter');

//get main setting
Route::get('main-setting','SettingController@getMainSetting');
Route::post('main-setting','SettingController@addMainSetting');

//download bill
Route::get('download_bill','SalesController@downloadBill');

//Add Location
Route::get('bil_location_list','BillingLocationController@listLocation');
Route::get('bil_location_add','BillingLocationController@addLocation');
Route::post('bil_location_save','BillingLocationController@saveLocation');
Route::get('bil-location-edit','BillingLocationController@editLocation');
Route::post('bil_location_update','BillingLocationController@updateLocation');
Route::get('bil-location-delete/{loc_id}','BillingLocationController@deleteLocation');
Route::get('check-exist-location','BillingLocationController@check');

//notification
Route::get('sync_category','HomeController@send');
Route::get('autocomplete', 'SalesController@search');

//delete bill_no
Route::get('delete_bill','SalesController@delete_sales');
Route::post('cancel_bill','SalesController@delete_bill');
Route::get('fetch_bill','SalesController@fetch_bill');

Route::get('delete_bill_no','SalesController@delete_bill_no');


