@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center text-primary bg-primary mb-4">
        <h2>Modules</h2>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Button to open the Create Module modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#moduleModal"
                    onclick="openCreateModuleModal()">
                Create Module
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($modules->isEmpty())
            <div class="alert alert-info">No modules available. Click "Create Module" to add new items.</div>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module->title }}</td>
                        <td>{{ $module->slug }}</td>
                        <td>
                            <!-- Edit button with module data attributes -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#moduleModal"
                                    onclick="openEditModuleModal({{ $module->id }}, '{{ $module->title }}', '{{ $module->slug }}')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            @include('components.action-button', [
                                'url' => route('admin.modules.index') . '/',
                                'data' => $module,
                                'buttons' => [
                                    'view' => false,
                                    'edit' => false,
                                    'delete' => true,
                                    'download' => false
                                ]
                            ])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Include the reusable modal component -->
    @include('menu.module.create')
@endsection
<script>
    function openCreateModuleModal() {
        const moduleForm = document.getElementById('moduleForm');
        moduleForm.action = "{{ route('admin.modules.store') }}";  // Use store route for creating
        moduleForm.querySelector('input[name="_method"]').value = 'POST'; // Set method to POST
        document.getElementById('moduleModalLabel').textContent = 'Create Module';
        document.getElementById('moduleTitle').value = '';
        document.getElementById('moduleSlug').value = '';
        moduleForm.querySelector('button[type="submit"]').textContent = 'Save Module';
    }

    function openEditModuleModal(moduleId, title, slug) {
        const moduleForm = document.getElementById('moduleForm');
        moduleForm.action = `{{ url('admin/modules') }}/${moduleId}`;  // Update URL for PUT
        moduleForm.querySelector('input[name="_method"]').value = 'PUT'; // Set method to PUT for update
        document.getElementById('moduleModalLabel').textContent = 'Edit Module';
        document.getElementById('moduleTitle').value = title;
        document.getElementById('moduleSlug').value = slug;
        moduleForm.querySelector('button[type="submit"]').textContent = 'Update Module';
    }
</script>
