<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentLike;

class UserWithCommentLikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_users_with_comment_likes_and_total_likes_count()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create posts for users
        $post1 = Post::factory()->create(['user_id' => $user1->id]);
        $post2 = Post::factory()->create(['user_id' => $user2->id]);

        // Create comments on the posts
        $comment1 = Comment::factory()->create(['post_id' => $post1->id]);
        $comment2 = Comment::factory()->create(['post_id' => $post2->id]);

        // Create likes on the comments
        CommentLike::factory()->create(['comment_id' => $comment1->id, 'user_id' => $user1->id]);
        CommentLike::factory()->create(['comment_id' => $comment2->id, 'user_id' => $user2->id]);

        // Simulate an authenticated user
        $this->actingAs($user1, 'sanctum');

        // Call the method
        $response = $this->get('/user-with-likes');

        // Verify the response
        $response->assertStatus(200);
        $response->assertViewIs('pages.users-with-likes');
        $response->assertViewHas('users');

        $users = $response->viewData('users');

        $this->assertCount(2, $users);

        foreach ($users as $user) {
            $this->assertTrue($user->total_likes > 0);
        }
    }
}

