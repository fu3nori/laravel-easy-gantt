<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト詳細 - ガントチャートアプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">
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
        
        .task-list {
            background-color: skyblue;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .gantt-container {
            position: relative;
            height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
        }
        
        .gantt-nav-buttons {
            position: absolute;
            top: 10px;
            z-index: 10;
        }
        
        .gantt-nav-left {
            left: 10px;
        }
        
        .gantt-nav-right {
            right: 10px;
        }
        
        .task-info {
            background-color: white;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
        }
        
        .task-info h6 {
            margin-bottom: 8px;
            color: #495057;
        }
        
        .task-info p {
            margin-bottom: 4px;
            font-size: 0.9em;
        }
        
        .task-edit-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-top: 8px;
        }
        
        .custom-checkbox {
            border: 2px solid #000 !important;
            border-radius: 3px !important;
            width: 16px !important;
            height: 16px !important;
        }
        
        .custom-checkbox:checked {
            background-color: #000 !important;
            border-color: #000 !important;
        }
        
        .custom-checkbox:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25) !important;
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
                        <h4>{{ $projectName }}</h4>
                        <p><strong>ユーザーID:</strong> {{ $userId }}</p>
                        <p><strong>プロジェクトID:</strong> {{ $projectId }}</p>
                        <p><strong>ユーザー名:</strong> {{ $userName }}</p>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- タスク登録フォーム -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">タスク登録</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('task.create') }}" class="row g-3 align-items-end">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $projectId }}">
                                <div class="col-md-3">
                                    <label for="task_name" class="form-label">タスク名</label>
                                    <input type="text" class="form-control" id="task_name" name="task_name" placeholder="タスク名" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="start_day" class="form-label">開始日</label>
                                    <input type="date" class="form-control" id="start_day" name="start_day" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="end_day" class="form-label">終了日</label>
                                    <input type="date" class="form-control" id="end_day" name="end_day" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary rounded-button">タスク作成</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- タスク一覧とガントチャート -->
                    <div class="task-list">
                        <div class="row">
                            <!-- ガントチャート表示エリア（左70%） -->
                            <div class="col-md-8">
                                <h5>ガントチャート</h5>
                                <div class="gantt-container">
                                    <div class="gantt-nav-buttons gantt-nav-left">
                                        <button class="btn btn-sm btn-secondary" onclick="moveGantt(-1)">戻る</button>
                                    </div>
                                    <div class="gantt-nav-buttons gantt-nav-right">
                                        <button class="btn btn-sm btn-secondary" onclick="moveGantt(1)">進める</button>
                                    </div>
                                    <canvas id="ganttCanvas" width="1000" height="400"></canvas>
                                </div>
                            </div>
                            
                            <!-- タスク情報表示エリア（右30%） -->
                            <div class="col-md-4">
                                <h5>タスク一覧</h5>
                                @if($tasks->count() > 0)
                                    @foreach($tasks as $task)
                                        <div class="task-info">
                                            <h6>{{ $task->task_name }}</h6>
                                            <div class="d-flex gap-3 mb-2">
                                                <div><strong>開始日:</strong> {{ $task->start_day->format('Y-m-d') }}</div>
                                                <div><strong>終了日:</strong> {{ $task->end_day->format('Y-m-d') }}</div>
                                            </div>
                                            
                                            <!-- タスク編集フォーム -->
                                            <form method="POST" action="{{ route('task.update', $task->id) }}" class="task-edit-form">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input custom-checkbox" type="checkbox" name="fix" id="fix_{{ $task->id }}" {{ $task->fix ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="fix_{{ $task->id }}">
                                                            FIX
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2 mb-2">
                                                    <div class="flex-fill">
                                                        <label class="form-label small mb-1">開始日</label>
                                                        <input type="date" class="form-control form-control-sm" name="start_day" value="{{ $task->start_day->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <label class="form-label small mb-1">終了日</label>
                                                        <input type="date" class="form-control form-control-sm" name="end_day" value="{{ $task->end_day->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-sm btn-primary rounded-button">更新</button>
                                                    
                                                    <!-- タスク削除ボタン（同じフォーム内に配置） -->
                                                    <button type="button" class="btn btn-sm btn-danger rounded-button" onclick="deleteTask({{ $task->id }})">タスク削除</button>
                                                </div>
                                            </form>
                                            
                                            <!-- タスク削除フォーム（隠しフォーム） -->
                                            <form id="deleteForm_{{ $task->id }}" method="POST" action="{{ route('task.delete', $task->id) }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            </form>
                                        </div>
                                    @endforeach
                                @else
                                    <p>タスクがありません。</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ガントチャートデータの準備
        const tasks = [
            @foreach($tasks as $task)
            {
                id: "{{ $task->id }}",
                name: "{{ addslashes($task->task_name) }}",
                start: "{{ $task->start_day->format('Y-m-d') }}",
                end: "{{ $task->end_day->format('Y-m-d') }}",
                fix: {{ $task->fix ? 'true' : 'false' }}
            }@if(!$loop->last),@endif
            @endforeach
        ];

        // ガントチャート変数
        let canvas, ctx;
        let currentDate = new Date();
        let daysToShow = 14; // 表示する日数
        let barHeight = 30;
        let barSpacing = 10;
        let headerHeight = 40;
        let leftMargin = 200; // タスク名表示エリアを広げる

        // ガントチャートの初期化
        function initGantt() {
            console.log('Initializing custom Gantt with tasks:', tasks);
            
            canvas = document.getElementById('ganttCanvas');
            ctx = canvas.getContext('2d');
            
            if (tasks.length === 0) {
                ctx.fillStyle = '#666';
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('タスクがありません。ガントチャートを表示するにはタスクを作成してください。', canvas.width / 2, canvas.height / 2);
                return;
            }
            
            // タスク数に応じてキャンバスの高さを動的に調整
            const requiredHeight = headerHeight + (tasks.length * (barHeight + barSpacing)) + barSpacing;
            canvas.height = Math.max(400, requiredHeight);
            
            drawGantt();
        }

        // ガントチャートの描画
        function drawGantt() {
            // キャンバスをクリア
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // 背景を描画
            ctx.fillStyle = '#f8f9fa';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            // ヘッダーを描画
            drawHeader();
            
            // タスクバーを描画
            drawTaskBars();
            
            // 日付の縦線を描画（最後に描画して前面に表示）
            drawDateLines();
            
            // タスク名を描画（最前面に表示）
            drawTaskNames();
        }

        // ヘッダーの描画
        function drawHeader() {
            ctx.fillStyle = '#e9ecef';
            ctx.fillRect(0, 0, canvas.width, headerHeight);
            
            // タスク名ヘッダー
            ctx.fillStyle = '#495057';
            ctx.font = 'bold 12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('タスク名', leftMargin / 2, headerHeight / 2 + 4);
            
            // 日付ヘッダー
            ctx.fillStyle = '#495057';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            
            for (let i = 0; i < daysToShow; i++) {
                const date = new Date(currentDate);
                date.setDate(date.getDate() + i);
                const x = leftMargin + (i * 50);
                const dateStr = date.toLocaleDateString('ja-JP', { month: 'short', day: 'numeric' });
                ctx.fillText(dateStr, x + 25, headerHeight / 2 + 4);
            }
        }

        // タスクバーの描画
        function drawTaskBars() {
            tasks.forEach((task, index) => {
                const y = headerHeight + (index * (barHeight + barSpacing)) + barSpacing;
                
                // タスクバーを描画（左マージン以降の領域のみ）
                const startDate = new Date(task.start);
                const endDate = new Date(task.end);
                let startX = getDateX(startDate);
                let endX = getDateX(endDate);
                
                // タスクバーが左マージンより左にある場合は調整
                if (startX < leftMargin) {
                    startX = leftMargin;
                }
                
                const width = endX - startX;
                
                // バーの色を設定（FIX=1ならブルー、FIX=0ならライムグリーン）
                ctx.fillStyle = task.fix ? '#007bff' : '#32cd32';
                ctx.fillRect(startX, y, width, barHeight);
                
                // バーの枠線（より太くして見やすく）
                ctx.strokeStyle = '#495057';
                ctx.lineWidth = 2;
                ctx.strokeRect(startX, y, width, barHeight);
            });
        }

        // 日付の縦線を描画
        function drawDateLines() {
            ctx.strokeStyle = '#28a745';
            ctx.lineWidth = 2;
            
            // 各日付の境界線を描画
            for (let i = 0; i <= daysToShow; i++) {
                const x = leftMargin + (i * 50);
                ctx.beginPath();
                ctx.moveTo(x, headerHeight);
                ctx.lineTo(x, canvas.height);
                ctx.stroke();
            }
            
            // 左マージンの境界線を太く描画
            ctx.strokeStyle = '#155724';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(leftMargin, headerHeight);
            ctx.lineTo(leftMargin, canvas.height);
            ctx.stroke();
        }

        // タスク名を描画
        function drawTaskNames() {
            tasks.forEach((task, index) => {
                const y = headerHeight + (index * (barHeight + barSpacing)) + barSpacing;
                
                // タスク名の背景を白で塗りつぶしてから描画
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(5, y - 5, leftMargin - 10, barHeight + 10);
                
                ctx.fillStyle = '#495057';
                ctx.font = '12px Arial';
                ctx.textAlign = 'left';
                
                // タスク名が長い場合は省略表示
                let displayName = task.name;
                if (task.name.length > 20) {
                    displayName = task.name.substring(0, 17) + '...';
                }
                ctx.fillText(displayName, 10, y + barHeight / 2 + 4);
            });
        }

        // 日付をX座標に変換
        function getDateX(date) {
            const diffTime = date.getTime() - currentDate.getTime();
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            return leftMargin + (diffDays * 50);
        }

        // ガントチャートの移動
        function moveGantt(direction) {
            currentDate.setDate(currentDate.getDate() + direction);
            drawGantt();
        }

        // タスク削除関数
        function deleteTask(taskId) {
            if (confirm('本当に削除しますか？')) {
                document.getElementById('deleteForm_' + taskId).submit();
            }
        }

        // ページ読み込み時にガントチャートを初期化
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing custom Gantt...');
            initGantt();
        });

        // タスク更新後にガントチャートを再描画
        function refreshGantt() {
            // ページをリロードして最新データを取得
            location.reload();
        }
    </script>
    <style>
        #ganttCanvas {
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
        }
    </style>
</body>
</html>
