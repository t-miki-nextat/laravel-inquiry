@extends('layout.default')

@section('title', '送信完了')
@section('content')
お問合せありがとうございました<br>
<a href={{route('form')}} >問合せフォームへ戻る</a>
@endsection
