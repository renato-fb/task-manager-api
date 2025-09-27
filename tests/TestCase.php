<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Make a JSON request to the application.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Laravel\Lumen\Testing\TestResponse
     */
    public function json($method, $uri, array $data = [], array $headers = [])
    {
        $content = json_encode($data);
        $headers = array_merge([
            'CONTENT_LENGTH' => mb_strlen($content, '8bit'),
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);

        return $this->call($method, $uri, [], [], [], $headers, $content);
    }

    /**
     * Make a GET request to the application.
     *
     * @param  string  $uri
     * @param  array  $headers
     * @return \Laravel\Lumen\Testing\TestResponse
     */
    public function getJson($uri, array $headers = [])
    {
        return $this->json('GET', $uri, [], $headers);
    }

    /**
     * Make a POST request to the application.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Laravel\Lumen\Testing\TestResponse
     */
    public function postJson($uri, array $data = [], array $headers = [])
    {
        return $this->json('POST', $uri, $data, $headers);
    }

    /**
     * Make a PUT request to the application.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Laravel\Lumen\Testing\TestResponse
     */
    public function putJson($uri, array $data = [], array $headers = [])
    {
        return $this->json('PUT', $uri, $data, $headers);
    }

    /**
     * Make a DELETE request to the application.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Laravel\Lumen\Testing\TestResponse
     */
    public function deleteJson($uri, array $data = [], array $headers = [])
    {
        return $this->json('DELETE', $uri, $data, $headers);
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null  $connection
     * @return $this
     */
    protected function assertDatabaseHas($table, array $data, $connection = null)
    {
        $this->assertTrue(
            $this->isInDatabase($table, $data, $connection),
            'Unable to find row in database table ['.$table.'] that matches attributes ['.json_encode($data).'].'
        );

        return $this;
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null  $connection
     * @return $this
     */
    protected function assertDatabaseMissing($table, array $data, $connection = null)
    {
        $this->assertFalse(
            $this->isInDatabase($table, $data, $connection),
            'Found unexpected row in database table ['.$table.'] that matches attributes ['.json_encode($data).'].'
        );

        return $this;
    }

    /**
     * Check if the given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null  $connection
     * @return bool
     */
    protected function isInDatabase($table, array $data, $connection = null)
    {
        $connection = $connection ?: $this->app['db']->getDefaultConnection();
        $count = $this->app['db']->connection($connection)->table($table)->where($data)->count();

        return $count > 0;
    }
}