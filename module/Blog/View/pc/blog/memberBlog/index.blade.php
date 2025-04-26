@extends($_viewFrame)

@section('pageTitle'){{$pageTitle}}@endsection
@section('pageKeywords')我的博客@endsection
@section('pageDescription')我的博客@endsection

@section('bodyContent')

<div class="ub-container margin-top">
    <div class="row">
        <div class="col-md-12">
            <div class="ub-content-box margin-bottom">
                <div class="tw-p-3">
                    <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                        <div class="tw-text-lg">
                            <i class="iconfont icon-list"></i>
                            我的博客
                        </div>
                        <div>
                            <a href="{{modstart_web_url('member_blog/add')}}" class="btn btn-primary btn-round">
                                <i class="iconfont icon-plus"></i>
                                发布博客
                            </a>
                        </div>
                    </div>
                    
                    <div class="tw-mt-4">
                        <table class="ub-table">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th>标题</th>
                                    <th width="120">发布时间</th>
                                    <th width="120">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($blogs->isEmpty())
                                    <tr>
                                        <td colspan="4" class="tw-text-center tw-py-4">暂无博客</td>
                                    </tr>
                                @else
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td>{{$blog->id}}</td>
                                            <td>
                                                <a href="{{modstart_web_url('blog/'.$blog->id)}}" target="_blank">{{$blog->title}}</a>
                                            </td>
                                            <td>{{$blog->created_at->format('Y-m-d')}}</td>
                                            <td>
                                                <a href="{{modstart_web_url('member_blog/edit/'.$blog->id)}}" class="tw-mr-2">编辑</a>
                                                <a href="javascript:;" class="tw-text-danger" data-confirm="确认删除？" data-ajax-request="{{modstart_web_url('member_blog/delete',['_id'=>$blog->id])}}">删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="ub-page tw-mt-4">
                        {!! $blogs->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
