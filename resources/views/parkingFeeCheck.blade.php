<!DOCTYPE html>
<html lang="zh-TW">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Serlina, serlina0504@gmail.com">
        <meta name="keyword" content="serlina, 網站">
        <meta name="description" content="Serlina(榕軒)的網站">
        <title>榕軒的網站</title>
        <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
        <!-- Icon 來源-->
        <script src="https://kit.fontawesome.com/a720f5b186.js" crossorigin="anonymous"></script>

        <!-- BS CDN links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="CSS/style.css">

        <style>
            body {
                background-color: transparent !important;
            }

            h1,
            p {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                margin-top: 1rem;
            }
            p{
                height: 2rem;
                line-height: 2rem;
                text-align: start;
            }
        </style>

    </head>

    <body>
        @isset($carid)
        @isset($cityName)
        @isset($_cartype)
        <!-- http://parkingbill.tainan.gov.tw/Parking/PayBill/CarID/{CarID}/CarType/{CarType} -->
        <h2 align="left"></h2>
        <p>車牌號碼:<?php echo $carid; ?></p>

        <h2 align="left"></h2>
        <p>查詢縣市:<?php echo $cityName; ?></p>
        
        <h2 align="left"></h2>
        <p>車種:<?php echo $_cartype; ?></p>

        <h3 align="left"> </h3>

        <p>未繳金額:</p>
        <div id="loading" class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        
        <div id="API" >
            <iframe class="col-4 col-sm-12" src=<?php echo $_API; ?> height="220"></iframe>
        </div>
        @endisset
        @endisset
        @endisset
    </body>
    <script>
    // script.js
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show the loading indicator
        function showLoading() {
            document.getElementById('loading').style.display = 'inline-block';
            document.getElementById('API').style.display = 'none';
        }

        // Function to hide the loading indicator
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('API').style.display = 'block';
        }

        // Example function to simulate an API call
        function fetchData() {
            showLoading();

            // Simulate an API call with a timeout
            setTimeout(function() {
                hideLoading();
            }, 3000);
        }

        // Trigger the fetchData function on page load or based on your specific requirements
        fetchData();
    });
    </script>
</html>