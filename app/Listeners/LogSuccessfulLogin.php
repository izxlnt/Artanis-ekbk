<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Audit as ModelsAudit;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LogSuccessfulLogin
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Request $request)
  {
      $this->request = $request;
  }

  /**
   * Handle the event.
   *
   * @param  Login  $event
   * @return void
   */
  public function handle(Login $event)
  {

      // $data = [
      //     'auditable_id' => auth()->user()->id,
      //     'auditable_type' => "Logged In",
      //     'event'      => "Logged In",
      //     'url'        => request()->fullUrl(),
      //     'ip_address' => request()->getClientIp(),
      //     'user_agent' => request()->userAgent(),
      //     'created_at' => Carbon::now(),
      //     'updated_at' => Carbon::now(),
      //     'user_id'          => auth()->user()->id,
      // ];
      //
      // //create audit trail data
      // $details = Audit::create($data);

    $user = $event->user;
    if($user->status == 0){
        // dd($user);
        FacadesAuth::logout();
        return redirect()->route('login');
    }

    $data = [
       'auditable_id' => $user->id,
       'auditable_type' => get_class($event->user),
       'event'      => "Log Masuk",
       'url'        => $this->request->fullUrl(),
       'ip_address' => $this->request->getClientIp(),
       'user_agent' => $this->request->userAgent(),
       'created_at' => Carbon::now(),
       'updated_at' => Carbon::now(),
       'user_id'    => $user->id,
   ];

   //create audit trail data
   $details = ModelsAudit::create($data);
   // dd($details);
  }
}
