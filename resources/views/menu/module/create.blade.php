<div class="modal fade" id="moduleModal" tabindex="-1" role="dialog" aria-labelledby="moduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="moduleForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST"> <!-- Set default to POST for create -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moduleModalLabel">Create Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="moduleTitle">Title</label>
                        <input type="text" class="form-control" id="moduleTitle" name="title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Module</button>
                </div>
            </div>
        </form>
    </div>
</div>
