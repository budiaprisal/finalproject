@extends('layouts.app')
@push('script-head')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">EDIT</div>

                <div class="card-body">
                <form action="{{ route('forum.update',$forum->id) }}" method="POST">
                    {{ csrf_field() }}

                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <input type="text" name="judul" class="form-control" value="{{ $forum->judul }}">
                    </div>
                    {{-- <div class="form-group">
                        <textarea type="text" name="description" class="form-control" placeholder="deskripsi">{{ $forum->description }}</textarea>
                    </div> --}}
                    <textarea name="description" class="form-control my-editor">{!! old('description', $description??'') !!}</textarea>
                    <div class="form-group">
                        <select name="tags[]" multiple="multiple" class="form-control tags">
                            @foreach($tags as  $tag)
                            <option value="{{ $tag ->id}}">{{ $tag->name }} </option>
                                
                            @endforeach
                            </select>
                        </div>
                    <button type="submit" class="btn btn-success btn-block" >Submit</button>
                </form>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')   
<script type="text/javascript">
  


    $(".tags").select2().val({!! json_encode($forum->tags()->allRelatedIds()) !!}).trigger('change');
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
  
        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }
  
        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };
  
    tinymce.init(editor_config);

</script>
@endsection