<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード - ガントチャートアプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rounded-button {
            border-radius: 25px;
            padding: 8px 20px;
            border: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-danger.rounded-button {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger.rounded-button:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .logout-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .dashboard-content {
            padding: 80px 20px 20px 20px;
        }
    </style>
</head>
<body>
    <!-- ログアウトボタン -->
    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger rounded-button">ログアウト</button>
        </form>
    </div>
    
    <!-- ダッシュボードコンテンツ -->
    <div class="dashboard-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">ダッシュボード</h1>
                    <div class="alert alert-info text-center">
                        <h4>ようこそ、{{ Auth::user()->name }}さん！</h4>
                        <p>ガントチャートアプリのダッシュボードです。</p>
                        <p>このページは現在スタブ実装です。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
