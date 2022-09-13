@php
    $nameField = FCHelper::er($table,'name');
    $noteName = FCHelper::ep($table,'note');
    $defaultData =  json_decode($table->default_data, true);
    $dataPivots = [];
    if(is_array($defaultData) && is_object($dataItem)){
        $pivotTable = $defaultData['pivot_childs'];
        $originField = $defaultData['origin_field'];
        $field_map = $defaultData['field_map'];
        $targetTable = $defaultData['target_table'];
        $targetField = $defaultData['target_field'];
        $targetSelect = $defaultData['target_select'];
        $select_childs = $defaultData['select_childs'];
        $target_select = $defaultData['target_select'];
        $table = $defaultData['table'];
        $columns = [];
        $dataPivots = FCHelper::getDataPivotChaper($table, $select_childs, $field_map, $dataItem, $pivotTable, $originField, $targetField, $targetTable, $target_select);
    }
@endphp
<div class="group-form {{ $nameField }}">
    <p class="form-title" for="">{{$noteName}}</p>
    <textarea name="{{ $nameField }}" hidden></textarea>
    <div class="chapter-table">
        <div class="chapter">
            @foreach($dataPivots as $key => $data)
                <div class="chapter-item" data-id={{ Support::show($data,'id') }}>
                    <div class="group-form box-title-big-video-chapter">
                        <label class="title-big-video-chapter">Tên chương</label>
                        <input class="form-control" data-field="name" value="{{ Support::show($data,'name') }}" placeholder="Tên chương">
                    </div>
                    <div class="video">
                        <div class="group-form title-small-video-chapter">
                            <label>Danh sách video</label>
                        </div>
                        @foreach($data->videos as $keyVideo => $video)
                        <div class="video-item row" data-id="{{ Support::show($video,'id') }}">
                            <div class="group-form col-md-6">
                                <label>Tên video</label>
                                <input class="form-control" data-field="name-video" value="{{ Support::show($video,'name') }}" placeholder="Nhập tên video" >
                            </div>
                            <div class="group-form col-md-6">
                                <label>Loại video</label>
                                <select data-field="type_video" class="form-control">
                                    <option value="1" {{ $video->type_video == 1 ? 'selected' : ''  }}>Link</option>
                                    <option value="2" {{ $video->type_video == 2 ? 'selected' : ''  }}>File</option>
                                </select>
                            </div>
                            <div class="group-form col-md-6">
                                <label>Link video</label>
                                <div class="link-video">
                                    @if($video->type_video !== 2)
                                        <input class="form-control" data-field="link-video" value="{{ Support::show($video,'link') }}" placeholder="Nhập url video">
                                    @else
                                        <input data-key="{{$key}}-video" data-key-video="{{ $keyVideo }}" class="form-control" type="hidden" data-field="link-video" placeholder="Chọn video" value="{{ Support::show($video,'link') }}">
                                        <a href="/esystem/media/view?istiny={{$nameField}}||{{$key}}-video||{{ $keyVideo }}&callback=ADD_CHAPTER.eventFile" class="browseimage iframe-btn">{{ $video->link !== '' ? Support::showFileName($video->link) : 'Chọn video' }}</a>
                                        <button type="button" class="btn btn-sm btn-danger delete-document" data-key="{{$key}}-video" data-key-video="{{$keyVideo}}" title="Xóa dữ liệu">Xóa</button>
                                    @endif
                                </div>
                            </div>
                            <div class="group-form col-md-6">
                                <label>Thời lượng</label>
                                <input class="form-control" value="{{ Support::show($video,'time') }}" data-field="time-video" placeholder="Nhập thời lượng video">
                            </div>
                            <div class="group-form col-md-6">
                                <label>Loại video</label>
                                <select data-field="free-video" class="form-control">
                                    <option value="1" {{ $video->free == 1 ? 'selected' : ''  }}> Miễn phí</option>
                                    <option value="2" {{ $video->free == 2 ? 'selected' : ''  }}> Không miễn phí</option>
                                </select>
                            </div>
                            <div class="group-form col-md-6">
                                <label>Link bài tập</label>
                                <input class="form-control" data-field="exercise_link-video" value="{{ Support::show($video,'exercise_link') }}" placeholder="Nhập URL bài tập">
                            </div>
                            <div class="group-form col-md-6">
                                <label>Sắp xếp</label>
                                <input class="form-control" data-field="ord-video" value="{{ Support::show($video,'ord') }}" placeholder="Nhập URL bài tập">
                            </div>
                            <div class="group-form col-md-6 mt-3">
                                <label for="">Tài liệu</label>
                                <input data-key="{{ $key }}" data-key-video="{{ $keyVideo }}" class="form-control" type="hidden" data-field="document-video" value="{{ Support::show($video,'document') }}" placeholder="Nhập tài liệu">
                                <a href="{{$admincp}}/media/view?istiny={{ $nameField }}||{{$key}}||{{$keyVideo}}&callback=ADD_CHAPTER.eventFile" class="browseimage iframe-btn">{{ $video->document !== '' ? Support::showFileName($video->document) : 'Chọn tài liệu' }}</a>
                                <button type="button" class="btn btn-sm btn-danger delete-document" data-key="{{ $key }}" data-key-video="{{ $keyVideo }}" title="Xóa dữ liệu">Xóa</button>
                            </div>
                            <button type="button" class="remove-item">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="chapter-item__action">
                        <button type="button" class="add-video">Thêm Video</button>
                    </div>
                    <button type="button" class="remove-item">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    <button type="button" class="add-chapter">Thêm chương</button>
</div>
<script>
    var ADD_CHAPTER = (function(){
        $('.add-chapter').click(function(){
            var key = $('.chapter').find('.chapter-item').length;
            $('.chapter').append(`
                <div class="chapter-item" data-key="${key}">
                    <div class="group-form box-title-big-video-chapter">
                        <label class="title-big-video-chapter">Tên chương</label>
                        <input class="form-control" data-field="name" placeholder="Tên chương">
                    </div>
                    <div class="video">
                        <div class="group-form title-small-video-chapter">
                            <label>Danh sách video</label>
                        </div>
                    </div>
                    <div class="chapter-item__action">
                        <button type="button" class="add-video">Thêm Video</button>
                    </div>
                    <button type="button" class="remove-item">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            `
            )
        });

        $(document).on('click','.add-video',function(){
            var chapterItem = $(this).closest('.chapter-item');
            var key = chapterItem.attr('data-key');
            var keyVideo = chapterItem.find('.video .video-item').length;
            chapterItem.find('.video').append(`
                <div class="video-item row">
                    <div class="group-form col-md-6">
                        <label>Tên video</label>
                        <input class="form-control" data-field="name-video" placeholder="Nhập tên video" >
                    </div>
                    <div class="group-form col-md-6">
                        <label>Loại video</label>
                        <select data-field="type_video" class="form-control">
                            <option value="1" >Link</option>
                            <option value="2" >File</option>
                        </select>
                    </div>
                    <div class="group-form col-md-6">
                        <label>Video URL</label>
                        <div class="link-video">
                            <input class="form-control" data-field="link-video" placeholder="Nhập url video">
                        </div>
                    </div>
                    <div class="group-form col-md-6">
                        <label>Thời lượng</label>
                        <input class="form-control" data-field="time-video" placeholder="Nhập thời lượng video">
                    </div>
                    <div class="group-form col-md-6">
                        <label>Link bài tập </label>
                        <input class="form-control" data-field="exercise_link-video" placeholder="Nhập link bài tập">
                    </div>
                    <div class="group-form col-md-6">
                        <label>Sắp xếp </label>
                        <input class="form-control" data-field="ord-video" placeholder="Nhập URL bài tập">
                    </div>
                    <div class="group-form col-md-6">
                        <label>Loại video</label>
                        <select data-field="free-video" class="form-control">
                            <option value="1"> Miễn phí</option>
                            <option value="2"> Không miễn phí</option>
                        </select>
                    </div>
                    <div class="group-form col-md-6">
                        <label for="">Tài liệu</label>
                        <input data-key="${key}" data-key-video="${keyVideo}" class="form-control" type="hidden" data-field="document-video" placeholder="Nhập tài liệu">
                        <a href="/esystem/media/view?istiny={{$nameField}}||${key}||${keyVideo}&callback=ADD_CHAPTER.eventFile" class="browseimage iframe-btn">Chọn tài liệu</a>
                        <button type="button" class="btn btn-sm btn-danger delete-document" data-key="${key}" data-key-video="${keyVideo}" title="Xóa dữ liệu">Xóa</button>
                    </div>
                    <button type="button" class="remove-item">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            `)
        })

        $(document).on('change',`.group-form.{{ $nameField }} [data-field]`,function(){
            buildData();
        })

        $(document).on('click','.remove-item',function(){
            $(this).parent().remove();
            buildData();
        })

        $(document).on('click','.delete-document',function(){
            $(`[data-field="document-video"][data-key-video="${$(this).attr('data-key-video')}"][data-key="${$(this).attr('data-key')}"]`).val('');
            this.previousElementSibling.innerHTML = 'Chọn tài liệu';
            buildData();
        })

        $(document).on('change','[data-field="type_video"]',function(e){
            const val = $(e.target).val();
            const listItem = $(e.target).closest('.video-item').find('.link-video');
            if(val == 2){
                var time = new Date();
                time = time.getTime();
                $(listItem).html(`
                    <input data-key="${time}-video" data-key-video="${time}" class="form-control" type="hidden" data-field="link-video" placeholder="Chọn video">
                    <a href="/esystem/media/view?istiny={{$nameField}}||${time}-video||${time}&callback=ADD_CHAPTER.eventFile" class="browseimage iframe-btn">Chọn video</a>
                    <button type="button" class="btn btn-sm btn-danger delete-document" data-key="${time}-video" data-key-video="${time}" title="Xóa dữ liệu">Xóa</button>`);
            }else{
                $(listItem).html(`<input class="form-control" data-field="link-video" placeholder="Nhập url video">`)
            }
        });

        eventFile = (item,istiny) => {
            if(istiny){
                var dataGetItem = istiny.split('||');
                var selector = document.querySelector(`[data-key="${dataGetItem[1]}"][data-key-video="${dataGetItem[2]}"]`)
                selector.value = JSON.stringify(item[0]);
                selector.nextElementSibling.innerHTML = item[0].name;
                buildData();
            }
        }

        function buildData(){
            var main = $('textarea[name="{{ $nameField }}"]');
            var items = $('.group-form.{{ $nameField }} .chapter-item');
            var data = {};
            $.each(items,function(key,item){
                data[key] = {};
                if($(item).attr('data-id')){
                    data[key]['id'] = $(item).attr('data-id');
                }
                data[key]['name'] = $(item).find('[data-field="name"]').val();
                var videos = $(item).find('.video .video-item');
                data[key]['videos'] = [];
                $.each(videos,function(keyVideo, itemVideo){
                    var video = {
                        'link' : $(itemVideo).find('[data-field="link-video"]').val(),
                        'name' : $(itemVideo).find('[data-field="name-video"]').val(),
                        'document': $(itemVideo).find('[data-field="document-video"]').val(),
                        'time': $(itemVideo).find('[data-field="time-video"]').val(),
                        'free': $(itemVideo).find('[data-field="free-video"]').val(),
                        'exercise_link': $(itemVideo).find('[data-field="exercise_link-video"]').val(),
                        'ord': $(itemVideo).find('[data-field="ord-video"]').val(),
                        "type_video":$(itemVideo).find('[data-field="type_video"]').val(),
                    }
                    if($(itemVideo).attr('data-id')){
                        video['id'] = $(itemVideo).attr('data-id');
                    }
                    data[key]['videos'].push(video);
                })
            });
            main.html(JSON.stringify(data));
        }

        return {
            load:(() => {
                buildData();
            })(),
            eventFile:function( item,istiny){
                return eventFile(item ,istiny)
            }
        }
    })()
</script>
<style>
    .chapter-item{
        position: relative;
        padding: 8px;
        border: 1px solid #888;
    }
    .video-item{
        margin-left: 0px;
        margin-right: 0px;
        background: rgba(235,235,235,0.2);
        border: solid 1px #888;
        padding-top: 10px;
        padding-bottom: 10px;
        border-radius: 10px;
        position: relative;
    }

    .chapter-item .save-chapter{
        position: absolute;
        top: 5px;
        right: 5px;
    }
    .chapter-item + .chapter-item {
        margin-top: 5px;
    }

    .chapter-item__action button + button{
        margin-left: 12px;
    }

    .chapter-item__action{
        display: flex;
        justify-content: center;
    }

    .video-item + .video-item{
        margin-top: 15px;
    }

    .add-chapter,
    .add-video{
        margin-top: 10px;
        border: none;
        padding: 5px 10px;
        background: #b47e10;
        color: white;
    }

    .remove-item{
        position: absolute;
        top: 5px;
        right: 5px;
        padding: 2px 8px;
        border: 1px solid;
        background: #af2027;
        color: white;
    }
    .title-small-video-chapter{
        padding: 5px;
        text-align: center;
        font-size: 15px;
        background: #17a2b8!important;
        color: white;
        margin-bottom: 10px;
    }
    .title-small-video-chapter label{
        margin-bottom: 0px;
    }
    .title-big-video-chapter{
        padding: 8px;
        font-size: 16px;
        color: #fff!important;
        background-color: #343a40!important;
    }
    .box-title-big-video-chapter {
        display: flex;
    }
    .box-title-big-video-chapter .title-big-video-chapter{
        width: 150px;
        margin-bottom: 0px;
    }
    .box-title-big-video-chapter input{
        height: 39px;
        width: calc(100% - 150px);
    }

    .delete-document{
        margin-left: 0.5rem;
    }
</style>
