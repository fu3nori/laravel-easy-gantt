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
                    <h1 class="text-center mb-4">プロジェクト管理</h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- プロジェクト作成フォーム -->
                    <div id="create" class="p-4 mb-4" style="background-color: #7fffd4; border-radius: 10px;">
                        <h3>プロジェクト作成</h3>
                        <form method="POST" action="{{ route('dashboard.create_project') }}" class="d-flex align-items-center">
                            @csrf
                            <div class="me-3">
                                <label for="project_name" class="form-label">プロジェクト名入力</label>
                                <input type="text" class="form-control" id="project_name" name="project_name" required>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary rounded-button">プロジェクト作成</button>
                            </div>
                        </form>
                    </div>

                    <!-- プロジェクト一覧 -->
                    <div id="list" class="p-4" style="background-color: skyblue; border-radius: 10px;">
                        <h3>プロジェクト一覧</h3>
                        @if($projects->count() > 0)
                            @foreach($projects as $project)
                                <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-white rounded">
                                    <span class="fw-bold">{{ $project->project_name }}</span>
                                    <div>
                                        <a href="{{ route('project.index', $project->id) }}" class="btn btn-primary rounded-button me-2">プロジェクトを開く</a>
                                        <form method="POST" action="{{ route('dashboard.delete_project', $project->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-button" onclick="return confirm('本当に削除しますか？')">プロジェクトを削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">プロジェクトがありません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
