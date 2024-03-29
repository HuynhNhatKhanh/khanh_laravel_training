<?php
/**
 * User Repository
 *
 * PHP version 8
 *
 * @category  Repositorys
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Repositories\User;

use Carbon\Carbon;
use App\Models\User;
use Yajra\DataTables\DataTables;

/**
 * UserRepository class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class UserRepository implements UserRepositoryInterface
{
    private User $user;
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @param $user, $now
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y/m/d:H-i-s');
    }

    /**
     * Get all users that are not deleted.
     *
     * @return mixed
     */
    public function getAllUser($request)
    {
        $query = $this->user;
        if ($request->load == 'index') {
            $query = $query->where("is_delete", '=', 0);
            $query = $query->orderBy('id', 'desc')->get();
            $results = $query;
        }
        if ($request->load == 'search') {
            if (isset($request->name)) {
                $query = $query->where("name", "LIKE", '%' . $request->name . '%');
            }
            if (isset($request->email)) {
                $query = $query->where("email", "LIKE", '%' . $request->email . '%');
            }
            if (isset($request->role) && $request->role != 'default') {
                $query = $query->where("group_role", '=', $request->role);
            }
            if (isset($request->status) && $request->status != 'default') {
                $query = $query->where("is_active", '=', $request->status);
            }
            $query = $query->where("is_delete", '=', 0);
            $query = $query->orderBy('id', 'desc')->get();
            $results = $query;
        }
        return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($results) {
                        $xhtml = '<td class="text-center ">';
                        $xhtml .= '<button type="button" value="'. $results->id .'" class="rounded-circle btn btn-sm btn-info m-1 editbtn-user " title="Chỉnh sửa" data-id="'. $results->id .'"><i class="fas fa-pencil-alt"></i></button>';
                        $xhtml .= '<button type="button" class="rounded-circle btn btn-sm btn-danger m-1 btn-delete-user "title="Xoá" data-id="'. $results->id .'" ><i class="fas fa-trash-alt"></i> </button>';
                        $xhtml .= '<button class="rounded-circle btn btn-sm btn-dark m-1 btn-block-user" title="Khoá/Mở thành viên" data-id="'. $results->id .'" data-status="'.$results->is_active.'"><i class="fas fa-user-times"></i></button> </td>';
                        return $xhtml;
                    }
                )
                ->editColumn(
                    'group_role',
                    function ($results) {
                        return ucfirst($results->group_role);
                    }
                )
                ->editColumn(
                    'is_active',
                    function ($results) {
                        $results->is_active === 1 ? $status = 'Đang hoạt động' : $status = 'Tạm khóa';
                        return $status;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Create user
     *
     * @param $requestAll

     * @return mixed
     */
    public function store($requestAll)
    {
        $dataCreate = [
            'name' => $requestAll['name'],
            'email' => $requestAll['email'],
            'password' => bcrypt($requestAll['password']),
            'group_role' => $requestAll['group_role'],
            'is_active' => $requestAll['is_active'],
        ];
        return $this->user::create($dataCreate);
    }

    /**
     * Update user
     *
     * @param $id, $requestAll

     * @return mixed
     */
    public function edit($id, $requestAll)
    {
        $dataUpdate = [
            'name' => $requestAll['name'],
            'email' => $requestAll['email'],
            'password' => bcrypt($requestAll['password']),
            'group_role' => $requestAll['group_role'],
            'is_active' => $requestAll['is_active'],
        ];
        return $this->user::where('id', $id)->update($dataUpdate);
    }

    /**
     * Delte user
     *
     * @param $requestAll

     * @return mixed
     */
    public function delete($requestAll)
    {
        $requestAll['delete'] = ($requestAll['delete'] == 1) ? 0 : 1;
        return $this->user->where('id', $requestAll['id'])->update(['is_delete' => $requestAll['delete']]);
    }

    /**
     * Change status user
     *
     * @param $requestAll

     * @return mixed
     */
    public function status($requestAll)
    {
        $requestAll['status'] = ($requestAll['status'] == 1) ? 0 : 1;
        return $this->user->where('id', $requestAll['id'])->update(['is_active' => $requestAll['status']]);
    }

    /**
     * Get 1 user
     *
     * @param $requestAll

     * @return mixed
     */
    public function getUser($requestAll)
    {
        return $this->user->where('id', $requestAll['id'])->first();
    }

    /**
     * Login user
     *
     * @param $request

     * @return mixed
     */
    public function login($request)
    {
        $query = $this->user;
        $query = $query->where('email', $request->email);
        $query = $query->update([
            'last_login_at' => $this->now,
            'last_login_ip' => $request->ip(),
        ]);
        return $query;
    }
}
