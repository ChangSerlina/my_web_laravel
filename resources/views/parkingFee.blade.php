@include('header')
    <link rel="stylesheet" href="{{ asset('parkingFee.css') }}">
</head>

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
                    s.tabs[1].classList.add('active');
                }
            },

            click: function() {
                if (s.tabs.length) {
                    var currentIdx = 1,
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

<body>
    <section class="previews">
        <div>
            @include('include.left', ['page_chose_1' => $page_chose_1,'articles' => $articles])
        </div> <!--要把資料夾名稱『include』給放進來-->
        <div>
            <div>
                @include('include.nav')
            </div>
            <div>
                <div class="tab">
                    <h1>這是停車查詢頁面</h1>
                </div>
            </div>
            @include('footer')
