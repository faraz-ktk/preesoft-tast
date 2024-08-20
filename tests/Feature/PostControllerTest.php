<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_posts()
    {
        $response = $this->post('/create-post', [
            'title' => 'Sample Post',
            'body' => 'This is a sample post body.',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_create_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/create-post', [
            'title' => 'Sample Post',
            'body' => 'This is a sample post body.',
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Post created successfully!']);

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'title' => 'Sample Post',
            'body' => 'This is a sample post body.',
        ]);
    }

    /** @test */
    public function only_authenticated_users_can_update_posts()
    {
        $post = Post::factory()->create();

        $response = $this->put('/update-post', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_update_their_own_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->put('/update-post', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Post updated successfully!']);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ]);
    }

    /** @test */
    public function authenticated_users_cannot_update_posts_they_dont_own()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->put('/update-post', [
            'id' => $post->id,
            'title' => 'Unauthorized Update',
            'body' => 'This should not be updated.',
        ]);

        $response->assertStatus(403); // Assuming you have authorization middleware
    }

    /** @test */
    public function only_authenticated_users_can_delete_posts()
    {
        $post = Post::factory()->create();

        $response = $this->delete('/delete-post/' . $post->id);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_delete_their_own_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/delete-post/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Post deleted successfully.']);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    /** @test */
    public function authenticated_users_cannot_delete_posts_they_dont_own()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->delete('/delete-post/' . $post->id);

        $response->assertStatus(403); // Assuming you have authorization middleware
    }

    /** @test */
    public function only_authenticated_users_can_store_comments()
    {
        $post = Post::factory()->create();

        $response = $this->post('/comments', [
            'post_id' => $post->id,
            'comment' => 'This is a comment.',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_store_comments()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create();

        $response = $this->post('/comments', [
            'post_id' => $post->id,
            'comment' => 'This is a comment.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'comment' => 'This is a comment.',
            'user_name' => $user->name,
        ]);

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'comment' => 'This is a comment.',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function only_authenticated_users_can_like_comments()
    {
        $comment = Comment::factory()->create();

        $response = $this->post('/comments/like', [
            'comment_id' => $comment->id,
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_like_comments()
{
    $user = User::factory()->create();
    $comment = Comment::factory()->create();
    $this->actingAs($user);

    // Simulate liking the comment
    $response = $this->post('/comments/like', [
        'comment_id' => $comment->id,
    ]);

    // Check if the like was added
    $response->assertStatus(200);
    $response->assertJson(['likes_count' => $comment->likes()->count()]);
}


    /** @test */
    public function only_authenticated_users_can_unlike_comments()
    {
        $comment = Comment::factory()->create();

        // Add a like to the comment first
        CommentLike::factory()->create(['comment_id' => $comment->id]);

        $response = $this->post('/comments/unlike', [
            'comment_id' => $comment->id,
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_unlike_comments()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $comment = Comment::factory()->create();
        CommentLike::factory()->create(['comment_id' => $comment->id, 'user_id' => $user->id]);

        $response = $this->post('/comments/unlike', [
            'comment_id' => $comment->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['likes_count' => max($comment->likes_count - 1, 0)]);

        $this->assertDatabaseMissing('comment_likes', [
            'comment_id' => $comment->id,
            'user_id' => $user->id,
        ]);
    }
    

}
