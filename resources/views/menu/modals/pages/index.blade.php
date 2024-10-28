{{-- resources/views/pages/index.blade.php --}}
@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center text-primary bg-primary mb-4">
        <h2>Pages</h2>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createPageModal">
                Create Page
            </button>
        </div>

        {{-- Success Message --}}
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
                            {{-- Include action buttons --}}
                            @include('components.action-button', [
                                'url' => route('page.index'),
                                'data' => $page,
                                'buttons' => [
                                    'view' => false,
                                    'edit' => true,
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

    {{-- Include the Create Page Modal --}}
    @include('menu.modals.pages.create')
@endsection
