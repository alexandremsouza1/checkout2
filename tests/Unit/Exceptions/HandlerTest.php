<?php


use App\Exceptions\Handler;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class HandlerTest extends TestCase
{
    public function testSimpleException()
    {
        $container = $this->app->make(Container::class);
        $handler = new Handler($container);
        $request = $this->createRequest();
        $exception = new Exception('Test exception');

        $result = $handler->render($request, $exception);

        // Add your assertions here
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(500, $result->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'details' => null,
                'message' => 'Test exception',
                'status' => false
            ]),
            $result->getContent()
        );
    }

    public function testItauException()
    {
        $container = $this->app->make(Container::class);
        $handler = new Handler($container);
        $request = $this->createRequest();

 
        $response = new Response(new \GuzzleHttp\Psr7\Response(401, [], json_encode(['message' => 'Unauthorized'])));
        $exception = new RequestException($response);


        $result = $handler->render($request, $exception);

        // Add your assertions here
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(401, $result->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'details' => null,
                'message' => 'Unauthorized',
                'status' => false
            ]),
            $result->getContent()
        );
    }

    protected function createRequest()
    {
        // Create a mock of the request object
        // Implement the necessary logic based on your requirements
        // For example, you can use the following code:
        $request = $this->createMock(Request::class);

        return $request;
    }
}
