<?php

namespace Test;

use PDO;
use Mockery;
use PHPUnit_Framework_TestCase;
use Emeka\Candy\Model\GetEntity;
use Emeka\Candy\Model\FindEntity;
use Emeka\Candy\Model\SaveEntity;
use Emeka\Candy\Model\WhereEntity;
use Emeka\Candy\Model\DeleteEntity;

class TestEntity extends PHPUnit_Framework_TestCase
{
	
	public function testGetEntity()
	{
	    $dbConnMocked 	= Mockery::mock('PDO');
	    $statement 		= Mockery::mock('\PDOStatement');

	    $dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM users')->andReturn($statement);
	    $dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM jobs')->andReturn(false);
	    $statement->shouldReceive('execute');
	    $statement->shouldReceive('fetchAll')->with(PDO::FETCH_ASSOC);

	    $this->assertJson(GetEntity::all('users', $dbConnMocked));	      
	}

	public function testWhereEntity()
	{
	    $dbConnMocked 	= Mockery::mock('PDO');
	    $statement 		= Mockery::mock('\PDOStatement');

	    $dbConnMocked->shouldReceive('prepare')->with("SELECT * FROM users WHERE username = 'emeka'")->andReturn($statement);
	    $statement->shouldReceive('execute');
	    $statement->shouldReceive('fetchAll')->with(PDO::FETCH_ASSOC);

	    $this->assertJson(WhereEntity::where('username', 'emeka', 'users', $dbConnMocked));	      
	}

	public function testFindEntity()
	{
	    $dbConnMocked 	= Mockery::mock('PDO');
	    $statement 		= Mockery::mock('\PDOStatement');

	    $dbConnMocked->shouldReceive('prepare')->with('SELECT * FROM users WHERE id = 3')->andReturn($statement);
	    $statement->shouldReceive('execute');
	    $statement->shouldReceive('fetchAll')->with(PDO::FETCH_ASSOC);

	    $this->assertEquals(1, FindEntity::find( 3, 'users', $dbConnMocked));	      
	}

	public function testSaveEntity()
	{
		$mock = Mockery::mock('PDO');
		$mock->shouldReceive('save')
			->with()
			->once()
			->andReturn(true);
	}

	public function testDeleteEntity()
	{
		$mock = Mockery::mock('PDO');
		$mock->shouldReceive('delete')
			->with()
			->once()
			->andReturn(true);
	}

}