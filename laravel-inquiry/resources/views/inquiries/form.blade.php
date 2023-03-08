@extends('layout.default')

@section('title','お問合せフォーム')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                        <form method="POST" action="{{route('inquiries.store')}}">
                            @csrf
                            @if ($errors->any())
                                <div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            名前（※必須）<br>
                            <input type="text" name="name" value="{{old('name')}}"><br>
                            メールアドレス（※必須）<br>
                            <input type="email" name="email" value="{{old('email')}}"><br>
                            種別<br>
                            <select name="type">
                                <option value="estimate">お見積り</option>
                                <option value="recruit">採用</option>
                                <option value="other">その他</option>
                            </select><br>
                            問合せ内容（※必須）<br>
                            <textarea name="content" maxlength="1000"></textarea>
                            <br>
                            <input class="btn" type="submit" value="送信">
                        </form>

            </div>
        </div>
    </div>

@endsection

