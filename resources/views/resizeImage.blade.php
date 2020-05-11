@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Resize image</h1>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <strong>Original Image:</strong>
                    <br/>
                    <img src="storage/teste/original/{{ Session::get('imageName') }}" style="max-width: 600px"/>
                </div>
                <div class="col-md-4">
                    <strong>Thumbnail Image:</strong>
                    <br/>
                    <img src="storage/teste/thumbnail/{{ Session::get('imageName') }}" style="max-width: 600px"/>
                </div>
            </div>
        @endif

        <form action="{!! route('resizeimage2') !!}" enctype="multipart/form-data" method="post">
        <div class="row">
            <div class="col-md-4">
                <br/>
                <input type="text" name="title" class="form-control" placeholder="Add Title">
            </div>
            <div class="col-md-12">
                <br/>
                <input type="file" class="image" name="image">
            </div>
            <div class="col-md-12">
                <br/>
                <button type="submit" class="btn btn-success">Upload Image</button>
            </div>
        </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tamanho</th>
                        <th>Original</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($arrImg))
                    @foreach($arrImg as $img)
                    <tr>
                        <td>{!! $img["name"] !!}</td>
                        <td>{!! $img["size"] !!}</td>
                        <td>{!! $img["original"] !!}</td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection