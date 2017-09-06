<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Comment;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use DB;
use App\Helpers\Helper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * User's List
     * @return type
     */
    public function index()
    {
        $users = User::all()->whereNotIn('id',1);

        $data = [
            'users' => $users
        ];

        return view('pages.admin.user.index', $data);
    }

    /**
     * User update avatar page
     * @return type
     */
    public function avatar()
    {
        return view('pages.user.avatar', array('user' => \Auth::user()));
    }

    /**
     * Update user's avatar
     * @param Request $request
     * @return type
     */
    public function update_avatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));

            $user = \Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return view('pages.user.avatar', array('user' => \Auth::user()));
    }

    /**
     * New user or update
     * @return type
     */
    public function details($user_id = NULL)
    {
        $roles = Role::pluck('name', 'id');
        $user = (!is_null($user_id)) ? User::find($user_id) : NULL;
        return view('pages.admin.user.new', compact('roles'))->with('user', $user);
    }

    /**
     * @param UserRequest $request
     * @param null $user_id
     * @return $this
     */
    public function save(UserRequest $request, $user_id = NULL)
    {
        $newUser = true;

        // New user
        if (is_null($user_id)) {
            $user = new User();
        } // Update user
        else {
            $newUser = false;
            $user = User::find($user_id);
        }

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->username = $request->input('username');
        $user->email = $request->input('email');

        if ($request->input('password') != '') {

            if (preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,40}/', $request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            } else {
                return \Redirect::back()->with('info', __('auth.not_password'))->withInput();
            }
        }

        $noProfile = ($request->has('role') && $request->has('enable'));
        if ($noProfile) {
            $user->role_id = $request->input('role');
            $user->enable = $request->input('enable') ? 1 : 0;
        }

        try {
            $user->save();
            if ($newUser) {
                $recipients = $user->getAdministrators();

                Notification::add(__('notification.new_user', ['user' => $user->getFullName()]), route('admin.user'), $user->notification_type, $user->id, $recipients, false);
            }

            if ($noProfile) {
                return \Redirect::route('admin.user')->with('success', __('general.userData.change_ok'))->withInput();
            } else {
                return \Redirect::route('profile', $user_id)->with('success', __('general.userData.change_ok'))->withInput();
            }
        } catch (QueryException $ex) {

            Helper::logExceptionSql($ex);
            if ($newUser) {
                return \Redirect::route('admin.user.new')->with('danger', __('general.userData.change_ko'))->withInput();
            } else {
                return \Redirect::route('profile.update', $user_id)->with('danger', __('general.userData.change_ko'))->withInput();
            }

        }
    }

    /**
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete($user_id)
    {
        if ($user_id == \Auth::user()->id) {
            return \Redirect::back()->with('danger', __('auth.forbidden'))->withInput();
        }

        $user = User::find($user_id);

        if (is_null($user)) {
            return \Redirect::back()->with('danger', __('general.user_not_found'))->withInput();
        }

        $user->delete();

        $recipients = $user->getAdministrators();

        Notification::add(__('notification.delete_user', ['user' => $user->getFullName()]), route('admin.user'), $user->notification_type, $user->id,$recipients,false );

        return \Redirect::back();

    }

    public function getUsers($id = null)
    {
        $users = User::select('id', DB::raw("CONCAT(CONCAT(name,' '),surname) AS display_name"))->whereNotIn('id', [\Auth::user()->id, 1]);
        if(!is_null($id)){
            $members = Member::whereProjectId($id)->get(['user_id']);
            $users->whereIn('id',$members);
        }

        return json_encode($users->get());
    }

    public function profile($user_id)
    {
        $user = User::findOrFail($user_id);
        $totalProjects = Member::whereUserId($user_id)->count();
        $totalDoneTasks = Task::whereDoneUserId($user_id)->count();
        $totalComments = Comment::whereUserId($user_id)->count();
        $totalReplies = Reply::whereUserId($user_id)->count();

        $data = [
            'user' => $user,
            'projects' => $totalProjects,
            'done' => $totalDoneTasks,
            'comments' => $totalComments + $totalReplies
        ];

        return view('pages.profile')->with($data);
    }

    /**
     * Update User profile
     * @param $user_id
     * @return $this
     */
    public function detailsProfile($user_id)
    {
        $user = User::find($user_id);
        return view('pages.user.update')->with('user', $user);
    }
}
