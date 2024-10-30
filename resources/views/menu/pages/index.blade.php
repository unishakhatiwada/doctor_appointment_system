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
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#createPageModal"
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
    @include('menu.pages.create')
@endsection
<script>
    function openCreatePageModal() {
        const pageForm = document.getElementById('pageForm');

        // Set the action URL to create a new page
        pageForm.action = "{{ route('admin.pages.store') }}";

        // Set method to POST for creating a new entry
        pageForm.querySelector('input[name="_method"]').value = 'POST';

        // Set modal title and button text for create mode
        document.getElementById('createPageModalLabel').textContent = 'Create Page';
        pageForm.querySelector('button[type="submit"]').textContent = 'Save Page';

        // Clear input fields for create mode
        document.getElementById('pageTitle').value = '';
        document.getElementById('pageContent').value = '';
        document.getElementById('pageDate').value = '';
    }

    function openEditPageModal(pageId, title, slug, content, date) {
        const pageForm = document.getElementById('pageForm');

        // Set the action URL to update the specific page
        pageForm.action = `{{ url('admin/pages') }}/${pageId}`;

        // Set method to PUT for updating the entry
        pageForm.querySelector('input[name="_method"]').value = 'PUT';

        // Set modal title and button text for edit mode
        document.getElementById('createPageModalLabel').textContent = 'Edit Page';
        pageForm.querySelector('button[type="submit"]').textContent = 'Update Page';

        // Populate form fields with existing data for edit mode
        document.getElementById('pageTitle').value = title;
        document.getElementById('pageContent').value = content;

        // Format date correctly to display in date input field
        document.getElementById('pageDate').value = new Date(date).toISOString().slice(0, 10);
    }
</script>
