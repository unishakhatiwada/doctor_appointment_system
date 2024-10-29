@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center text-primary bg-primary mb-4">
        <h2>Pages</h2>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Button to open the Create Page modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createPageModal"
                    onclick="openCreatePageModal()">
                Create Page
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($pages->isEmpty())
            <div class="alert alert-info">No pages available. Click "Create Page" to add new items.</div>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Content</th>
                    <th scope="col">Date</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>{{ $page->content }}</td>
                        <td>{{ $page->date }}</td>
                        <td>{{ $page->img }}</td>
                        <td>
                            <!-- Edit button with page data attributes -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#createPageModal"
                                    onclick="openEditPageModal({{ $page->id }}, '{{ $page->title }}', '{{ $page->slug }}', '{{ $page->content }}', '{{ $page->date }}')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            @include('components.action-button', [
                                'url' => route('admin.pages.index') . '/',
                                'data' => $page,
                                'buttons' => [
                                    'view' => false,
                                    'edit' => false,
                                    'delete' => true,
                                    'download' => false,
                                ]
                            ])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Include the Create Page Modal -->
    @include('menu.modals.pages.create')
@endsection

<script>
    function openCreatePageModal() {
        const pageForm = document.getElementById('pageForm');
        pageForm.action = "{{ route('admin.pages.store') }}";  // Use store route for creating
        pageForm.querySelector('input[name="_method"]').value = 'POST'; // Set method to POST
        document.getElementById('createPageModalLabel').textContent = 'Create Page';
        document.getElementById('pageTitle').value = '';
        document.getElementById('pageSlug').value = '';
        document.getElementById('pageContent').value = '';
        document.getElementById('pageDate').value = '';
        pageForm.querySelector('button[type="submit"]').textContent = 'Save Page';
    }

    function openEditPageModal(pageId, title, slug, content, date) {
        const pageForm = document.getElementById('pageForm');
        pageForm.action = `{{ url('admin/pages') }}/${pageId}`;  // Set action URL for update
        pageForm.querySelector('input[name="_method"]').value = 'PUT'; // Set method to PUT for update
        document.getElementById('createPageModalLabel').textContent = 'Edit Page';
        document.getElementById('pageTitle').value = title;
        document.getElementById('pageSlug').value = slug;
        document.getElementById('pageContent').value = content;
        document.getElementById('pageDate').value = date;
        pageForm.querySelector('button[type="submit"]').textContent = 'Update Page';
    }
</script>
