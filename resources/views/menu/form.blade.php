@extends('admin.layouts.app')
@php
    function requiredField($isRequired = false) {
        return $isRequired ? '<span class="text-danger">*</span>' : '';
    }
@endphp
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h2 class="text-primary text-center bg-primary">{{ isset($menuItem) ? 'Edit' : 'Create' }} Menu Item</h2>

        <form action="{{ isset($menuItem) ? route('menus.update', $menuItem->id) : route('menus.store') }}" method="POST">
            @csrf
            @if(isset($menuItem))
                @method('PUT')
            @endif

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title{!! requiredField(true) !!}</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title', $menuItem->title ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="display">Display{!! requiredField(true) !!}</label>
                        <select class="form-control" id="display" name="display">
                            <option value="visible" {{ (old('display', $menuItem->display ?? '') == 'visible') ? 'selected' : '' }}>Visible</option>
                            <option value="hidden" {{ (old('display', $menuItem->display ?? '') == 'hidden') ? 'selected' : '' }}>Hidden</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status{!! requiredField(true) !!}</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" {{ (old('status', $menuItem->status ?? '') == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (old('status', $menuItem->status ?? '') == 0) ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Parent Menu{!! requiredField(true) !!}</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">No Parent</option>
                            @foreach($menuItems as $item)
                                <option value="{{ $item->id }}" {{ (old('parent_id', $menuItem->parent_id ?? '') == $item->id) ? 'selected' : '' }}>
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Type{!! requiredField(true) !!}</label>
                        <select class="form-control" id="type" name="type" onchange="toggleTypeFields()">
                            <option value="module" {{ (old('type', $menuItem->type ?? '') == 'module') ? 'selected' : '' }}>Module</option>
                            <option value="page" {{ (old('type', $menuItem->type ?? '') == 'page') ? 'selected' : '' }}>Page</option>
                            <option value="external_link" {{ (old('type', $menuItem->type ?? '') == 'external_link') ? 'selected' : '' }}>External Link</option>
                        </select>
                    </div>

                    <!-- Module Selector with "Create Module" Button -->
                    <div id="moduleField" class="form-group" style="display: {{ (old('type', $menuItem->type ?? '') == 'module') ? 'block' : 'none' }};">
                        <label for="module_id">Select Module{!! requiredField(true) !!}</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control mr-2" id="module_id" onchange="setTypeId('module')">
                                <option value="">Select a Module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ (old('type_id', $menuItem->type_id ?? '') == $module->id) ? 'selected' : '' }}>
                                        {{ $module->title }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#moduleModal"
                                    onclick="openCreateModuleModal()">
                                Create Module
                            </button>
                        </div>
                    </div>

                    <!-- Page Selector with "Create Page" Button -->
                    <div id="pageField" class="form-group" style="display: {{ (old('type', $menuItem->type ?? '') == 'page') ? 'block' : 'none' }};">
                        <label for="page_id">Select Page{!! requiredField(true) !!}</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control mr-2" id="page_id" onchange="setTypeId('page')">
                                <option value="">Select a Page</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ (old('type_id', $menuItem->type_id ?? '') == $page->id) ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <!-- Button to open the Create Module modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createPageModal"
                                        onclick="openCreatePageModal()">
                                    Create Page
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- External Link Field -->
                    <div id="externalLinkField" class="form-group" style="display: {{ (old('type', $menuItem->type ?? '') == 'external_link') ? 'block' : 'none' }};">
                        <label for="external_link">External Link{!! requiredField(true) !!}</label>
                        <input type="url" class="form-control" id="external_link" name="external_link"
                               value="{{ old('external_link', $menuItem->external_link ?? '') }}" placeholder="https://example.com">
                    </div>

                    <div class="form-group">
                        <label for="order">Order{!! requiredField(true) !!}</label>
                        <input type="number" class="form-control" id="order" name="order"
                               value="{{ old('order', $menuItem->order ?? 0) }}">
                    </div>
                </div>
            </div>

            <!-- Hidden field to submit the correct type_id based on type selection -->
            <input type="hidden" id="type_id" name="type_id" value="{{ old('type_id', $menuItem->type_id ?? '') }}">

            <button type="submit" class="btn btn-primary mt-3">{{ isset($menuItem) ? 'Update' : 'Create' }} Menu Item</button>
            <a href="{{ route('menus.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Back to Menu Items
            </a>
        </form>
    </div>

    <!-- JavaScript to Handle Field Display Based on Type Selection -->
    <script>
        function toggleTypeFields() {
            const type = document.getElementById('type').value;

            document.getElementById('moduleField').style.display = (type === 'module') ? 'block' : 'none';
            document.getElementById('pageField').style.display = (type === 'page') ? 'block' : 'none';
            document.getElementById('externalLinkField').style.display = (type === 'external_link') ? 'block' : 'none';

            // Clear type_id if external link is selected
            if (type === 'external_link') {
                document.getElementById('type_id').value = '';
            }
        }

        // Set the type_id value based on selected type and id in module/page fields
        function setTypeId(type) {
            const typeIdField = document.getElementById('type_id');
            if (type === 'module') {
                typeIdField.value = document.getElementById('module_id').value;
            } else if (type === 'page') {
                typeIdField.value = document.getElementById('page_id').value;
            }
        }
        function openCreateModuleModal() {
            const moduleForm = document.getElementById('moduleForm');
            moduleForm.action = "{{ route('admin.modules.store') }}";  // Use store route for creating
            moduleForm.querySelector('input[name="_method"]').value = 'POST'; // Set method to POST
            document.getElementById('moduleModalLabel').textContent = 'Create Module';
            document.getElementById('moduleTitle').value = '';
            document.getElementById('moduleSlug').value = '';
            moduleForm.querySelector('button[type="submit"]').textContent = 'Save Module';
        }
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

        // Initialize fields on page load
        document.addEventListener('DOMContentLoaded', toggleTypeFields);
    </script>

    <!-- Include Modals for Creating Module and Page -->
    @include('menu.modals.module.create')
    @include('menu.modals.pages.create')
@endsection
