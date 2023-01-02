<?php

//echo 'programmer' ;exit;


Route::get('refereshcapcha', function (){
    return 'here' ;
}) ;

//------------------------------ CRM --------------------------------------------------//


Route::group(array('prefix' => config('site.crm')), function () {


    Route::group(array('middleware' => 'CrmPermission'), function () {

        Route::post('scientific-add', 'Crm\HomeController@postScientificAdd');
    });
});


//------------------------------ ADMIN --------------------------------------------------//

Route::group(array('prefix' => config('site.admin')), function () {

    Route::group(array('middleware' => 'AdminPermission'), function () {

        //---------------------News-----------------------------
        Route::get('news', 'Admin\NewsController@getIndex');
        Route::get('news/add', 'Admin\NewsController@getAdd');
        Route::post('news/add', 'Admin\NewsController@postAdd');
        Route::get('news/edit/{id}', 'Admin\NewsController@getEdit');
        Route::post('news/edit/{id}', 'Admin\NewsController@postEdit');
        Route::post('news/delete', 'Admin\NewsController@postDelete');


        //---------------------Message-----------------------------
        Route::get('message', 'Admin\MessageController@getIndex');
        Route::get('message/close/{id}', 'Admin\MessageController@getClose');
        Route::get('message/view/{id}', 'Admin\MessageController@getView');
        Route::post('message/view/{id}', 'Admin\MessageController@postView');
        Route::post('message/delete', 'Admin\MessageController@postDelete');


        //---------------------Message-core-----------------------------
        Route::get('message-core', 'Admin\MessageCoreController@getIndex');
        Route::get('message-core/close/{id}', 'Admin\MessageCoreController@getClose');
        Route::get('message-core/view/{id}', 'Admin\MessageCoreController@getView');
        Route::post('message-core/view/{id}', 'Admin\MessageCoreController@postView');
        Route::post('message-core/delete', 'Admin\MessageCoreController@postDelete');


        //---------------------Delete-----------------------------
        Route::get('delete', 'Admin\DeleteController@getIndex');
        Route::get('delete/cancel-user/{id}', 'Admin\DeleteController@getCancelUser');
        Route::post('delete/user', 'Admin\DeleteController@postUser');
        Route::get('delete/view-user', 'Admin\DeleteController@getViewUser');


        Route::get('delete/view-help', 'Admin\DeleteController@getViewHelp');
        Route::post('delete/help', 'Admin\DeleteController@postHelp');
        Route::get('delete/cancel-help/{id}', 'Admin\DeleteController@getCancelHelp');


        Route::get('delete/view-scientific-category', 'Admin\DeleteController@getViewScientificCategory');
        Route::get('delete/cancel-scientific-category/{id}', 'Admin\DeleteController@getCancelScientificCategory');
        Route::post('delete/scientific-category', 'Admin\DeleteController@postScientificCategory');


        Route::get('delete/view-scientific', 'Admin\DeleteController@getViewScientific');
        Route::get('delete/cancel-scientific/{id}', 'Admin\DeleteController@getCancelScientific');
        Route::post('delete/scientific', 'Admin\DeleteController@postScientific');


        Route::get('delete/view-news', 'Admin\DeleteController@getViewNews');
        Route::get('delete/cancel-news/{id}', 'Admin\DeleteController@getCancelNews');
        Route::post('delete/news', 'Admin\DeleteController@postNews');

        //---------------------Rejected-----------------------------
        Route::get('rejected', 'Admin\RejectedController@getIndex');
        Route::get('rejected/edit/{id}', 'Admin\RejectedController@getEdit');
        Route::post('rejected/edit/{id}', 'Admin\RejectedController@postEdit');
        Route::post('rejected/delete', 'Admin\RejectedController@postDelete');

        //---------------------Setting-----------------------------
        Route::get('setting', 'Admin\SettingController@getIndex');
        Route::get('setting/edit/{id}', 'Admin\SettingController@getEdit');
        Route::post('setting/edit/{id}', 'Admin\SettingController@postEdit');

        //---------------------Email-----------------------------
        Route::get('email', 'Admin\EmailController@getIndex');
        Route::get('email/edit', 'Admin\EmailController@getEdit');
        Route::post('email/edit/{id}', 'Admin\EmailController@postEdit');

        //---------------------Help-----------------------------
        Route::get('help', 'Admin\HelpController@getIndex');
        Route::get('help/add', 'Admin\HelpController@getAdd');
        Route::post('help/add', 'Admin\HelpController@postAdd');
        Route::get('help/edit/{id}', 'Admin\HelpController@getEdit');
        Route::post('help/edit/{id}', 'Admin\HelpController@postEdit');
        Route::post('help/delete', 'Admin\HelpController@postDelete');

        //---------------------services-----------------------------
        Route::get('services', 'Admin\ServicesController@getIndex');
        Route::get('services/add', 'Admin\ServicesController@getAdd');
        Route::post('services/add', 'Admin\ServicesController@postAdd');
        Route::get('services/edit/{id}', 'Admin\ServicesController@getEdit');
        Route::post('services/edit/{id}', 'Admin\ServicesController@postEdit');
        Route::post('services/delete', 'Admin\ServicesController@postDelete');

        //---------------------uploader-----------------------------
        Route::get('uploader', 'Admin\UploaderController@getIndex');
        Route::get('uploader/add', 'Admin\UploaderController@getAdd');
        Route::post('uploader/add', 'Admin\UploaderController@postAdd');
        Route::get('uploader/edit/{id}', 'Admin\UploaderController@getEdit');
        Route::post('uploader/edit/{id}', 'Admin\UploaderController@postEdit');
        Route::post('uploader/delete', 'Admin\UploaderController@postDelete');

        //---------------------tab-----------------------------
        Route::get('tab', 'Admin\TabController@getIndex');
        Route::get('tab/add', 'Admin\TabController@getAdd');
        Route::post('tab/add', 'Admin\TabController@postAdd');
        Route::post('tab/sort', 'Admin\TabController@postSort');
        Route::get('tab/edit/{id}', 'Admin\TabController@getEdit');
        Route::post('tab/edit/{id}', 'Admin\TabController@postEdit');
        Route::post('tab/delete', 'Admin\TabController@postDelete');

        //---------------------under-menu-----------------------------
        Route::get('under-menu', 'Admin\UnderMenuController@getIndex');
        Route::get('under-menu/add', 'Admin\UnderMenuController@getAdd');
        Route::post('under-menu/add', 'Admin\UnderMenuController@postAdd');
        Route::post('under-menu/sort', 'Admin\UnderMenuController@postSort');
        Route::get('under-menu/edit/{id}', 'Admin\UnderMenuController@getEdit');
        Route::post('under-menu/edit/{id}', 'Admin\UnderMenuController@postEdit');
        Route::post('under-menu/delete', 'Admin\UnderMenuController@postDelete');

        //---------------------footer-tab-----------------------------
        Route::get('footer-tab', 'Admin\FooterTabController@getIndex');
        Route::get('footer-tab/add', 'Admin\FooterTabController@getAdd');
        Route::post('footer-tab/add', 'Admin\FooterTabController@postAdd');
        Route::post('footer-tab/sort', 'Admin\FooterTabController@postSort');
        Route::get('footer-tab/edit/{id}', 'Admin\FooterTabController@getEdit');
        Route::post('footer-tab/edit/{id}', 'Admin\FooterTabController@postEdit');
        Route::post('footer-tab/delete', 'Admin\FooterTabController@postDelete');

        //---------------------footer-under-menu-----------------------------
        Route::get('footer-under-menu', 'Admin\FooterUnderMenuController@getIndex');
        Route::get('footer-under-menu/add', 'Admin\FooterUnderMenuController@getAdd');
        Route::post('footer-under-menu/add', 'Admin\FooterUnderMenuController@postAdd');
        Route::post('footer-under-menu/sort', 'Admin\FooterUnderMenuController@postSort');
        Route::get('footer-under-menu/edit/{id}', 'Admin\FooterUnderMenuController@getEdit');
        Route::post('footer-under-menu/edit/{id}', 'Admin\FooterUnderMenuController@postEdit');
        Route::post('footer-under-menu/delete', 'Admin\FooterUnderMenuController@postDelete');

        //---------------------capacity-----------------------------
        Route::get('capacity', 'Admin\CapacityController@getIndex');
        Route::get('capacity/add', 'Admin\CapacityController@getAdd');
        Route::post('capacity/add', 'Admin\CapacityController@postAdd');
        Route::get('capacity/edit/{id}', 'Admin\CapacityController@getEdit');
        Route::post('capacity/edit/{id}', 'Admin\CapacityController@postEdit');
        Route::post('capacity/delete', 'Admin\CapacityController@postDelete');

        //---------------------banner-----------------------------
        Route::get('banner', 'Admin\BannerController@getIndex');
        Route::get('banner/add', 'Admin\BannerController@getAdd');
        Route::post('banner/add', 'Admin\BannerController@postAdd');
        Route::get('banner/edit/{id}', 'Admin\BannerController@getEdit');
        Route::post('banner/edit/{id}', 'Admin\BannerController@postEdit');
        Route::post('banner/delete', 'Admin\BannerController@postDelete');

        //---------------------service-network-----------------------------
        Route::get('service-network', 'Admin\ServiceNetworkController@getIndex');
        Route::get('service-network/add', 'Admin\ServiceNetworkController@getAdd');
        Route::post('service-network/add', 'Admin\ServiceNetworkController@postAdd');
        Route::get('service-network/edit/{id}', 'Admin\ServiceNetworkController@getEdit');
        Route::post('service-network/edit/{id}', 'Admin\ServiceNetworkController@postEdit');
        Route::post('service-network/delete', 'Admin\ServiceNetworkController@postDelete');

        //---------------------page-----------------------------
        Route::get('page', 'Admin\PageController@getIndex');
        Route::get('page/add', 'Admin\PageController@getAdd');
        Route::post('page/add', 'Admin\PageController@postAdd');
        Route::get('page/edit/{id}', 'Admin\PageController@getEdit');
        Route::post('page/edit/{id}', 'Admin\PageController@postEdit');
        Route::post('page/delete', 'Admin\PageController@postDelete');

        //---------------------logo-----------------------------
        Route::get('logo', 'Admin\LogoController@getIndex');
        Route::get('logo/add', 'Admin\LogoController@getAdd');
        Route::post('logo/add', 'Admin\LogoController@postAdd');
        Route::get('logo/edit/{id}', 'Admin\LogoController@getEdit');
        Route::post('logo/edit/{id}', 'Admin\LogoController@postEdit');
        Route::post('logo/delete', 'Admin\LogoController@postDelete');

        //---------------------category-----------------------------
        Route::get('category', 'Admin\CategoryController@getIndex');
        Route::get('category/add', 'Admin\CategoryController@getAdd');
        Route::post('category/add', 'Admin\CategoryController@postAdd');
        Route::get('category/edit/{id}', 'Admin\CategoryController@getEdit');
        Route::post('category/edit/{id}', 'Admin\CategoryController@postEdit');
        Route::post('category/delete', 'Admin\CategoryController@postDelete');
        Route::post('category/sort', 'Admin\CategoryController@postSort');

        //---------------------branch-----------------------------
        Route::get('branch', 'Admin\BranchController@getIndex');
        Route::get('branch/add', 'Admin\BranchController@getAdd');
        Route::post('branch/add', 'Admin\BranchController@postAdd');
        Route::get('branch/edit/{id}', 'Admin\BranchController@getEdit');
        Route::post('branch/edit/{id}', 'Admin\BranchController@postEdit');
        Route::post('branch/delete', 'Admin\BranchController@postDelete');
        Route::post('branch/sort', 'Admin\BranchController@postSort');


        //---------------------credibility-----------------------------
        Route::get('credibility', 'Admin\CredibilityController@getIndex');
        Route::get('credibility/add', 'Admin\CredibilityController@getAdd');
        Route::post('credibility/add', 'Admin\CredibilityController@postAdd');
        Route::get('credibility/edit/{id}', 'Admin\CredibilityController@getEdit');
        Route::post('credibility/edit/{id}', 'Admin\CredibilityController@postEdit');
        Route::post('credibility/delete', 'Admin\CredibilityController@postDelete');
        Route::post('credibility/sort', 'Admin\CredibilityController@postSort');

        //---------------------state-----------------------------
        Route::get('state', 'Admin\StateController@getIndex');
        Route::get('state/add', 'Admin\StateController@getAdd');
        Route::post('state/add', 'Admin\StateController@postAdd');
        Route::get('state/edit/{id}', 'Admin\StateController@getEdit');
        Route::post('state/edit/{id}', 'Admin\StateController@postEdit');
        Route::post('state/delete', 'Admin\StateController@postDelete');
        Route::post('state/sort', 'Admin\StateController@postSort');

        //---------------------degree-----------------------------
        Route::get('degree', 'Admin\DegreeController@getIndex');
        Route::get('degree/add', 'Admin\DegreeController@getAdd');
        Route::post('degree/add', 'Admin\DegreeController@postAdd');
        Route::get('degree/edit/{id}', 'Admin\DegreeController@getEdit');
        Route::post('degree/edit/{id}', 'Admin\DegreeController@postEdit');
        Route::post('degree/delete', 'Admin\DegreeController@postDelete');

    });
});


Route::group(array('prefix' => config('site.out')), function () {
    Route::group(array('middleware' => 'OutPermission'), function () {

        //---------------------Message-----------------------------
        Route::get('message', 'Out\MessageController@getIndex');
        Route::get('message/close/{id}', 'Out\MessageController@getClose');
        Route::get('message/view/{id}', 'Out\MessageController@getView');
        Route::post('message/view/{id}', 'Out\MessageController@postView');
        Route::post('message/delete', 'Out\MessageController@postDelete');


        //---------------------Message-core-----------------------------
        Route::get('message-core', 'Out\MessageCoreController@getIndex');
        Route::get('message-core/close/{id}', 'Out\MessageCoreController@getClose');
        Route::get('message-core/view/{id}', 'Out\MessageCoreController@getView');
        Route::post('message-core/view/{id}', 'Out\MessageCoreController@postView');
        Route::post('message-core/delete', 'Out\MessageCoreController@postDelete');


    });
});



