{{-- resources/views/modules/index.blade.php --}}
@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center text-primary bg-primary mb-4">
        <h2>Modules</h2>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Button to open the Create Module modal --}}
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModuleModal">
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
                            {{-- Include action buttons --}}
                            @include('components.action-button', [
                                'url' => route('module.index') . '/',
                                'data' => $module,
                                'buttons' => [
                                    'view' => false,
                                    'edit' => true,
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

    @include('menu.modals.module.create')
@endsection
