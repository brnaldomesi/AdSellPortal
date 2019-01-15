<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Requests\Admin;

use App\Models\User;

class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (is_numeric(request()->segment(3))) {
            $uniqueEmailIsRequired = true;

            $user = User::find(request()->segment(3));
            if (!empty($user)) {
                if ($user->email == $this->email) {
                    $uniqueEmailIsRequired = false;
                }
            }

            return [
                //'gender_id'  => 'required|not_in:0',
                'name'         => 'required|min:2|max:100',
                'country_code' => 'sometimes|required|not_in:0',
                'email'        => ($uniqueEmailIsRequired) ? 'required|email|unique:'.config('permission.table_names.users', 'users').',email' : 'required|email',
                //'password'   => 'required|between:5,15',
            ];
        } else {
            return [
                //'gender_id'  => 'required|not_in:0',
                'name'         => 'required|min:2|max:100',
                'country_code' => 'sometimes|required|not_in:0',
                'email'        => 'required|email|unique:users,email',
                //'password'   => 'required|between:5,15',
            ];
        }
    }
}
