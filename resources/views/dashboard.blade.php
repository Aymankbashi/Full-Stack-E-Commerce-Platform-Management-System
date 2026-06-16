<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الهيئة العامة للغذاء والدواء</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem 1rem 2rem;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }
        .header img {
            height: 48px;
        }
        .header .user {
            font-size: 1.1rem;
            color: #3358e6;
            font-weight: 700;
        }
        .dashboard-main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .cards {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            padding: 1.2rem 2rem;
            flex: 1 1 180px;
            min-width: 180px;
            text-align: center;
        }
        .card-title {
            color: #888;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }
        .card-value {
            font-size: 2.1rem;
            font-weight: 700;
            color: #3358e6;
        }
        .tables-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .table-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            padding: 1rem 1.2rem;
            flex: 1 1 350px;
            min-width: 320px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5rem;
        }
        th, td {
            padding: 0.4rem 0.6rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background: #f4f7fa;
            color: #3358e6;
            font-weight: 700;
        }
        .highlight {
            background: #ffe6b3;
            color: #b26a00;
            font-weight: 700;
        }
        .chart-row {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .chart-box, .map-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            padding: 1rem 1.2rem;
            flex: 1 1 350px;
            min-width: 320px;
        }
        .logout-btn {
            background: linear-gradient(90deg, #4f8cff 0%, #3358e6 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            padding: 0.5rem 1.5rem;
            cursor: pointer;
            margin-right: 1rem;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: linear-gradient(90deg, #3358e6 0%, #4f8cff 100%);
        }
        @media (max-width: 900px) {
            .cards, .tables-row, .chart-row {
                flex-direction: column;
            }
        }
    </style>
</head>
@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp

<body>
    <div class="header">
        <img src="https://www.sfda.gov.sa/themes/custom/sfda/logo.png" alt="شعار الهيئة العامة للغذاء والدواء">
        <div class="user" style="position:relative;">
            <span id="userIcon" style="display:inline-flex;align-items:center;cursor:pointer;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="#3358e6" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
                </svg>
                <span style="margin-right:0.5rem; font-weight:700;">{{ Auth::user()->name }}</span>
            </span>
            <div id="userCard" style="display:none; position:absolute; left:0; top:120%; min-width:220px; background:#fff; box-shadow:0 4px 16px rgba(51,88,230,0.13); border-radius:10px; padding:1.2rem 1rem 1rem 1rem; z-index:100; text-align:right;">
                <div style="font-size:1.1rem; color:#3358e6; font-weight:700; margin-bottom:0.3rem;">{{ Auth::user()->name }}</div>
                <div style="font-size:0.97rem; color:#888; margin-bottom:0.7rem; direction:ltr;">{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn" style="width:100%;margin:0;">تسجيل الخروج</button>
                </form>
            </div>
        </div>
    </head>
    <body>
        <script>
            // User card dropdown logic
            document.addEventListener('DOMContentLoaded', function() {
                var userIcon = document.getElementById('userIcon');
                var userCard = document.getElementById('userCard');
                if(userIcon && userCard) {
                    userIcon.addEventListener('click', function(e) {
                        e.stopPropagation();
                        userCard.style.display = userCard.style.display === 'block' ? 'none' : 'block';
                    });
                    document.addEventListener('click', function() {
                        userCard.style.display = 'none';
                    });
                }
            });
        </script>
    </div>
    <div class="dashboard-main">
        <div class="cards">
            <div class="card">
                <div class="card-title">Total Decisions</div>
                <div class="card-value">206</div>
            </div>
            <div class="card">
                <div class="card-title">Country</div>
                <div class="card-value">71</div>
            </div>
            <div class="card">
                <div class="card-title">Region</div>
                <div class="card-value">122</div>
            </div>
            <div class="card">
                <div class="card-title">Banned</div>
                <div class="card-value">164</div>
            </div>
            <div class="card">
                <div class="card-title">Lifted</div>
                <div class="card-value">42</div>
            </div>
        </div>
        <div class="tables-row">
            <div class="table-box">
                <div style="font-weight:700; color:#3358e6; margin-bottom:0.5rem;">Cause</div>
                <table>
                    <tr>
                        <th>Cause</th>
                        <th>%</th>
                        <th>Country</th>
                        <th>Region</th>
                    </tr>
                    <tr class="highlight">
                        <td>HPAI</td>
                        <td>95.1%</td>
                        <td>67</td>
                        <td>116</td>
                    </tr>
                    <tr>
                        <td>FMD</td>
                        <td>2.9%</td>
                        <td>6</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td>Koi Herpes Virus</td>
                        <td>0.5%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>BSE</td>
                        <td>0.5%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>White Spot Syndrome</td>
                        <td>0.5%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Newcastle</td>
                        <td>0.5%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                </table>
            </div>
            <div class="table-box">
                <div style="font-weight:700; color:#3358e6; margin-bottom:0.5rem;">Products</div>
                <table>
                    <tr>
                        <th>Products</th>
                        <th>Decision</th>
                        <th>%</th>
                        <th>Country</th>
                        <th>Region</th>
                    </tr>
                    <tr class="highlight">
                        <td>Poultry</td>
                        <td>196</td>
                        <td>91.3%</td>
                        <td>67</td>
                        <td>117</td>
                    </tr>
                    <tr>
                        <td>Cattle & Sheep</td>
                        <td>4</td>
                        <td>3.9%</td>
                        <td>4</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>Cattle</td>
                        <td>2</td>
                        <td>1.9%</td>
                        <td>2</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Fish</td>
                        <td>1</td>
                        <td>1.0%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Shrimp</td>
                        <td>1</td>
                        <td>1.0%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Camel & Cattle & Sheep</td>
                        <td>1</td>
                        <td>1.0%</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="chart-row">
            <div class="chart-box">
                <div style="font-weight:700; color:#3358e6; margin-bottom:0.5rem;">No. of Decisions by Years</div>
                <canvas id="decisionsByYear" height="120"></canvas>
            </div>
            <div class="map-box">
                <div style="font-weight:700; color:#3358e6; margin-bottom:0.5rem;">World Map (عدد القرارات حسب الدولة)</div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/World_map_-_low_resolution.svg/1200px-World_map_-_low_resolution.svg.png" alt="World Map" style="width:100%; border-radius:8px; opacity:0.85;">
                <div style="text-align:center; color:#888; font-size:0.95rem; margin-top:0.5rem;">خريطة توضيحية فقط</div>
            </div>
        </div>
    </div>
    <script>
        // Chart.js for No. of Decisions by Years
        const ctx = document.getElementById('decisionsByYear').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023],
                datasets: [{
                    label: 'عدد القرارات',
                    data: [7,4,6,27,1,4,5,1,1,1,2,1,1,1,17,28,18,14,42],
                    backgroundColor: '#3358e6',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5 }
                    }
                }
            }
        });
    </script>
</body>
</html>
