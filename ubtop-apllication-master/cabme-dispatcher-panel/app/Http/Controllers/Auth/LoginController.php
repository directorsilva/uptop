<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DispatcherUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

    */


    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()

    {

        $this->middleware('guest')->except('logout');

    }

    /*public function login(Request $request)
    {
        $password = md5($request->get('password'));
        $email = $request->get('email');

        $checkUser = DispatcherUser::where('email', $email)->first();

        if (!empty($checkUser)) {
            $checkaccount = DispatcherUser::where('email', $email)->where('status', 'yes')->first();

            if (!empty($checkaccount)) {

                $row = $checkaccount->toArray();

                if ($row['password'] == $password) {

                    Auth::login($checkaccount, true);
                    return redirect('/dashboard');

                } else {
                    return redirect('login')->withErrors(
                        ['errors' => 'Password is incorrect!']
                    );
                }
            } else {
                return redirect('login')->withErrors(
                    ['errors' => 'Your account is not activated, please contact to administartor']
                );
            }

        } else {

            return redirect('login')->withErrors(
                ['errors' => 'Email id is incorrect!']
            );


        }
    } */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Check if user is active
        $user = DispatcherUser::where('email', $request->email)->first();
        if ($user && $user->status!='yes') {
            //abort(403, 'Your account has been disabled by an administrator.');
             throw ValidationException::withMessages([$this->username() => __('User account has been deactivated.')]);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
