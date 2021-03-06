<?php


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function ()    {
        // Uses Auth Middleware
    });

    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });
});


Route::group(['middleware' => ['hideyobackend','auth.hideyo.backend'], 'prefix' => config()->get('hideyo.route_prefix').'/admin', 'namespace' => 'Hideyo\Ecommerce\Backend\Controllers'], function () {
 
    Route::get('/', array('as' => 'hideyo.index', 'uses' => 'DashboardController@index'));
   
    $this->generateCrud('dashboard', 'DashboardController');

    Route::get(
        'dashboard/stats/revenue-by-year/{year}', [
            'as' => 'hideyo.dashboard.stats',
            'uses' => 'DashboardController@getStatsRevenueByYear'
        ]
    );
    
    Route::get('dashboard/stats/order-average-by-year/{year}', array('as' => 'hideyo.dashboard.stats.average', 'uses' => 'DashboardController@getStatsOrderAverageByYear'));
    Route::get('dashboard/stats/browser-by-year/{year}', array('as' => 'hideyo.dashboard.stats.browser', 'uses' => 'DashboardController@getStatsBrowserByYear'));
    Route::get('dashboard/stats/totals-by-year/{year}', array('as' => 'hideyo.dashboard.stats.total', 'uses' => 'DashboardController@getStatsTotalsByYear'));
    Route::get('dashboard/stats/payment-method-by-year/{year}', array('as' => 'hideyo.dashboard.stats.payment.method', 'uses' => 'DashboardController@getStatsPaymentMethodByYear'));
    Route::get('dashboard/stats', array('as' => 'hideyo.dashboard.stats', 'uses' => 'DashboardController@showStats'));
    
    $this->generateCrud('shop', 'ShopController');

    Route::post('client/export', array('as' => 'hideyo.client.export', 'uses' => 'ClientController@postExport'));
    Route::get('client/export', array('as' => 'hideyo.client.export', 'uses' => 'ClientController@getExport'));

    Route::get('client/{clientId}/activate', array('as' => 'hideyo.client.activate', 'uses' => 'ClientController@getActivate'));    
    Route::post('client/{clientId}/activate', array('as' => 'hideyo.client.activate', 'uses' => 'ClientController@postActivate'));
    
    Route::get('client/{clientId}/de-activate', array('as' => 'hideyo.client.deactivate', 'uses' => 'ClientController@getDeActivate'));
    Route::post('client/{clientId}/de-activate', array('as' => 'hideyo.client.de-activate', 'uses' => 'ClientController@postDeActivate'));

    $this->generateCrud('client/{clientId}/order', 'ClientOrderController');

    $this->generateCrud('client/{clientId}/addresses', 'ClientAddressController');

    $this->generateCrud('client', 'ClientController');

    Route::get('redirect/export', array('as' => 'hideyo.redirect.export', 'uses' => 'RedirectController@getExport'));
    Route::get('redirect/import', array('as' => 'hideyo.redirect.import', 'uses' => 'RedirectController@getImport'));
    Route::post('redirect/import', array('as' => 'hideyo.redirect.import', 'uses' => 'RedirectController@postImport'));

    Route::get('order/print/products', array('as' => 'hideyo.order.print.products', 'uses' => 'OrderController@getPrintOrders'));
    
    Route::get('order/print', array('as' => 'hideyo.order.print', 'uses' => 'OrderController@getPrint'));
    Route::post('order/print', array('as' => 'hideyo.order.print', 'uses' => 'OrderController@postPrint'));
  
    Route::post('order/print/download', array('as' => 'hideyo.order.download.print', 'uses' => 'OrderController@postDownloadPrint'));
  
    $this->generateCrud('order', 'OrderController');

    $this->generateCrud('order-status', 'OrderStatusController');

    Route::get('order-status-email-template/show-template/{id}', array('as' => 'order.status.email.template.ajax.show', 'uses' => 'OrderStatusEmailTemplateController@showAjaxTemplate'));

    $this->generateCrud('order-status-email-template', 'OrderStatusEmailTemplateController');

    $this->generateCrud('redirect', 'RedirectController');

    $this->generateCrud('tax-rate', 'TaxRateController');

    $this->generateCrud('general-setting', 'GeneralSettingController');

    $this->generateCrud('sending-method', 'SendingMethodController');

    $this->generateCrud('payment-method', 'PaymentMethodController');

    $this->generateCrud('sending-payment-method-related', 'SendingPaymentMethodRelatedController');

    $this->generateCrud('error', 'ErrorController');

    $this->generateCrud('content/{contentId}/images', 'ContentImageController');

    Route::get('content/edit/{contentId}/seo', array('as' => 'hideyo.content.edit_seo', 'uses' => 'ContentController@editSeo'));

    $this->generateCrud('content', 'ContentController');

    $this->generateCrud('content-group', 'ContentGroupController');

    Route::get('content-group/edit/{contentGroupId}/seo', array('as' => 'hideyo.content-group.edit_seo', 'uses' => 'ContentGroupController@editSeo'));

    Route::get('news/refactor-images', array('as' => 'news.refactor.images', 'uses' => 'NewsController@refactorAllImages'));
 
    Route::get('news/re-directory-images', array('as' => 'news.re.directory.images', 'uses' => 'NewsController@reDirectoryAllImages'));
 

    $this->generateCrud('news/{newsId}/images', 'NewsImageController', 'news-images');

    Route::get('news/edit/{newsId}/seo', array('as' => 'hideyo.news.edit_seo', 'uses' => 'NewsController@editSeo'));

    $this->generateCrud('news', 'NewsController');

    $this->generateCrud('news-group', 'NewsGroupController');

    Route::get('news-group/edit/{newsGroupId}/seo', array('as' => 'hideyo.news-group.edit_seo', 'uses' => 'NewsGroupController@editSeo'));

    $this->generateCrud('faq', 'FaqItemController');

    Route::resource('html-block/{htmlBlockId}/copy', 'HtmlBlockController@copy');
    Route::get('html-block/change-active/{htmlBlockId}', array('as' => 'hideyo.html.block.change-active', 'uses' => 'HtmlBlockController@changeActive'));
 
    Route::post('html-block/{htmlBlockId}/copy', array('as' => 'html.block.store.copy', 'uses' => 'HtmlBlockController@storeCopy'));
 
    $this->generateCrud('html-block', 'HtmlBlockController');

    $this->generateCrud('coupon-group', 'CouponGroupController');

    $this->generateCrud('coupon', 'CouponController');

    Route::post('order/update-status/{orderId}', array('as' => 'order.update-status', 'uses' => 'OrderController@updateStatus'));
 
    Route::get('order/update-sending-method/{sendingMethodId}', array('as' => 'order.update.sending.method', 'uses' => 'OrderController@updateSendingMethod'));
    Route::get('order/update-payment-method/{paymentMethodId}', array('as' => 'order.update.payment.method', 'uses' => 'OrderController@updatePaymentMethod'));

    Route::resource('order/{orderId}/download', 'OrderController@download');
    Route::resource('order/{orderId}/download-label', 'OrderController@downloadLabel');

    Route::get('order/update-billing-address/{addressId}', array('as' => 'order.update.billing.address', 'uses' => 'OrderController@updateClientBillAddress'));
    Route::get('order/update-delivery-address/{addressId}', array('as' => 'order.update.delivery.address', 'uses' => 'OrderController@updateClientDeliveryAddress'));

    Route::post('order/add-client', array('as' => 'hideyo.order.add-client', 'uses' => 'OrderController@addClient'));

    Route::post('order/add-product', array('as' => 'hideyo.order.add-product', 'uses' => 'OrderController@addProduct'));

    Route::get('order/update-amount-product/{productId}/{amount}', array('as' => 'hideyo.order.update.amount.product', 'uses' => 'OrderController@updateAmountProduct'));
 
    Route::get('order/change-product-combination/{productId}/{newProductId}', array('as' => 'hideyo.order.change.product.combination', 'uses' => 'OrderController@changeProductCombination'));

    Route::get('order/delete-product/{productId}', array('as' => 'order.delete-product', 'uses' => 'OrderController@deleteProduct'));
    $this->generateCrud('invoice', 'InvoiceController');
    Route::resource('invoice/{invoiceId}/download', 'InvoiceController@download');

    $this->generateCrud('attribute-group/{attributeGroupId}/attributes', 'AttributeController', 'attribute');

    $this->generateCrud('attribute-group', 'AttributeGroupController');

    $this->generateCrud('extra-field/{extraFieldId}/values', 'ExtraFieldDefaultValueController', 'extra-field-values');
    
    $this->generateCrud('extra-field', 'ExtraFieldController');

    Route::get('product/refactor-images', array('as' => 'product.refactor-images', 'uses' => 'ProductController@refactorAllImages'));
    Route::get('product/re-directory-images', array('as' => 'product.re-directory-images', 'uses' => 'ProductController@reDirectoryAllImages'));

    Route::post('product/export', array('as' => 'hideyo.product.export', 'uses' => 'ProductController@postExport'));

    Route::get('product/export', array('as' => 'hideyo.product.export', 'uses' => 'ProductController@getExport'));

    Route::get('product/rank', array('as' => 'hideyo.product.rank', 'uses' => 'ProductController@getRank'));

    $this->generateCrud('product', 'ProductController');

    Route::get('product/edit/{productId}/price', array('as' => 'hideyo.product.edit_price', 'uses' => 'ProductController@editPrice'));
    Route::get('product/change-active/{productId}', array('as' => 'hideyo.product.change-active', 'uses' => 'ProductController@changeActive'));
    Route::get('product/change-amount/{productId}/{amount?}', array('as' => 'hideyo.product.change-amount', 'uses' => 'ProductController@changeAmount'));
    Route::get('product/change-rank/{productId}/{rank?}', array('as' => 'hideyo.product.change-rank', 'uses' => 'ProductController@changeRank'));
  
    Route::get('product/edit/{productId}/seo', array('as' => 'hideyo.product.edit_seo', 'uses' => 'ProductController@editSeo'));
    $this->generateCrud('product/{productId}/images', 'ProductImageController', 'product.image');
    $this->generateCrud('product/{productId}/product-amount-option', 'ProductAmountOptionController', 'product.amount-option');
    $this->generateCrud('product/{productId}/product-amount-series', 'ProductAmountSeriesController', 'product.amount-series');

    Route::get('product/{productId}/copy', array('as' => 'hideyo.product.copy', 'users' => 'ProductController@copy'));

    $this->generateCrud('product/{productId}/product-combination', 'ProductCombinationController', 'product.combination');

    Route::get('product/{productId}/product-combination/change-amount-attribute/{id}/{amount?}', array('as' => 'hideyo.product.change-amount-combination', 'uses' => 'ProductCombinationController@changeAmount'));
 
    Route::post('product/{productId}/copy', array('as' => 'product.store-copy', 'uses' => 'ProductController@storeCopy'));
    
    $this->generateCrud('product/{productId}/product-extra-field-value', 'ProductExtraFieldValueController', 'product.extra-field-value');

    $this->generateCrud('product/{productId}/related-product', 'ProductRelatedProductController', 'product.related-product');

    Route::get('product-category/refactor-images', array('as' => 'product-category.refactor-images', 'uses' => 'ProductCategoryController@refactorAllImages'));
    Route::get('product-category/re-directory-images', array('as' => 'product-category.re-directory-images', 'uses' => 'ProductCategoryController@reDirectoryAllImages'));

    $this->generateCrud('brand/{brandId}/images', 'BrandImageController', 'brand-image');
 
    Route::get('brand/edit/{brandId}/seo', array('as' => 'hideyo.brand.edit_seo', 'uses' => 'BrandController@editSeo'));
 
    $this->generateCrud('brand', 'BrandController');

    Route::get('product-category/change-active/{productCategoryId}', array('as' => 'hideyo.product-category.change-active', 'uses' => 'ProductCategoryController@changeActive'));

    Route::get('product_category/get_ajax_categories', array('as' => 'hideyo.product-category.ajax_categories', 'uses' => 'ProductCategoryController@ajaxCategories'));
    Route::get('product_category/get_ajax_category/{id}', array('as' => 'hideyo.product-category.ajax_category', 'uses' => 'ProductCategoryController@ajaxCategory'));
 
    Route::get('product_category/edit/{productCategoryId}/hightlight', array('as' => 'hideyo.product-category.edit.hightlight', 'uses' => 'ProductCategoryController@editHighlight'));

    $this->generateCrud('product-category/{productCategoryId}/images', 'ProductCategoryImageController', 'product-category-images');


    Route::get('product_category/edit/{productCategoryId}/seo', array('as' => 'hideyo.product-category.edit_seo', 'uses' => 'ProductCategoryController@editSeo'));

    Route::get('product_category/ajax-root-tree', array('as' => 'hideyo.product-category.ajax-root-tree', 'uses' => 'ProductCategoryController@ajaxRootTree'));
    Route::get('product_category/ajax-children-tree', array('as' => 'hideyo.product-category.ajax-children-tree', 'uses' => 'ProductCategoryController@ajaxChildrenTree'));
    Route::get('product_category/ajax-move-node', array('as' => 'hideyo.product-category.ajax-move-node', 'uses' => 'ProductCategoryController@ajaxMoveNode'));

    Route::get('product_category/tree', array('as' => 'hideyo.product-category.tree', 'uses' => 'ProductCategoryController@tree'));

    $this->generateCrud('product-category', 'ProductCategoryController');

    $this->generateCrud('product-tag-group', 'ProductTagGroupController');

    $this->generateCrud('user', 'UserController');

    Route::get('profile/shop/change/{shopId}', array('as' => 'change.language.profile', 'uses' => 'UserController@changeShopProfile'));
    Route::get('profile', array('as' => 'edit.profile', 'uses' => 'UserController@editProfile'));
    Route::post('profile', array('as' => 'update.profile', 'uses' => 'UserController@updateProfile'));
    Route::post('profile_language', array('as' => 'update.language', 'uses' => 'UserController@updateLanguage'));
});

Route::group(['prefix' => config()->get('hideyo.route_prefix').'/admin', 'namespace' => 'Hideyo\Ecommerce\Backend\Controllers', 'middleware' => ['hideyobackend']], function () {
    Route::get('/security/login', 'AuthController@getLogin');
    Route::post('/security/login', 'AuthController@postLogin');
    Route::get('/security/logout', array('as' => 'hideyo.security.logout', 'uses' => 'AuthController@getLogout'));
});