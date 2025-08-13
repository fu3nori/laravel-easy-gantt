<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト詳細 - ガントチャートアプリ</title>
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
        
        .project-content {
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
    
    <!-- プロジェクトコンテンツ -->
    <div class="project-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1>プロジェクト詳細</h1>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-secondary rounded-button">ダッシュボードに戻る</a>
                    </div>
                    
                    <div class="alert alert-info">
                        <h4>プロジェクト情報</h4>
                        <p><strong>ユーザーID:</strong> {{ $userId }}</p>
                        <p><strong>プロジェクトID:</strong> {{ $projectId }}</p>
                        <p><strong>ユーザー名:</strong> {{ $userName }}</p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <p>このページは現在スタブ実装です。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
