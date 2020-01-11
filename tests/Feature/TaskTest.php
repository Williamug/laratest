<?php

namespace Tests\Feature;

//use App\Task;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Illuminate\Support\Facades\Auth;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_read_all_the_tasks()
    {
        // given we have task in the database
        $task = factory('App\Task')->create();

        // when user visit the tasks page
        $response = $this->get('/tasks');

        // he should be able to read the task
        $response->assertSee($task->title);
    }

    /** @test */
    public function a_user_can_read_single_task()
    {
        // given we have task in the database
        $task = factory('App\Task')->create();

        // when user visit the task's URI
        $response = $this->get('/tasks/' . $task->id);

        // he can see the task details
        $response->assertSee($task->title)
            ->assertSee($task->description);
    }

    /** @test */
    public function authenticated_user_can_create_a_new_task()
    {
        // given we have an authenticated user
        $this->actingAs(factory('App\User')->create());

        // and a task object
        $task = factory('App\Task')->make();

        // when user submits a post request to create a task endpoint
        $this->post('/tasks/create', $task->toArray());

        // it gets stored in the database
        $this->assertEquals(1, Task::all()->count());
    }

    /** @test */
    public function unauthenticated_users_cannot_create_a_new_task()
    {
        // given we have a task object
        $task = factory('App\Task')->make();

        // when unauthenticated user submits a post request to create task endpoint
        // He should be redirected to login page
        $this->post('/tasks/create', $task->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_task_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());
        $task = factory('App\Task')->make(['title' => null]);
        $this->post('/tasks/create', $task->toArray())
            ->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_task_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());
        $task = factory('App\Task')->make(['description' => null]);
        $this->post('/tasks/create', $task->toArray())
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function authorized_user_can_update_the_task()
    {
        // give we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // and a task which is created by the user
        $task = factory('App\Task')->create(['user_id' => Auth::id()]);
        $task->title = 'Updated Title';

        // when the user hits the endpoint to update the task
        $this->put('/tasks/' . $task->id, $task->toArray());

        // the task should be updated in the database
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function unauthorized_user_cannot_update_the_task()
    {
        // given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // and a task which is not created by the user
        $task = factory('App\Task')->create();
        $task->title = 'Update Title';

        // when the user hits the endpoint to update the task
        $response = $this->put('/tasks/' . $task->id, $task->toArray());

        // we should expect a 403 error
        $response->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_the_task()
    {
        // given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // and a task which is created by the user
        $task = factory('App\Task')->create(['user_id' => Auth::id()]);

        // when the user hits the endpoint to delete the task
        $this->delete('/tasks/' . $task->id);

        // the task should be deleted from the database
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function unauthorized_user_cannot_delete_the_task()
    {
        // give we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // and a task which is not created by the user
        $task = factory('App\Task')->create();

        // when the user hits the endpoints to delete a task
        $response = $this->delete('/tasks/' . $task->id);

        // we should expect a 403 error
        $response->assertStatus(403);
    }
}
