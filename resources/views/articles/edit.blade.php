@extends('layouts.app')

@section('content')

    <div class="container">
        {{-- @if ($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif --}}
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="id" class="form-control" value="{{ $article->id }}">
            <div class="mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }}">
            </div>
            
            <div class="mb-3">
                <label>Body</label>
                <textarea name="body" id="body" class="form-control" >{{ $article->body}}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="file">Choose Image</label>
                <input type="file" name="file" class="form-control" value="{{ $article->profile_image }}">
            </div>
            <input type="submit" value="Update Article" class="btn btn-primary">
        </form>
    </div>
@endsection