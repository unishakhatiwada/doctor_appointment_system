
<div class="modal fade" id="createModuleModal" tabindex="-1" role="dialog" aria-labelledby="createModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('modules.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModuleModalLabel">Create Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="moduleTitle">Title</label>
                        <input type="text" class="form-control" id="moduleTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="moduleSlug">Slug</label>
                        <input type="text" class="form-control" id="moduleSlug" name="slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Module</button>
                </div>
            </div>
        </form>
    </div>
</div>
