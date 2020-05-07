<?php
namespace App\Http\Controllers\Traits;
use Illuminate\Http\Request;

trait UserTrait
{

    public function set_complete_profile_rate()
    {
      $user = auth('api')->user();
      return $data = $user->job ? $user->job->getAllAttributes() : [];
      $complete_profile_rate = 0 ;

      if($data){
        $complete_profile_rate =  round(($data['count_not_empty']/$data['count_all']) * 100) ?? 0;
      }

      $user->update(['complete_profile_rate' => $complete_profile_rate]);
    }


    public function set_rate($user_id)
    {
      $user = \App\Models\User::find($user_id);
      $data = $user->rates ?? [];
      $rate = 0 ;

      if($data){
        $rate = $data->sum('rate');
      }

      $user->update(['rate' => $rate]);
    }

}
