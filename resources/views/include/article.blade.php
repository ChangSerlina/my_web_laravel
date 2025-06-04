<!-- 將 CSS 文件連結到 HTML -->
<link rel="stylesheet" href="{{ asset('article.css') }}">

<div class="tab">
    <ul itemscope itemtype="">
        @isset($articles)
        @foreach ($articles as $article)
        <li class="preview" itemprop="blogPost" itemscope itemtype="">
            <span class="preview__date" itemprop="datePublished">{{ $article->date }}</span>
            <h2 class="preview__header" itemprop="name">{{ $article->title }}</h2>
            <!-- <p class="preview__excerpt" itemprop="description">{{ $article->context }}</p> -->
            <textarea name="" id="" disabled>{{ $article->context }}</textarea>
        </li>
        @endforeach
        @endisset
    </ul>