<?php
use App\Models\Board;
use App\Models\User;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
require_once dirname(__DIR__) . '/bootstrap/app.php';

header('Content-Type: application/json; charset=utf-8');
$logger = new Logger('http');
$logger->pushHandler(new StreamHandler(dirname(__DIR__).'/storage/logs/http.log', Logger::INFO));
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$body = file_get_contents('php://input');
$status = 200;
try {
    if ($method === 'GET' && $path === '/') $response = ['app'=>'TaskBoard','routes'=>['GET /users','GET /boards','GET /health']];
    elseif ($method === 'GET' && $path === '/health') $response = ['status'=>'ok'];
    elseif ($method === 'GET' && $path === '/users') $response = User::all()->toArray();
    elseif ($method === 'GET' && $path === '/boards') $response = Board::all()->toArray();
    else { $status = 404; $response = ['error'=>'Not found']; }
} catch (Throwable $e) {
    $status = 500; $response = ['error'=>'Internal server error'];
    $logger->error('Application error', ['exception'=>$e->getMessage()]);
}
http_response_code($status);
$json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);
// Do not log Authorization/Cookie headers or raw request bodies containing secrets.
$logger->info('HTTP request', ['method'=>$method,'path'=>$path,'status'=>$status,'response_body'=>$json]);
echo $json;
