<?php

namespace App\Exceptions;

use Throwable;
use App\Jobs\SendEmail;
use App\Mail\ExceptionOccured;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if($this->shouldReport($exception))
            $this->sendEmail();

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($this->isHttpException($exception)){
            if($request->expectsJson()){
                switch($exception->getStatusCode()) {
                    case 404:
                        return response()->error("Invalid request or url.", [], 404);
                    break;
                    case 500:
                        return response()->error("Internal server error. Please contact admin.", [], 500);
                    break;
                    case 429:
                        return response()->error("Too Many Attempts.", [], 429);
                    break;
                    default:
                        return $this->renderHttpException($exception);
                    break;
                }
            }
        }elseif($exception instanceof ModelNotFoundException){
            if($request->expectsJson())
                return response()->error($exception->getMessage(), [], 404);
        }
        
        return parent::render($request, $exception);
    }

    /**
     * Sends an email to the developer about the exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    private function sendEmail(\Exception $exception)
    {
        try{
            // Parse the exception
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($e);

            // Send exception email
            SendEmail::dispatchNow(['to' => env('SUPPORT_EMAIL'), 'content' => new ExceptionOccured($html)]);
        }catch(\Exception $ex){
            Log::error($ex->getMessage(), ['context' => 'Exception handler with code: ' . $ex->getCode()]);
        }
    }
}
