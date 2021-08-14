<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny("Bạn không có quyền xem",401);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Student $student)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền xem');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền tạo');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Student $student)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền sửa');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Student $student)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền xóa');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Student $student)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền khôi phục');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Student $student)
    {
        foreach($user->roles as $role){
            if($role->name === 'Admin'){
                return Response::allow();
            }
        }
        return Response::deny('Bạn không có quyền xóa');
    }
}
