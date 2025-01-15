<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Serlina, serlina0504@gmail.com">
    <meta name="keyword" content="serlina, 網站">
    <meta name="description" content="Serlina(榕軒)的網站">
    <title>榕軒的網站</title>

    <!-- <link rel="shortcut icon" href="images/logo.png" type="image/x-icon"> -->

    <!-- 將 CSS 文件連結到 HTML -->
    <link rel="stylesheet" href="{{ asset('home.css') }}">
</head>

<body>
    <section class="previews">
        <div>
            <div>
                @switch($page_chose_1)
                @case('include.Roof_Party')
                <figure class="absolute-bg preview__img" style="background-image: url('image/osakajo.jpg');"></figure>
                @case('include.Craft_Beer')
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1003');"></figure>
                @case('include.Next_Level_Blog')
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=433');"></figure>
                @case('include.VHS_Selfies')
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=40');"></figure>
                @case('include.Four_Dollar_Toast')
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1074');"></figure>
                @default
                <figure class="absolute-bg preview__img" style="background-image: url('image/osakajo.jpg');"></figure>
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1003');"></figure>
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=433');"></figure>
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=40');"></figure>
                <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1074');"></figure>
                @endswitch
                <div class="previews__container">
                    <span>Welcome to</span>
                    <h1>Serlina Web</h1>
                </div>
            </div>
        </div> <!--要把資料夾名稱『include』給放進來-->
        <div>
            <div>@include('include.nav')</div>
            <div>@include($page_chose_1)</div>
        </div>
    </section>
</body>

</html>

<script>
    // Full blog theme demo and download available at http://thomasvaeth.com/trophy/
    var Tabs = (function() {
        var s;

        return {
            settings: {
                tabs: document.getElementsByClassName('tabs__item'),
                tab: document.getElementsByClassName('tab')
            },

            init: function() {
                s = this.settings;
                this.display();
                this.click();
            },

            display: function() {
                if (s.tab.length) {
                    [].forEach.call(s.tab, function(tab) {
                        tab.style.display = 'none';
                    });
                    s.tab[0].style.display = 'block';
                    s.tab[0].classList.add('active');
                    s.tabs[0].classList.add('active');
                }
            },

            click: function() {
                if (s.tabs.length) {
                    var currentIdx = 0,
                        prevIdx = currentIdx;

                    [].forEach.call(s.tabs, function(tab, idx) {
                        tab.addEventListener('click', function() {
                            prevIdx = currentIdx;
                            currentIdx = idx;

                            if (prevIdx !== currentIdx) {
                                s.tab[prevIdx].style.display = 'none';
                                s.tab[prevIdx].classList.remove('active');
                                s.tabs[prevIdx].classList.remove('active');
                                s.tab[currentIdx].style.display = 'block';
                                s.tab[currentIdx].classList.add('active');
                                s.tabs[currentIdx].classList.add('active');
                            }
                        });
                    });
                }
            }

        }
    })();

    var Preview = (function() {
        var s;

        return {
            settings: {
                img: document.getElementsByClassName('preview__img'),
                post: document.getElementsByClassName('preview')
            },

            init: function() {
                s = this.settings;
                this.display();
                this.mouseenter();
            },

            display: function() {
                if (s.img.length) {
                    [].forEach.call(s.img, function(img) {
                        img.style.display = 'none';
                    });
                    s.img[0].style.display = 'block';
                }
            },

            mouseenter: function() {
                if (s.post.length) {
                    var currentIdx = 0,
                        prevIdx = currentIdx;

                    [].forEach.call(s.post, function(preview, idx) {
                        preview.addEventListener('mouseenter', function() {
                            prevIdx = currentIdx;
                            currentIdx = idx;

                            if (prevIdx !== currentIdx) {
                                s.img[prevIdx].style.display = 'none';
                                s.img[currentIdx].style.display = 'block';
                            }
                        });
                    });
                }
            }
        }
    })();

    document.addEventListener('DOMContentLoaded', function() {
        Tabs.init();
        Preview.init();
    });
</script>