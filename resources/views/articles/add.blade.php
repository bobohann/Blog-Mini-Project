@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif
        <form action="{{ route('article.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            
            <div class="form-group mb-3">
                <label for="body">Body</label>
                <textarea name="body" id="body" class="form-control"></textarea>
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
                <input type="file" name="file" class="form-control" onchange="previewFile(this)">
                <img id="preview" alt="profile image" style="max-height: 120;max-width:120px;margin-top:20px;">
            </div>

            <input type="submit" value="Add Article" class="btn btn-primary">
        </form>
    </div>
@endsection

@section('script')
    <script>
        function previewFile(input){
            var file=$("input[type=file]").get(0).files(0);

            if(file){
                var reader=new FileReader();
                reader.onload=function(){
                    $('#preview').attr("src",reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection