@extends('layout.default')

@section('title', '送信完了')
@section('content')
    お問合せありがとうございました<br>
    <a href={{route('inquiries.form')}} >お問合せフォームへ戻る</a>
@endsection
