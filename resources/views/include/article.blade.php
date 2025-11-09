<!-- 將 CSS 文件連結到 HTML -->
<link rel="stylesheet" href="{{ asset('article.css') }}">

<div class="tab">
    <ul itemscope itemtype="">
        @isset($articles)
        @foreach ($articles as $article)
        <li class="preview" itemprop="blogPost" itemscope itemtype="">
            <span class="preview__date" itemprop="datePublished">{{ $article->date }}</span>
            <h2 class="preview__header" itemprop="name">{{ $article->title }}</h2>
            <div id="context">{!! $article->context !!}</div>
        </li>
        @endforeach
        @endisset

        <div class="tabs">
            @if($pre_article_route != "")
            <a href="{{ route('home_show', ['page_chose' => $pre_article_route]) }}">←上一篇</a>
            @endif

            @if($next_article_route != "")
            <a href="{{ route('home_show', ['page_chose' => $next_article_route]) }}">→下一篇</a>
            @endif
        </div>
    </ul>