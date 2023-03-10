@extends('layout.default')

@section('content')
    @php
    /** @var \App\Models\Inquiry $inquiry */
    @endphp
    <h1>詳細確認</h1>
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
                <tr>
                    <td>{{ $inquiry->id }}</a></td>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->email }}</td>
                    <td>{{ $inquiry->content }}</td>
                    <td>{{ $inquiry->type->text() }}</td>
                    <td>{{ $inquiry->created_at->format('Y/m/d H:i:s') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
