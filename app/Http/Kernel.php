/**
* The application's route middleware.
*
* @var array
*/
protected $routeMiddleware = [
    'auth:admin' => \App\Http\Middleware\AuthenticateAdmin::class,
];
