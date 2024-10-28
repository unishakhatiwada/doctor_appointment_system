

<div class="modal fade" id="createPageModal" tabindex="-1" role="dialog" aria-labelledby="createPageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('page.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPageModalLabel">Create Page</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pageTitle">Title</label>
                        <input type="text" class="form-control" id="pageTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="pageSlug">Slug</label>
                        <input type="text" class="form-control" id="pageSlug" name="slug" required>
                    </div>
                    <div class="form-group">
                        <label for="pageContent">Content</label>
                        <textarea class="form-control" id="pageContent" name="content" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pageDate">Date</label>
                        <input type="date" class="form-control" id="pageDate" name="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Page</button>
                </div>
            </div>
        </form>
    </div>
</div>
