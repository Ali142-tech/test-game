@extends('layouts.site')

@section('title', $title)
@section('description', $description)

@section('content')
<article class="site-page">
    <div class="shell">
        <header class="site-page__head">
            <a href="/" class="site-page__back">← Back to home</a>
            <h1>{{ $title }}</h1>
            <p class="site-page__lead">{{ $description }}</p>
        </header>

        <div class="site-page__body">
            @foreach (__("site.pages.{$page}.sections") as $section)
                <section class="site-page__section">
                    @if (! empty($section['heading']))
                        <h2>{{ $section['heading'] }}</h2>
                    @endif
                    @foreach ($section['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                    @if (! empty($section['list']))
                        <ul>
                            @foreach ($section['list'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach

            @if ($page === 'help')
                <p class="site-page__cta">
                    <a href="/#faq" class="btn btn--dark">Browse FAQs on homepage</a>
                </p>
            @endif

            @if ($page === 'sell')
                <p class="site-page__cta">
                    <a href="{{ route('register') }}" class="btn btn--dark">Create a GoalPass account</a>
                </p>
            @endif
        </div>
    </div>
</article>
@endsection
