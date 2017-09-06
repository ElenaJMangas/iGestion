<?php
// https://laravel-breadcrumbs.readthedocs.io/en/latest/

// Dashboard
Breadcrumbs::register('index', function ($breadcrumbs) {
    $breadcrumbs->push(__('titles.home'), route('index'));
});

//Calendar
Breadcrumbs::register('calendar', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.calendar'), route('calendar'));
});

//Tasks
Breadcrumbs::register('tasks', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.tasks'), route('tasks'));
});

Breadcrumbs::register('projects', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.projects'), route('projects'));
});

Breadcrumbs::register('project', function ($breadcrumbs, $id) {
    $project = \App\Models\Project::find($id);
    $breadcrumbs->parent('projects');
    $breadcrumbs->push($project->title, route('project', ['id' => $id]));
});

Breadcrumbs::register('task.form', function ($breadcrumbs, $project_id = null) {
    if (is_null($project_id)) {
        $breadcrumbs->parent('tasks');
    } else {
        $breadcrumbs->parent('project', $project_id);
    }

    $breadcrumbs->push(__('titles.taskForm'), route('task.form'));
});

Breadcrumbs::register('task', function ($breadcrumbs, $action, $id) {
    $task = \App\Models\Task::find($id);

    if (is_null($task->project_id)) {
        $breadcrumbs->parent('tasks');
    } else {
        $breadcrumbs->parent('project', $task->project_id);
    }

    $breadcrumbs->push($task->title, route('task', ['id' => $id, 'action' => $action]));
});

// Messages
Breadcrumbs::register('messages', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.messages'), route('messages'));
});

Breadcrumbs::register('compose', function ($breadcrumbs) {
    $breadcrumbs->parent('messages');
    $breadcrumbs->push(__('titles.compose'), route('compose'));
});

Breadcrumbs::register('message', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('messages');
    $breadcrumbs->push(__('general.message.read'), route('message',['id' => $id]));
});

// Notifications
Breadcrumbs::register('notifications', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.notifications'), route('notifications'));
});

// User's Profile
Breadcrumbs::register('profile', function ($breadcrumbs, $id) {
    $user = \App\Models\User::find($id);
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.profiles'));
    $breadcrumbs->push($user->getFullName(), route('profile',$id));
});

Breadcrumbs::register('profile.update', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('profile',$id);
    $breadcrumbs->push(__('titles.update'), route('profile.update',$id));
});

Breadcrumbs::register('profile.avatar', function ($breadcrumbs) {
    $breadcrumbs->parent('profile',\Auth::user()->id);
    $breadcrumbs->push(__('titles.avatar'), route('profile.avatar'));
});

// Manage Users
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push(__('titles.admin'));
});

Breadcrumbs::register('admin.user', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push(__('titles.users'), route('admin.user'));
});

Breadcrumbs::register('admin.user.new', function ($breadcrumbs, $id = null) {
    $breadcrumbs->parent('admin.user');
    if(is_null($id)){
        $breadcrumbs->push(__('titles.create'), route('admin.user.new'));
    }else{
        $user = \App\Models\User::find($id);
        $breadcrumbs->push($user->getFullName());
        $breadcrumbs->push(__('titles.update'), route('admin.user.new',$id));
    }
});

// Projects
Breadcrumbs::register('project.update', function ($breadcrumbs, $id = null) {

    if(is_null($id)){
        $breadcrumbs->parent('projects');
        $breadcrumbs->push(__('titles.create'), route('project.update'));
    }else{
        $breadcrumbs->parent('project',$id);
        $breadcrumbs->push(__('titles.update'), route('project.update',$id));
    }
});
