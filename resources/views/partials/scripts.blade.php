<script>
    function openEditModal(id, title, body) {
        $('#editPostId').val(id);
        $('#editPostTitle').val(title);
        $('#editPostBody').val(body);
        $('#openeditPostModal').modal('show');
    }

    // For create the posts 
    $(document).ready(function () {
        $('#savePostBtn').on('click', function () {
            console.log('i am here');
            var title = $('#postTitle').val();
            var body = $('#postBody').val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/create-post',
                type: 'POST',
                data: {
                    _token: _token,
                    title: title,
                    body: body
                },
                success: function (response) {
                    Toastify({
                        text: "Post saved successfully!",
                        duration: 3000,
                        backgroundColor: "green",
                        close: true
                    }).showToast();
                    var newRow = `
                        <tr id="postRow-${response.post.id}" data-id="${response.post.id}">
                            <td>${response.post.title}</td>
                            <td>${response.post.body}</td>
                            <td>
                               <button class="btn btn-info btn-sm" onclick="openEditModal(${response.post.id}, '${response.post.title}', '${response.post.body}')">Edit</button>
                                <button class="btn btn-danger btn-sm deletePostBtn" data-id="${response.post.id}">Delete</button>
                            </td>
                        </tr>
                   `;
                    $('#noPostsRow').hide();
                    $('#noPostsRow').hide();
                    $('table tbody').append(newRow);
                    $('#addPostModal').modal('hide');
                    $('#postTitle').val('');
                    $('#postBody').val('');
                },
                error: function (xhr) {
                    Toastify({
                        text: "Failed to save post.",
                        duration: 3000,
                        backgroundColor: "red",
                        close: true
                    }).showToast();
                }
            });
        });

        $('#updatePostBtn').on('click', function () {
            var id = $('#editPostId').val();
            var title = $('#editPostTitle').val();
            var body = $('#editPostBody').val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/update-post',
                type: 'PUT',
                data: {
                    _token: _token,
                    id: id,
                    title: title,
                    body: body
                },
                success: function (response) {
                    Toastify({
                        text: "Post updated successfully!",
                        duration: 3000,
                        backgroundColor: "green",
                        close: true
                    }).showToast();
                    $('#openeditPostModal').modal('hide');

                    updateTableRow(id, title, body);
                },
                error: function (xhr) {
                    Toastify({
                        text: "Failed to update post.",
                        duration: 3000,
                        backgroundColor: "red",
                        close: true
                    }).showToast();
                }
            });
        });

        function updateTableRow(id, title, body) {
            console.log('Updating data for ID:', id);
            var row = $(`tr[data-id="${id}"]`);
            if (row.length > 0) {
                row.find('td').eq(0).text(title);
                row.find('td').eq(1).text(body);
            } else {
                console.error('Row not found for ID:', id);
            }
        }

    });

    // delete the post
    $(document).on('click', '.deletePostBtn', function () {
        var id = $(this).data('id'); // Get the ID from the button's data attribute

        var _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/delete-post/' + id,
            type: 'DELETE',
            data: {
                _token: _token
            },
            success: function (response) {
                Toastify({
                    text: "Post deleted successfully!",
                    duration: 3000,
                    backgroundColor: "green",
                    close: true
                }).showToast();

                // Remove the table row with the given ID
                removeTableRow(id);

                // Optionally, check if the table is empty and show a message if needed
                checkIfTableIsEmpty();
            },
            error: function (xhr) {
                Toastify({
                    text: "Failed to delete post.",
                    duration: 3000,
                    backgroundColor: "red",
                    close: true
                }).showToast();
            }
        });
    });

    function removeTableRow(id) {
        $('#postRow-' + id).remove();
    }

    function checkIfTableIsEmpty() {
        var $tbody = $('#postsTable tbody');
        var $rows = $tbody.find('tr').not('#noPostsRow');
        console.log('Number of rows excluding "No Posts":', $rows.length);

        if ($rows.length === 0) {
            $('#noPostsRow').show();
        } else {
            $('#noPostsRow').hide();
        }
    }


    //  comment on post 
    function toggleComments(postId) {
        var commentsSection = $('#post' + postId);
        commentsSection.toggleClass('d-none');
    }

    function submitComment(postId) {
        var commentText = $('#comment-input-' + postId).val();
        var _token = $('meta[name="csrf-token"]').attr('content');

        if (commentText.trim() === '') {
            alert('Comment cannot be empty!');
            return;
        }

        $.ajax({
            url: '/comments',
            type: 'POST',
            data: {
                _token: _token,
                post_id: postId,
                comment: commentText
            },
            success: function (response) {
                var newComment = `
                    <div class="comment mb-3 p-2 border rounded">
                        <div class="comment-header mb-1">
                            <strong>${response.user_name}</strong>
                        </div>
                        <p>${response.comment}</p>
                        <button class="btn btn-link like-btn" onclick="toggleLike(${response.comment_id}, this)">
                            ${response.user_liked ? '<span class="text-danger">Unlike</span>' : '<span class="text-success">Like</span>'}
                            <span class="like-count">(${response.likes_count})</span>
                        </button>
                    </div>
                `;
                $('#post' + postId + ' .comment-input').before(newComment);
                $('#comment-input-' + postId).val('');
            },
            error: function (xhr) {
                alert('Failed to add comment.');
            }
        });
    }

    function toggleLike(commentId, button) {
        var _token = $('meta[name="csrf-token"]').attr('content');
        var likeButton = $(button);
        var isLiked = likeButton.find('span.text-danger').length > 0;

        $.ajax({
            url: isLiked ? '/comments/unlike' : '/comments/like',
            type: 'POST',
            data: {
                _token: _token,
                comment_id: commentId
            },
            success: function (response) {
                if (isLiked) {
                    likeButton.html(`
                        <span class="text-success">Like</span>
                        <span class="like-count">(${response.likes_count})</span>
                    `);
                } else {
                    likeButton.html(`
                        <span class="text-danger">Unlike</span>
                        <span class="like-count">(${response.likes_count})</span>
                    `);
                }
            },
            error: function (xhr) {
                alert('Failed to update like status.');
            }
        });
    }
    $(document).ready(function () {
        $('.toggle-comments-btn').on('click', function () {
            var postId = $(this).data('post-id');
            var commentsContainer = $('#post' + postId);
            var isHidden = commentsContainer.hasClass('d-none');

            if (isHidden) {
                commentsContainer.removeClass('d-none');
                $(this).text('Hide Comments');
            } else {
                commentsContainer.addClass('d-none');
                $(this).text('Show Comments');
            }
        });
    });

    
</script>