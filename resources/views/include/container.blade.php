<div class="tab">
    <ul itemscope itemtype="http://schema.org/Blog">
        @isset($articles)
        @foreach ($articles as $article)
        <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="{{ route('home_show', ['page_chose' => 'Roof_Party']) }}" itemprop="url">
                <span class="preview__date" itemprop="datePublished">{{ $article->date }}</span>
                <h2 class="preview__header" itemprop="name">{{ $article->title }}</h2>
                @if(strlen($article->context)>30)
                <p class="preview__excerpt" itemprop="description">{{mb_substr($article->context, 0, 30,'UTF-8')}}...</p>
                @else
                <p class="preview__excerpt" itemprop="description">{{ $article->context }}</p>
                @endif
                <span class="preview__more">Read More</span>
            </a>
        </li>
        @endforeach
        @endisset
    </ul>
    <footer class="section-padding--sm footer">
        <a class="footer__archive" href="#">Archive</a>
        <ul class="footer__social">
            <li><a class="fa fa-lg fa-envelope-o" href="mailto:thomas.vaeth@gmail.com"></a></li>
            <li><a class="fa fa-lg fa-github" href="https://github.com/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-codepen" href="https://codepen.io/thomasvaeth/" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-linkedin" href="https://www.linkedin.com/in/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-twitter" href="https://twitter.com/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-facebook" href="https://www.facebook.com/thomas.vaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-instagram" href="https://www.instagram.com/thomas.vaeth/" target="_blank"></a></li>
        </ul>
    </footer>
</div>

<div class="tab">
    <ul class="cards">
        <li class="card">
            <a class="card__link" href="#">
                <div class="card__img">
                    <figure class="absolute-bg" style="background-image: url('https://unsplash.it/500/300?image=1074');"></figure>
                </div>
                <div class="card__container">
                    <h2 class="card__header">Brunch</h2>
                    <p class="card__count">3 Posts</p>
                    <span class="card__more">View All</span>
                </div>
            </a>
        </li>
        <li class="card">
            <a class="card__link" href="#">
                <div class="card__img">
                    <figure class="absolute-bg" style="background-image: url('https://unsplash.it/500/300?image=718');"></figure>
                </div>
                <div class="card__container">
                    <h2 class="card__header">Gluten-free</h2>
                    <p class="card__count">2 Posts</p>
                    <span class="card__more">View All</span>
                </div>
            </a>
        </li>
        <li class="card">
            <a class="card__link" href="#">
                <div class="card__img">
                    <figure class="absolute-bg" style="background-image: url('https://unsplash.it/500/300?image=1060');"></figure>
                </div>
                <div class="card__container">
                    <h2 class="card__header">Cities</h2>
                    <p class="card__count">3 Posts</p>
                    <span class="card__more">View All</span>
                </div>
            </a>
        </li>
        <li class="card">
            <a class="card__link" href="#">
                <div class="card__img">
                    <figure class="absolute-bg" style="background-image: url('https://unsplash.it/500/300?image=16');"></figure>
                </div>
                <div class="card__container">
                    <h2 class="card__header">Juice</h2>
                    <p class="card__count">2 Posts</p>
                    <span class="card__more">View All</span>
                </div>
            </a>
        </li>
    </ul>
    <footer class="section-padding--sm footer">
        <a class="footer__archive" href="#">Archive</a>
        <ul class="footer__social">
            <li><a class="fa fa-lg fa-envelope-o" href="mailto:thomas.vaeth@gmail.com"></a></li>
            <li><a class="fa fa-lg fa-github" href="https://github.com/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-codepen" href="https://codepen.io/thomasvaeth/" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-linkedin" href="https://www.linkedin.com/in/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-twitter" href="https://twitter.com/thomasvaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-facebook" href="https://www.facebook.com/thomas.vaeth" target="_blank"></a></li>
            <li><a class="fa fa-lg fa-instagram" href="https://www.instagram.com/thomas.vaeth/" target="_blank"></a></li>
        </ul>
    </footer>
</div>