<?php

use Illuminate\Database\Eloquent\Custom\SessionResourceScope;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class SessionResourceScopeTest extends TestCase
{
    public function tearDown() {
        parent::tearDown();

        if ($container = m::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        m::close();
    }

    public function testApplyingScopeToABuilder()
    {
        $token = uniqid("");

        $request = m::mock('Illuminate\Http\Request');
        $builder = m::mock('Illuminate\Database\Eloquent\Builder');
        $model = m::mock('Illuminate\Database\Eloquent\Model');

        $request
            ->shouldReceive('bearerToken')
            ->once()
            ->andReturn($token);

        $model
            ->shouldReceive('getQualifiedSessionTokenColumn')
            ->once()
            ->andReturn('table.session_token');

        $builder
            ->shouldReceive('where')
            ->once()
            ->with('table.session_token', '=', $token);

        $scope = new SessionResourceScope($request);
        $scope->apply($builder, $model);
    }
}
