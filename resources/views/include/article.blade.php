<!-- 將 CSS 文件連結到 HTML -->
<link rel="stylesheet" href="{{ asset('article.css') }}">

<div class="tab">
    <ul itemscope itemtype="">
        @isset($articles)
        @foreach ($articles as $article)
        <li class="preview" itemprop="blogPost" itemscope itemtype="">
            <span class="preview__date" itemprop="datePublished">{{ $article->date_formatted }}</span>
            <h2 class="preview__header" itemprop="name">{{ $article->title }}</h2>
            <div id="context">{!! $article->context !!}</div>
        </li>
        @endforeach
        @endisset

        <div class="tabs">
            @if($pre_article != "")
            <a href="{{ route('home_show', ['page_chose' => $pre_article->route]) }}">←上一篇 <span class="article_title">{{ $pre_article->title  }}</span></a>
            @endif

            @if($next_article != "")
            <a href="{{ route('home_show', ['page_chose' => $next_article->route]) }}"><span class="article_title">{{ $next_article->title  }}</span> 下一篇→</a>
            @endif
        </div>
    </ul>