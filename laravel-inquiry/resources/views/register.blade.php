@extends('layout.default')
@section('content')

    <h1>ユーザ登録画面</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route("register") }}">
        @csrf
        <div>
            <label for="name">ユーザ名</label>
            <input name="name" type="text" value="{{ old('name') }}"/>
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input name="email" type="email" value="{{ old('email') }}"/>
        </div>
        <div>
            <label for="email">パスワード</label>
            <input name="password" type="password"/>
        </div>
        <div>
            <label for="email">パスワード確認</label>
            <input name="password_confirmation" type="password"/>
        </div>
        <div>
            <button type="submit">登録</button>
        </div>
    </form>
@endsection()
