@extends('layout.default')
@section('content')
    <div class="container">
        <table class="table">
            <thread>
                <tr>
                    <th>id</th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>お問合せ内容</th>
                    <th>種別</th>
                    <th>送信日時</th>
                </tr>
            </thread>
            <tbody>
                @foreach ($inquiries as $inquiry)
                    <tr>
                        <td><a{{ $inquiry->id }}</td>
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->content }}</td>
                        <td>{{ $inquiry->type }}</td>
                        <td>{{ $inquiry->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $inquiries->links() }}
@endsection()
