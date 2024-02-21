<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Supports\ResponseValidation;
use App\Validations\UserValidation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $user_service;

    public function __construct()
    {
        $this->user_service = new UserService;
    }

    /**
     * Get list user
     *
     * @param Request $request
     */
    public function get(Request $request)
    {
        $users = $this->user_service->get_list_paged($request);
        $count = $this->user_service->get_list_count($request);

        $data = [];
        $no = $request->start;

        foreach ($users as $user) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $user->name;
            $row[] = $user->email;
            $row[] = $user->role_name;
            $button = "<a href='" . \route("app.users.show", $user->id) . "' class='btn btn-info btn-sm m-1'>Detail</a>";
            if ($user->role_id != 1 || $user->id != \auth()->user()->id) {
                $button .= form_delete("formUser$user->id", route("app.users.destroy", $user->id));
            }
            $row[] = $button;
            $data[] = $row;
        }

        $output = [
            "draw" => $request->draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        ];

        return \response()->json($output, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view_admin("admin.users.index", "User Management", [], TRUE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            "roles" => Role::orderBy("role_name", "ASC")->get()
        ];
        return $this->view_admin("admin.users.create", "Tambah User", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $response = $this->user_service->store($request);
        return \response_json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            "user" => $user
        ];
        return $this->view_admin("admin.users.show", "Detail User", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            "user" => $user,
            "roles" => Role::orderBy("role_name", "ASC")->get()
        ];

        return $this->view_admin("admin.users.edit", "Edit User", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $response = $this->user_service->update($request, $user);
        return \response_json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $response = \response_success_default("Berhasil hapus user!", FALSE, \route("app.users.index"));
        return \response_json($response);
    }
}
