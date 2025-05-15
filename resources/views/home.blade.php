@include('header')
</head>

<script src="{{ asset('common.js') }}"></script>

<script>
    // 第一個 tab
    document.addEventListener('DOMContentLoaded', function() {
        Tabs.init(0);
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
                @include($page_chose_1, ['articles' => $articles])
            </div>
            @include('footer')