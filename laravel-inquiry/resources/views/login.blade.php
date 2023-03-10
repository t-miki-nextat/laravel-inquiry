@extends('layout.default')
@section('content')

    <h1>ログイン画面</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" 　action="{{route('login')}}">
        @csrf
        <div>
            <label for="email">メールアドレス</label>
            <input name="email" type="email" value="{{old('email')}}"/>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input name="password" type="password"/>
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
    </form>

@endsection()
