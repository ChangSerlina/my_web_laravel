<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- 將 CSS 文件連結到 HTML -->
    <link rel="stylesheet" href="{{ asset('contact.css') }}">
</head>

<body id="top">
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
    <div id="contener">

        <header>
            <h1>與我們聯絡 Contact us</h1>
        </header>
        <main>
            <div id="choicies" class="choiciesclass">
                <button id="mail_us" class="mail_us"><a href="mailto: deniel87deniel87@gmail.com">Mail to Us</a></button>
                <button id="message_local" class="message_local" onclick="message_card_shows()">Message on Local</button>
            </div>

            <!--email 如果以登入會直接帶入 -->
            <div id="message_card" class="message_card">
                <form method="POST" action="{{ route('reporting') }}" enctype="multipart/form-data">
                    @csrf

                    <div id="zone1">
                        <div><input type="text" id="name" name="name" placeholder="輸入姓名* Name plz"></div>
                        <div><input type="submit" name="submit" id="submit" value="送出 Submit"></div>
                    </div>

                    <div id="zone2">
                        <div><input type="text" id="phone" name="phone" placeholder="聯絡電話 Phone Num"></div>
                        <div><input type="mail" id="mail" name="email" placeholder="電子郵件* E-mail"></div>
                    </div>

                    <div id="zone3">
                        <textarea name="information" id="text" cols="20" rows="15" placeholder="聯繫內容(請少於200字) Content (less than 300 words)"></textarea>
                    </div>
                </form>
            </div>
        </main>

    </div>
</body>
</html>

<script>
    function message_card_shows() {
        document.getElementById("message_card").className = "message_card_show";
        document.getElementById("choicies").className = "none";
    }
</script>