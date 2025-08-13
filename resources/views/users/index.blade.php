<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ガントチャートアプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rounded-button {
            border-radius: 25px;
            padding: 10px 30px;
            border: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary.rounded-button {
            background-color: #007bff;
            color: white;
        }
        
        .btn-primary.rounded-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-success.rounded-button {
            background-color: #28a745;
            color: white;
        }
        
        .btn-success.rounded-button:hover {
            background-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .main-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body>
    <div class="main-container d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <!-- ログインフォーム -->
                <div class="col-md-5">
                    <div class="form-container">
                        <h2 class="text-center mb-4">ログイン</h2>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login_email" class="form-label">メールアドレス</label>
                                <input type="email" class="form-control" id="login_email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="login_password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="login_password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-button">ログイン</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- アカウント登録フォーム -->
                <div class="col-md-5">
                    <div class="form-container">
                        <h2 class="text-center mb-4">アカウント発行</h2>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="register_name" class="form-label">ユーザー名</label>
                                <input type="text" class="form-control" id="register_name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="register_email" class="form-label">メールアドレス</label>
                                <input type="email" class="form-control" id="register_email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="register_password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="register_password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="register_password_confirmation" class="form-label">パスワード（確認）</label>
                                <input type="password" class="form-control" id="register_password_confirmation" name="password_confirmation" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-button">新規登録</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
