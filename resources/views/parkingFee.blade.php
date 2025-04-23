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

    // 停車
    function parking() {
        var location = $('#location').val();
        var cartype = $('#cartype').val();
        var captchaText = $('#captchaText').val();

        if (location == "") {
            alert("請選擇欲查詢縣市");
            $('#location').focus();
            return false;
        }

        if (cartype == "") {
            alert("請選擇汽/機車");
            $('#cartype').focus();
            return false;
        }

        if (captchaText == "") {
            alert("請輸入驗證碼");
            refreshImage();
            $('#captchaText').focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/parkingFee",
            data: {
                check: captchaText,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // 如果驗證成功，手動提交表單
                    $('#parkForm').submit();

                    $('#carResult').css("display", "block");
                    refreshImage();
                    $('#captchaText').val("");
                } else {
                    alert(response.message); // 驗證失敗
                    refreshImage();
                    $('#captchaText').val('').focus();
                }
            },
            error: function(xhr) {
                alert('伺服器錯誤');
            }
        });
    }

    function refreshImage() {
        // 生成一個隨機的查詢字符串，以便重新加載圖像
        var img = document.getElementById('captcha');
        img.src = '/captchaImage?' + new Date().getTime();
    }
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
                <!-- 停車費查詢 -->
                <div class="tab carCont">
                    <div class="carLeft col-7 col-sm-12">
                        <h2>停車繳費查詢</h2>
                        <p>請輸入車牌號碼，查詢未繳之停車繳費單:<br>
                            (輸入範例：ABC-5678或123-ABC)
                        </p><br>

                        <form target="carcheck" method="post" action="parkingFeeCheck" id="parkForm">
                            @csrf
                            <div class="col-11 col-sm-11 car">
                                <label for="number">*車牌號碼: </label>
                                <input type="text" title="車牌號碼" placeholder="請輸入您的車牌號碼" id="carid" name="carid" required>
                            </div>
                            <div class="col-11 col-sm-11 car">
                                <label for="location">*縣市:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <select name="location" id="location">
                                    <option value="">請選擇查詢縣市</option>
                                    <option value="Keelung">基隆市</option>
                                    <option value="Taipei">台北市</option>
                                    <option value="NewTaipei">新北市</option>
                                    <option value="Taoyuan">桃園市</option>
                                    <option value="Hsinchu">新竹市</option>
                                    <option value="Hsinchu_s">新竹縣</option>
                                    <option value="Taichung">台中市</option>
                                    <option value="Changhua">彰化縣</option>
                                    <option value="Chiayi">嘉義市</option>
                                    <option value="Tainan">台南市</option>
                                    <option value="Kaohsiung">高雄市</option>
                                    <option value="Pingtung">屏東縣</option>
                                    <option value="Taitung">台東縣</option>
                                </select>
                            </div>
                            <div class="col-11 col-sm-11 car">
                                <label for="cars">*車種:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <select name="cartype" id="cartype">
                                    <option value="">請選擇車種</option>
                                    <option value="C">汽車</option>
                                    <option value="M">機車</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-11 car">
                                <p>*驗證碼: <input id="captchaText" name="captchaText" type="text" title="驗證碼"
                                        placeholder="請輸入驗證碼 不區分大小寫">&nbsp;<img id="captcha"
                                        class="captcha" src="/captchaImage" alt="captcha">
                                    <input type="button" value="更換圖片" onclick="refreshImage()">
                                </p>
                            </div>
                            <div class="car">
                                <button id="parkSubmit" type="button" onclick="parking()" title="確定送出">
                                    確定送出</button>
                                <button type="reset" title="清除">
                                    清除</button>
                            </div>
                        </form>
                    </div>
                    <!-- 送出查詢後的結果，預設隱藏 -->
                    <div class="carRight col-5 col-sm-12" id="carResult" style="display: none">
                        <h2>查詢結果</h2>
                        <iframe name="carcheck" height="100%" width="100%"></iframe>
                    </div>
                </div>
            </div>
            @include('footer')