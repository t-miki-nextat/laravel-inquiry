@extends('layout.default')
@section('content')
    <h1>管理者ダッシュボード</h1>
    <p>ようこそ、{{ Auth::user()->name }}さん</p>
    <a href="{{ route('admin.users.index') }}"
       class="btn btn-primary">管理ユーザー一覧</a>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endsection()
