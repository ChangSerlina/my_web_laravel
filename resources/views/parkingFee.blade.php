@include('header')
<link rel="stylesheet" href="{{ asset('parkingFee.css') }}">
</head>

<script src="{{ asset('common.js') }}"></script>

<script>
    // 停車
    function parking() {
        var location = $('#location').val();
        var carid = $('#carid').val();
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
                    // 驗證成功後再查詢停車資訊
                    $.ajax({
                        type: "POST",
                        url: "/parkingFeeCheck",
                        data: {
                            carid: carid,
                            location: location,
                            cartype: cartype,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $('#carResult').show();
                            $('#carResultContent').empty().html(data.html); // 顯示查詢結果
                            refreshImage();
                            $('#captchaText').val('');
                        },
                        error: function(xhr) {
                            alert('查詢失敗，請稍後再試');
                        }
                    });
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

    // 監聽事件
    document.addEventListener('DOMContentLoaded', function() {
        // 第二個 tab
        Tabs.init(1);
        Preview.init();

        // 車牌格式即時驗證
        const caridInput = document.getElementById('carid');
        const msg = document.getElementById('carid-msg');
        const regex = /^.+-.+$/; // 只要中間有一個 "-" 即可

        caridInput.addEventListener('input', function() {
            const value = caridInput.value.toUpperCase(); // 自動轉大寫
            caridInput.value = value;

            if (value === '') {
                msg.textContent = '';
                caridInput.style.borderColor = '';
            } else if (!regex.test(value)) {
                msg.textContent = '車牌格式錯誤，應為 XXX-XXX';
                caridInput.style.borderColor = 'red';
            } else {
                msg.textContent = '';
                caridInput.style.borderColor = 'green';
            }
        });

        // 按 Enter 提交表單
        const form = document.querySelector('form');
        form.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                parking(); // 自定義的提交方法
            }
        });
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
                <!-- 停車費查詢 -->
                <div class="tab carCont">
                    <div class="col-12 col-sm-12">
                        <p>請輸入車牌號碼，查詢待繳停車費<br>
                            (輸入範例：ABC-5678或123-ABC)
                        </p>

                        <form method="post" id="parkForm">
                            @csrf
                            <table>
                                <tr><td colspan="2"><span id="carid-msg" style="color: red; font-size: 0.5em;"></span></td></tr>
                                <tr>
                                    <td>*車牌號碼:</td>
                                    <td><input type="text" title="車牌號碼" placeholder="請輸入您的車牌號碼" id="carid" name="carid" size="15" required></td>
                                </tr>
                                <tr>
                                    <td>*縣市:</td>
                                    <td><select name="location" id="location" style="width: 18ch;">
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
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>*車種:</td>
                                    <td>
                                        <select name="cartype" id="cartype" style="width: 18ch;">
                                            <option value="">請選擇車種</option>
                                            <option value="C">汽車</option>
                                            <option value="M">機車</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*驗證碼:</td>
                                    <td><input id="captchaText" name="captchaText" type="text" title="驗證碼"
                                            placeholder="請輸入驗證碼" size="15" require>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img id="captcha"
                                            class="captcha" src="/captchaImage" alt="captcha">
                                    </td>
                                    <td><input type="button" value="更換圖片" onclick="refreshImage()"></td>
                                </tr>
                            </table>
                            <div class="car">
                                <button id="parkSubmit" type="button" onclick="parking()" title="確定送出">
                                    確定送出</button>
                                <button type="reset" title="清除">
                                    清除</button>
                            </div>
                        </form>
                    </div>
                    <!-- 送出查詢後的結果，預設隱藏 -->
                    <div class="col-12 col-sm-12" id="carResult">
                        <div id="carResultContent"></div> <!-- 用這個來放查詢結果 -->
                    </div>
                </div>
            </div>
            @include('footer')