@include('header')
<link rel="stylesheet" href="{{ asset('contact.css') }}">
</head>

<script src="{{ asset('common.js') }}"></script>

<script>
    // 第三個 tab
    document.addEventListener('DOMContentLoaded', function() {
        Tabs.init(2);
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
                @if(session('success'))
                <script>
                    alert("{{ session('success') }}");
                </script>
                @endif
                <div class="tab contact">
                    <main>
                        <!-- TODO: email 如果已登入要直接帶入 -->
                        <div id="message_card" class="message_card">
                            <form method="POST" action="{{ route('reporting') }}" enctype="multipart/form-data">
                                @csrf
                                <table>
                                    <tr>
                                        <td>*姓名:</td>
                                        <td><input type="text" id="name" name="name" placeholder="請輸入您的姓名" require></td>
                                    </tr>
                                    <tr>
                                        <td>*電子郵件:</td>
                                        <td><input type="email" id="email" name="email" placeholder="請輸入您的電子郵件" require></td>
                                    </tr>
                                    <tr>
                                        <td>聯絡電話:</td>
                                        <td><input type="text" id="phone" name="phone" placeholder="請輸入您的聯絡電話"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">聯繫內容:</td>
                                        <td rowspan="2">
                                            <textarea name="information" id="text" rows="15" placeholder="請在此輸入您的問題，我們將盡快與您聯絡，謝謝。"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                                <div id="choicies" class="choiciesclass">
                                    <input type="submit" name="submit" id="submit" value="確認送出">
                                </div>
                            </form>
                        </div>
                    </main>
                </div>
            </div>
            @include('footer')