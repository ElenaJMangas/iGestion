<?php

// Auth
Route::get('auth/login', [
    'as' => 'login',
    'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', [
    'as' => 'logout',
    'uses' => 'Auth\AuthController@getLogout'
]);

// Reset Password
Route::get('auth/password/reset', [
    'as' => 'password.request',
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('auth/password/email', [
    'as' => 'password.email',
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('auth/password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'Auth\ResetPasswordController@showResetForm'
]);
Route::post('auth/password/reset', 'Auth\ResetPasswordController@reset');

// Index
Route::get('/', [
    'as' => 'index',
    'uses' => 'DashboardController@index'
])->middleware('auth');

// Calendar
Route::middleware(['auth'])->group(function () {
    Route::get('/calendar', [
        'as' => 'calendar',
        'uses' => 'CalendarController@index'
    ]);
    Route::post('/event/{id?}', [
        'as' => 'event.save',
        'uses' => 'CalendarController@save'
    ])->where(['id' => '[0-9]+']);
    Route::get('/event/{id}', [
        'as' => 'event.detail',
        'uses' => 'CalendarController@detail'
    ])->where(['id' => '[0-9]+']);
    Route::post('/event/drop/{id}/{start}', [
        'as' => 'event.drop',
        'uses' => 'CalendarController@drop'
    ])->where(['id' => '[0-9]+']);
    Route::delete('/event/delete/{id}', [
        'as' => 'event.delete',
        'uses' => 'CalendarController@delete'
    ])->where(['id' => '[0-9]+']);
    Route::get('/events', [
        'as' => 'events',
        'uses' => 'CalendarController@get'
    ]);
    Route::get('/events/monthly', [
        'as' => 'events.month',
        'uses' => 'CalendarController@getMonthly'
    ]);
});

// Tasks
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [
        'as' => 'tasks',
        'uses' => 'TasksController@index'
    ]);
    Route::get('/tasks/create/{project_id?}', [
        'as' => 'task.form',
        'uses' => 'TasksController@form'
    ])->where(['project_id' => '[0-9]+']);
    Route::get('/tasks/{action}/{id}', [
        'as' => 'task',
        'uses' => 'TasksController@detail'
    ])->where(['action' => 'update|detail', 'id' => '[0-9]+']);
    Route::post('/tasks/', [
        'as' => 'task.create',
        'uses' => 'TasksController@create'
    ]);
    Route::put('/tasks/{id}', [
        'as' => 'task.update',
        'uses' => 'TasksController@update'
    ])->where(['id' => '[0-9]+']);
    Route::delete('/tasks/delete', [
        'as' => 'task.delete',
        'uses' => 'TasksController@delete'
    ]);
});

// Messages
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [
        'as' => 'messages',
        'uses' => 'MessagesController@index'
    ]);

    Route::get('/messages/getfolder/{folder}', [
        'as' => 'messages.getfolder',
        'uses' => 'MessagesController@getMessages'
    ])->where(['folder'=>'inbox|sent|draft|trash']);

    Route::get('/compose', [
        'as' => 'compose',
        'uses' => 'MessagesController@compose'
    ]);

    Route::post('/compose', [
        'as' => 'compose.reply',
        'uses' => 'MessagesController@reply'
    ]);

    Route::get('/message/{id}', [
        'as' => 'message',
        'uses' => 'MessagesController@detail'
    ])->where(['id' => '[0-9]+']);

    Route::post('/compose/send',[
       'as' => 'send',
        'uses' => 'MessagesController@send'
    ]);

    Route::post('/compose/draft',[
        'as' => 'draft',
        'uses' => 'MessagesController@draft'
    ]);

    Route::delete('/messages/delete', [
        'as' => 'messages.delete',
        'uses' => 'MessagesController@delete'
    ]);

});

// User Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/avatar', [
        'as' => 'profile.avatar',
        'uses' => 'UserController@avatar'
    ]);
    Route::put('/profile/avatar', [
        'as' => 'profile.update.avatar',
        'uses' => 'UserController@update_avatar'
    ]);
    Route::get('/profile/{id}', [
        'as' => 'profile',
        'uses' => 'UserController@profile'
    ])->where(['id' => '[0-9]+']);
    Route::get('/profile/update/{id}', [
        'as' => 'profile.update',
        'uses' => 'UserController@detailsProfile'
    ])->where(['id' => '[0-9]+']);
    Route::put('/profile/update/{id}', [
        'as' => 'profile.update',
        'uses' => 'UserController@save'
    ])->where(['id' => '[0-9]+']);
});

//Manager Account
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/user', [
        'as' => 'admin.user',
        'uses' => 'UserController@index'
    ]);
    Route::get('/admin/user/new/{id?}', [
        'as' => 'admin.user.new',
        'uses' => 'UserController@details']
    )->where(['id' => '[0-9]+']);
    Route::match(['post', 'put'], '/admin/user/new/{id?}', [
        'as' => 'admin.user.new',
        'uses' => 'UserController@save'
    ])->where(['id' => '[0-9]+']);
    Route::delete('/admin/user/delete/{id}', [
        'as' => 'admin.user.delete',
        'uses' => 'UserController@delete'
    ])->where(['id' => '[0-9]+']);
});

// Projects
Route::middleware(['auth'])->group(function () {
    Route::get('/projects', [
        'as' => 'projects',
        'uses' => 'ProjectController@index'
    ]);
    Route::get('/project/{id}', [
        'as' => 'project',
        'uses' => 'ProjectController@detail'
    ])->where(['id' => '[0-9]+']);
    Route::get('/project/update/{id?}', [
        'as' => 'project.update',
        'uses' => 'ProjectController@update'
    ])->where(['id' => '[0-9]+'])->middleware('admin');
    Route::match(['post', 'put'], '/project/update/{id?}', [
        'as' => 'project.save',
        'uses' => 'ProjectController@save'
    ])->where(['id' => '[0-9]+'])->middleware('admin');
    Route::get('/members/{id}', [
        'as' => 'members',
        'uses' => 'ProjectController@members'
    ])->where(['id' => '[0-9]+']);
});

// Users
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{id?}', [
        'as' => 'users',
        'uses' => 'UserController@getUsers'
    ]);
});

// Comments
Route::middleware(['auth'])->group(function () {
    Route::post('/comment/{id}', [
        'as' => 'comment',
        'uses' => 'CommentController@add'
    ])->where(['id' => '[0-9]+']);
    Route::post('/reply/{id}', [
        'as' => 'reply',
        'uses' => 'ReplyController@add'
    ])->where(['id' => '[0-9]+']);
    Route::delete('/comment/delete/{id}', [
        'as' => 'comment.delete',
        'uses' => 'CommentController@delete'
    ])->where(['id' => '[0-9]+']);
    Route::delete('/reply/delete/{id}', [
        'as' => 'reply.delete',
        'uses' => 'ReplyController@delete'
    ])->where(['id' => '[0-9]+']);
});

//Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [
        'as' => 'notifications',
        'uses' => 'NotificationsController@index'
    ]);
    Route::get('/notifications/count', [
        'as' => 'notifications.count',
        'uses' => 'NotificationsController@getNotRead'
    ]);
    Route::get('/notifications/list', [
        'as' => 'notifications.list',
        'uses' => 'NotificationsController@viewGetList'
    ]);
    Route::get('/notifications/read/{id}', [
        'as' => 'notifications.read',
        'uses' => 'NotificationsController@read'
    ])->where(['id' => '[0-9]+']);
});

//Change Language
Route::group(['middleware' => 'web'], function () {
    Route::get('switch-lang/{locale}', function ($locale) {
        Session::put('locale', $locale);
        return Redirect::back();
    })->where(['locale' => 'en|es'])->name('switch.lang');
});