<div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostModalLabel">Add Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPostForm">
                    <div class="form-group">
                        <label for="postTitle">Title</label>
                        <input type="text" class="form-control" id="postTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="postBody">Body</label>
                        <textarea class="form-control" id="postBody" rows="3" required></textarea>
                    </div>
                    <button type="button" id="savePostBtn" class="btn btn-custom">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Post Modal -->
<div class="modal fade" id="openeditPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPostForm">
                    <input type="hidden" id="editPostId">
                    <div class="form-group">
                        <label for="editPostTitle">Title</label>
                        <input type="text" class="form-control" id="editPostTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="editPostBody">Body</label>
                        <textarea class="form-control" id="editPostBody" rows="3" required></textarea>
                    </div>
                    <button type="button" id="updatePostBtn" class="btn btn-custom">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

