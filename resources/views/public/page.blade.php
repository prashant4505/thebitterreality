@extends('layouts.public')

@section('content')
<section class="container-page py-14">
    <article class="mx-auto max-w-3xl">
        <h1 class="text-4xl font-bold text-white" style="font-family:Inter,sans-serif">{{ $page->title() }}</h1>
        <div class="prose-doc mt-10">{!! $page->content() !!}</div>
    </article>
</section>
@endsection
