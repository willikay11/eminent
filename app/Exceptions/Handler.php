<?php

namespace App\Exceptions;

use eminent\Exceptions\AuthorizationFailedException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Rollbar\Rollbar;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationFailedException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if(getenv('APP_ENV') !== 'local' and $this->shouldReport($exception))
        {
            if(\Auth::user())
            {
                $user = [
                    'id' => \Auth::user()->id,
                    'email' => \Auth::user()->email
                ];
            }
            else
            {
                $user = [
                    'id' => 'guest',
                    'email' => 'guest'
                ];
            }

            $config = array(
                // required
                'access_token' => getenv('ROLLBAR_TOKEN'),
                // optional - environment name. any string will do.
                'environment' => getenv('APP_ENV'),
                // optional - path to directory your code is in. used for linking stack traces.
                'root' => base_path(),

                'person' => $user
            );

            Rollbar::init($config);
            Rollbar::report_exception($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        switch ($exception) {

            case($exception instanceof AuthorizationFailedException): {

                return back()->with('error',$exception->getMessage());

                break;
            }
        }

        return parent::render($request, $exception);
    }
}
