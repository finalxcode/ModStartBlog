@extends($_viewFrame)

@section('pageTitle'){{$pageTitle}}@endsection
@section('pageKeywords')编辑博客@endsection
@section('pageDescription')编辑博客@endsection

@section('headAppend')
    @parent
    {{\ModStart\ModStart::js('asset/vendor/ueditor/ueditor.config.js')}}
    {{\ModStart\ModStart::js('asset/vendor/ueditor/ueditor.all.min.js')}}
@endsection

@section('bodyContent')

<div class="ub-container margin-top">
    <div class="row">
        <div class="col-md-12">
            <div class="ub-content-box margin-bottom">
                <div class="tw-p-3">
                    <div class="tw-text-lg tw-mb-4">
                        <i class="iconfont icon-edit"></i>
                        编辑博客
                    </div>
                    
                    <form action="{{modstart_web_url('member_blog/edit/'.$blog['id'])}}" method="post" class="ub-form">
                        <div class="line">
                            <div class="label">标题 <span class="ub-text-danger">*</span></div>
                            <div class="field">
                                <input type="text" name="title" class="form-lg" placeholder="请输入博客标题" value="{{$blog['title']}}" required>
                            </div>
                        </div>
                        
                        <div class="line">
                            <div class="label">分类</div>
                            <div class="field">
                                <select name="categoryId" class="form-lg">
                                    <option value="0">-- 请选择分类 --</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($blog['categoryId']==$category->id) selected @endif>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="line">
                            <div class="label">标签</div>
                            <div class="field">
                                <input type="text" name="tag" class="form-lg" placeholder="多个标签用逗号分隔" value="{{$blog['tag']}}">
                            </div>
                        </div>
                        
                        <div class="line">
                            <div class="label">摘要</div>
                            <div class="field">
                                <textarea name="summary" class="form-lg" rows="3" placeholder="博客摘要，如不填写将自动提取内容前200字">{{$blog['summary']}}</textarea>
                            </div>
                        </div>
                        
                        <div class="line">
                            <div class="label">内容 <span class="ub-text-danger">*</span></div>
                            <div class="field">
                                <script id="container" name="content" type="text/plain" style="height:400px;">{!! $blog['content'] !!}</script>
                                <script>
                                    $(function(){
                                        var ue = UE.getEditor('container', {
                                            toolbars: [
                                                ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                                                'bold', 'italic', 'underline', 'strikethrough', 'removeformat', '|', 'forecolor', 'backcolor', '|',
                                                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                                                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                                                'link', 'unlink', '|',
                                                'simpleupload', 'insertimage', '|',
                                                'inserttable', 'deletetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|',
                                                'preview']
                                            ]
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        
                        <div class="line">
                            <div class="label"></div>
                            <div class="field">
                                <button type="submit" class="btn btn-primary btn-lg">保存修改</button>
                                <a href="{{modstart_web_url('member_blog')}}" class="btn btn-default btn-lg tw-ml-2">返回列表</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
