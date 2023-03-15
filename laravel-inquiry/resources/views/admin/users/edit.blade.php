@extends('layout.default')
@section('content')
    <div class="book-new">
        <form action="{{ route('admin.users.update', ['id'=>$user->id])}}"
              method="post" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="hidden" name="_method" value="PUT">
            <div class="form-label">
                ユーザー名
            </div>
            <div>
                <input class="form-input__input" type="text" name="name"
                       value="{{$user->name}}">
            </div>
            <div class="form-label">
                メールアドレス
            </div>
            <div>
                <input class="form-input__input" type="text" name="email"
                       value="{{$user->email}}">
            </div>
            <div class="form-foot">
                <input class="send" type="submit" value="編集">
            </div>
        </form>
        <form method="post" action="{{route('admin.users.delete', $user->id)}}">
            @csrf
            @method('DELETE')
            <input class="send" type="submit" value="削除">
        </form>
    </div>
@endsection()
