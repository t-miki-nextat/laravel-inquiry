@extends('layout.default')
@section('content')
    <div class="container">
        @if (session('flash_message'))
            <div class="flash_message">
                {{ session('flash_message') }}
            </div>
        @endif
        <table class="table">
            <thread>
                <tr>
                    <th>id</th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                </tr>
            </thread>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                           class="btn btn-primary">{{ $user->id }}</a></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection()
