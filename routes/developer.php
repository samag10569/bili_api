<?php
//echo 'developer';exit;


Route::group(array('prefix' => config('site.admin')), function () {


    Route::group(array('middleware' => 'AdminPermission'), function () {

        //---------------------Allotment Category-----------------------------
        Route::get('allotment-category', 'Admin\AllotmentCategoryController@getIndex');
        Route::get('allotment-category/add', 'Admin\AllotmentCategoryController@getAdd');
        Route::post('allotment-category/add', 'Admin\AllotmentCategoryController@postAdd');
        Route::get('allotment-category/edit/{id}', 'Admin\AllotmentCategoryController@getEdit');
        Route::post('allotment-category/edit/{id}', 'Admin\AllotmentCategoryController@postEdit');
        Route::post('allotment-category/delete', 'Admin\AllotmentCategoryController@postDelete');
        Route::post('allotment-category/sort', 'Admin\AllotmentCategoryController@postSort');

        //---------------------Allotment Category-----------------------------
        Route::get('adsorder-category', 'Admin\AdsOrderCategoryController@getIndex');
        Route::get('adsorder-category/add', 'Admin\AdsOrderCategoryController@getAdd');
        Route::post('adsorder-category/add', 'Admin\AdsOrderCategoryController@postAdd');
        Route::get('adsorder-category/edit/{id}', 'Admin\AdsOrderCategoryController@getEdit');
        Route::post('adsorder-category/edit/{id}', 'Admin\AdsOrderCategoryController@postEdit');
        Route::post('adsorder-category/delete', 'Admin\AdsOrderCategoryController@postDelete');
        Route::post('adsorder-category/sort', 'Admin\AdsOrderCategoryController@postSort');

        //--------------------- Allotment -----------------------------
        Route::get('allotment', 'Admin\AllotmentController@getIndex');
        Route::get('allotment/add', 'Admin\AllotmentController@getAdd');
        Route::post('allotment/add', 'Admin\AllotmentController@postAdd');
        Route::get('allotment/edit/{id}', 'Admin\AllotmentController@getEdit');
        Route::post('allotment/edit/{id}', 'Admin\AllotmentController@postEdit');
        Route::post('allotment/delete', 'Admin\AllotmentController@postDelete');
        Route::post('allotment/sort', 'Admin\AllotmentController@postSort');

        //--------------------- Scientific Category-----------------------------
        Route::get('scientific-category', 'Admin\ScientificCategoryController@getIndex');
        Route::get('scientific-category/add', 'Admin\ScientificCategoryController@getAdd');
        Route::post('scientific-category/add', 'Admin\ScientificCategoryController@postAdd');
        Route::get('scientific-category/edit/{id}', 'Admin\ScientificCategoryController@getEdit');
        Route::post('scientific-category/edit/{id}', 'Admin\ScientificCategoryController@postEdit');
        Route::post('scientific-category/delete', 'Admin\ScientificCategoryController@postDelete');
        Route::post('scientific-category/sort', 'Admin\ScientificCategoryController@postSort');

        //--------------------- shopping Category-----------------------------
        Route::get('shop-category', 'Admin\ShopCategoryController@getIndex')->name('admin.categories.list');
        Route::get('shop-category/add', 'Admin\ShopCategoryController@getAdd')->name('admin.category.add');
        Route::post('shop-category/add', 'Admin\ShopCategoryController@postAdd');
        Route::get('shop-category/edit/{id}', 'Admin\ShopCategoryController@getEdit')->name('admin.category.edit');
        Route::post('shop-category/edit/{id}', 'Admin\ShopCategoryController@postEdit')->name('admin.category.update');
        Route::post('shop-category/delete', 'Admin\ShopCategoryController@postDelete');
        Route::post('shop-category/sort', 'Admin\ShopCategoryController@postSort');

        //--------------------- billboards -----------------------------
        Route::get('billboards', 'Admin\BillboardController@getIndex')->name('admin.billboards.list');
        Route::get('billboard/add', 'Admin\BillboardController@getAdd')->name('admin.billboard.add');
        Route::post('billboard/add', 'Admin\BillboardController@postAdd');
        Route::get('billboard/edit/{id}', 'Admin\BillboardController@getEdit')->name('admin.billboard.edit');
        Route::post('billboard/edit/{id}', 'Admin\BillboardController@postEdit')->name('admin.billboard.update');
        Route::post('billboard/delete', 'Admin\BillboardController@postDelete');


        Route::get('allads', 'Admin\AllAdsController@getIndex')->name('admin.allads.list');
        Route::get('allads/{type}/{id}', 'Admin\AllAdsController@getIndex2')->name('admin.allads.list2');

        Route::get('ads_orders', 'Admin\AdsOrderController@getIndex')->name('admin.ads_orders.list');
        Route::get('ads_order/add', 'Admin\AdsOrderController@getAdd')->name('admin.ads_order.add');
        Route::post('ads_order/add', 'Admin\AdsOrderController@postAdd');
        Route::get('ads_order/edit/{id}', 'Admin\AdsOrderController@getEdit')->name('admin.ads_order.edit');
        Route::post('ads_order/edit/{id}', 'Admin\AdsOrderController@postEdit')->name('admin.ads_order.update');
        Route::post('ads_order/delete', 'Admin\AdsOrderController@postDelete');

        //--------------------- AdsText -----------------------------
        Route::get('ads_texts', 'Admin\AdsTextController@getIndex')->name('admin.ads_texts.list');
        Route::get('ads_text/add', 'Admin\AdsTextController@getAdd')->name('admin.ads_text.add');
        Route::post('ads_text/add', 'Admin\AdsTextController@postAdd');
        Route::get('ads_text/edit/{id}', 'Admin\AdsTextController@getEdit')->name('admin.ads_text.edit');
        Route::post('ads_text/edit/{id}', 'Admin\AdsTextController@postEdit')->name('admin.ads_text.update');
        Route::post('ads_text/delete', 'Admin\AdsTextController@postDelete');
        //--------------------- AdsImages -----------------------------
        Route::get('ads_images', 'Admin\AdsImageController@getIndex')->name('admin.ads_images.list');
        Route::get('ads_image/add', 'Admin\AdsImageController@getAdd')->name('admin.ads_image.add');
        Route::post('ads_image/add', 'Admin\AdsImageController@postAdd');
        Route::get('ads_image/edit/{id}', 'Admin\AdsImageController@getEdit')->name('admin.ads_image.edit');
        Route::post('ads_image/edit/{id}', 'Admin\AdsImageController@postEdit')->name('admin.ads_image.update');
        Route::post('ads_image/delete', 'Admin\AdsImageController@postDelete');
        //--------------------- AdsVideo -----------------------------
        Route::get('ads_videos', 'Admin\AdsVideoController@getIndex')->name('admin.ads_videos.list');
        Route::get('ads_video/add', 'Admin\AdsVideoController@getAdd')->name('admin.ads_video.add');
        Route::post('ads_video/add', 'Admin\AdsVideoController@postAdd');
        Route::get('ads_video/edit/{id}', 'Admin\AdsVideoController@getEdit')->name('admin.ads_video.edit');
        Route::post('ads_video/edit/{id}', 'Admin\AdsVideoController@postEdit')->name('admin.ads_video.update');
        Route::post('ads_video/delete', 'Admin\AdsVideoController@postDelete');
        //--------------------- AdsApp -----------------------------
        Route::get('ads_apps', 'Admin\AdsAppController@getIndex')->name('admin.ads_apps.list');
        Route::get('ads_app/add', 'Admin\AdsAppController@getAdd')->name('admin.ads_app.add');
        Route::post('ads_app/add', 'Admin\AdsAppController@postAdd');
        Route::get('ads_app/edit/{id}', 'Admin\AdsAppController@getEdit')->name('admin.ads_app.edit');
        Route::post('ads_app/edit/{id}', 'Admin\AdsAppController@postEdit')->name('admin.ads_app.update');
        Route::post('ads_app/delete', 'Admin\AdsAppController@postDelete');

        Route::get('ads_billboards', 'Admin\AdsBillboardController@getIndex')->name('admin.ads_billboards.list');
        Route::get('ads_billboard/add', 'Admin\AdsBillboardController@getAdd')->name('admin.ads_billboard.add');
        Route::post('ads_billboard/add', 'Admin\AdsBillboardController@postAdd');
        Route::get('ads_billboard/edit/{id}', 'Admin\AdsBillboardController@getEdit')->name('admin.ads_billboard.edit');
        Route::post('ads_billboard/edit/{id}', 'Admin\AdsBillboardController@postEdit')->name('admin.ads_billboard.update');
        Route::post('ads_billboard/delete', 'Admin\AdsBillboardController@postDelete');

        //--------------------- Products -----------------------------
        Route::get('products', 'Admin\ProductController@getIndex')->name('admin.products.list');
        Route::get('product/add', 'Admin\ProductController@getAdd')->name('admin.product.add');
        Route::post('product/add', 'Admin\ProductController@postAdd');
        Route::get('product/edit/{id}', 'Admin\ProductController@getEdit')->name('admin.product.edit');
        Route::post('product/edit/{id}', 'Admin\ProductController@postEdit')->name('admin.product.update');
        Route::post('product/delete', 'Admin\ProductController@postDelete');
        //--------------------- Subscription -----------------------------
        Route::get('subscriptions', 'Admin\ShopSubscriptionController@getIndex')->name('admin.subscriptions.list');
        Route::post('subscriptions/delete', 'Admin\ShopSubscriptionController@postDelete');

        //--------------------- Scientific -----------------------------
        Route::get('scientific', 'Admin\ScientificController@getIndex');
        Route::get('scientific/add', 'Admin\ScientificController@getAdd');
        Route::post('scientific/add', 'Admin\ScientificController@postAdd');
        Route::get('scientific/edit/{id}', 'Admin\ScientificController@getEdit');
        Route::post('scientific/edit/{id}', 'Admin\ScientificController@postEdit');
        Route::post('scientific/delete', 'Admin\ScientificController@postDelete');

        Route::get('scientific-users', 'Admin\ScientificUsersController@getIndex');
        Route::get('scientific-users/edit/{id}', 'Admin\ScientificUsersController@getEdit');
        Route::post('scientific-users/edit/{id}', 'Admin\ScientificUsersController@postEdit');

        //--------------------- Interduction -----------------------------
        Route::get('interduction', 'Admin\InterductionController@getIndex');
        Route::get('interduction/add', 'Admin\InterductionController@getAdd');
        Route::post('interduction/add', 'Admin\InterductionController@postAdd');
        Route::get('interduction/edit/{id}', 'Admin\InterductionController@getEdit');
        Route::post('interduction/edit/{id}', 'Admin\InterductionController@postEdit');
        Route::post('interduction/delete', 'Admin\InterductionController@postDelete');
        Route::post('interduction/user', 'Admin\InterductionController@postUser');

        //--------------------- ReportPro -----------------------------
        Route::get('report-pro', 'Admin\ReportProController@getIndex');
        Route::post('report-pro/task1', 'Admin\ReportProController@postTask1');
        Route::post('report-pro/task2', 'Admin\ReportProController@postTask2');
        Route::post('report-pro/task3', 'Admin\ReportProController@postTask3');
        Route::post('report-pro/task4', 'Admin\ReportProController@postTask4');
        Route::post('report-pro/task5', 'Admin\ReportProController@postTask5');
        Route::post('report-pro/task7', 'Admin\ReportProController@postTask7');
        Route::post('report-pro/task8', 'Admin\ReportProController@postTask8');
        Route::post('report-pro/task9', 'Admin\ReportProController@postTask9');

        //--------------------- TempUsers -----------------------------
        Route::get('temp-users', 'Admin\TempUsersController@getIndex');
        Route::post('temp-users/send-confirm-phone', 'Admin\TempUsersController@postSendConfirmPhone');
        Route::post('temp-users/send-confirm-email', 'Admin\TempUsersController@postSendConfirmEmail');
        Route::get('temp-users/email/{id}', 'Admin\TempUsersController@getEmail');
        Route::get('temp-users/mobile/{id}', 'Admin\TempUsersController@getMobile');

        //--------------------- ScientificComments -----------------------------
        Route::get('scientific-comments', 'Admin\ScientificCommentsController@getIndex');
        Route::get('scientific-comments/edit/{id}', 'Admin\ScientificCommentsController@getEdit');
        Route::post('scientific-comments/delete', 'Admin\ScientificCommentsController@postDelete');
        Route::post('scientific-comments/edit/{id}', 'Admin\ScientificCommentsController@postEdit');

        //---------------------- Newsletter Users -----------------------------------
        Route::get('newsletter-users', 'Admin\NewsletterUsersController@getIndex');
        Route::get('newsletter-users/add', 'Admin\NewsletterUsersController@getAdd');
        Route::post('newsletter-users/add', 'Admin\NewsletterUsersController@postAdd');
        Route::post('newsletter-users/delete', 'Admin\NewsletterUsersController@postDelete');

        //---------------------- Newsletters ------------------------------------
        Route::get('newsletters', 'Admin\NewsletterController@getIndex');
        Route::get('newsletters/add', 'Admin\NewsletterController@getAdd');
        Route::post('newsletters/add', 'Admin\NewsletterController@postAdd');
        Route::post('newsletters/delete', 'Admin\NewsletterController@postDelete');

        //---------------------- Newsletters ------------------------------------
        Route::get('msgs', 'Admin\MsgController@getIndex');
        Route::get('msgs/add', 'Admin\MsgController@getAdd');
        Route::post('msgs/add', 'Admin\MsgController@postAdd');
        Route::post('msgs/delete', 'Admin\MsgController@postDelete');


        //---------------------- Newsletters SMS ------------------------------------
        Route::get('newsletters-sms', 'Admin\NewsletterSmsController@getIndex');
        Route::get('newsletters-sms/add', 'Admin\NewsletterSmsController@getAdd');
        Route::post('newsletters-sms/add', 'Admin\NewsletterSmsController@postAdd');
        Route::post('newsletters-sms/delete', 'Admin\NewsletterSmsController@postDelete');

        //---------------------- Email Presented ------------------------------------
        Route::get('email-presented', 'Admin\EmailPresentedController@getIndex');
        Route::get('email-presented/add', 'Admin\EmailPresentedController@getAdd');
        Route::post('email-presented/add', 'Admin\EmailPresentedController@postAdd');
        Route::post('email-presented/delete', 'Admin\EmailPresentedController@postDelete');

        //---------------------- Private Messages ------------------------------------
        Route::get('pm', 'Admin\PrivateMessagesController@getIndex');
        Route::get('pm/inbox', 'Admin\PrivateMessagesController@getInbox');
        Route::get('pm/outbox', 'Admin\PrivateMessagesController@getOutbox');
        Route::get('pm/send', 'Admin\PrivateMessagesController@getSend');
        Route::post('pm/send', 'Admin\PrivateMessagesController@postSend');
        Route::get('pm/edit/{id}', 'Admin\PrivateMessagesController@getEdit');
        Route::post('pm/edit/{id}', 'Admin\PrivateMessagesController@postEdit');
        Route::get('pm/replay/{id}', 'Admin\PrivateMessagesController@getReplay');
        Route::post('pm/replay/{id}', 'Admin\PrivateMessagesController@postReplay');
        Route::post('pm/delete', 'Admin\PrivateMessagesController@postDelete');
        Route::post('pm/user', 'Admin\PrivateMessagesController@postUser');

        //---------------------- Private Messages ------------------------------------
        Route::get('pm-reports', 'Admin\PrivateMessagesReportsController@getIndex');
        Route::post('pm-reports/delete', 'Admin\PrivateMessagesReportsController@postDelete');

        //--------------------- Skills -----------------------------
        Route::get('skill', 'Admin\SkillsController@getIndex');
        Route::get('skill/add', 'Admin\SkillsController@getAdd');
        Route::post('skill/add', 'Admin\SkillsController@postAdd');
        Route::get('skill/edit/{id}', 'Admin\SkillsController@getEdit');
        Route::post('skill/edit/{id}', 'Admin\SkillsController@postEdit');
        Route::post('skill/delete', 'Admin\SkillsController@postDelete');

        //--------------------- Profile Comments -----------------------------
        Route::get('profile-comment', 'Admin\ProfileCommentController@getIndex');
        Route::get('profile-comment/edit/{id}', 'Admin\ProfileCommentController@getEdit');
        Route::post('profile-comment/edit/{id}', 'Admin\ProfileCommentController@postEdit');
        Route::post('profile-comment/delete', 'Admin\ProfileCommentController@postDelete');

        //--------------------- Logs -----------------------------
        Route::get('logs', 'Admin\LogsController@getIndex');

    });
});

Route::group(array('prefix' => config('site.crm')), function () {

    Route::group(array('middleware' => 'CrmPermission'), function () {
        //--------------------- Support -----------------------------
        Route::get('support', 'Crm\SupportController@getIndex');
        Route::get('support/close/{id}', 'Crm\SupportController@getClose');
        Route::get('support/view/{id}', 'Crm\SupportController@getView');
        Route::post('support/view/{id}', 'Crm\SupportController@postView');
        Route::post('support/ticket', 'Crm\SupportController@postTicket');

        //--------------------- Core message -----------------------------
        Route::get('core-msg', 'Crm\CoreMessageController@getIndex');
        Route::get('core-msg/close/{id}', 'Crm\CoreMessageController@getClose');
        Route::get('core-msg/view/{id}', 'Crm\CoreMessageController@getView');
        Route::post('core-msg/view/{id}', 'Crm\CoreMessageController@postView');
        Route::post('core-msg/ticket', 'Crm\CoreMessageController@postTicket');

        //--------------------- Profile Edit -----------------------------
        Route::get('profile/edit', 'Crm\ProfileController@getEdit');
        Route::post('profile/edit', 'Crm\ProfileController@postEdit');
        Route::post('profile/pro', 'Crm\ProfileController@postPro');
        Route::post('profile/pass', 'Crm\ProfileController@postPass');
        Route::post('profile/comment', 'Crm\ProfileController@postComment');

        //---------------------- Private Messages ------------------------------------
        Route::get('pm/inbox', 'Crm\PrivateMessagesController@getInbox');
        Route::get('pm/outbox', 'Crm\PrivateMessagesController@getOutbox');
        Route::get('pm/send/{id?}', 'Crm\PrivateMessagesController@getSend');
        Route::post('pm/send', 'Crm\PrivateMessagesController@postSend');
        Route::get('pm/replay/{type}/{id}', 'Crm\PrivateMessagesController@getReplay');
        Route::post('pm/replay/{id}', 'Crm\PrivateMessagesController@postReplay');
        Route::post('pm/delete', 'Crm\PrivateMessagesController@postDelete');
        Route::get('pm/user/{user_id?}', 'Crm\PrivateMessagesController@getUser');

        //--------------------- Projects -----------------------------
        Route::get('project', 'Crm\ProjectController@getIndex');
        Route::post('project/add', 'Crm\ProjectController@postAdd');
        Route::get('project/view/{id}', 'Crm\ProjectController@getView');
        Route::get('project/edit/{id}', 'Crm\ProjectController@getEdit');
        Route::post('project/user-ajax', 'Crm\ProjectController@postUserAjax');

    });
});
