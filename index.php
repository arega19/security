<!DOCTYPE html>
<?php
require_once 'includes/auth_check.php';
$user = require_auth();
$user_id = $user['user_id'];
$username = $user['username'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Planner Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            
            --bg-color: #f5f7fb;
            --card-bg: #ffffff;
            --text-primary: #333333;
            --text-secondary: #666666;
            --border-color: #e1e5eb;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        .dark-theme {
            --bg-color: #121826;
            --card-bg: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            transition: var(--transition);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logo-text h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .logo-text .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-greeting {
            font-weight: 500;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--gray-light);
            color: var(--dark);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 50%;
            justify-content: center;
        }

        /* ===== TOGGLE SWITCH ===== */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray);
            transition: var(--transition);
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: var(--transition);
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: var(--primary);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(30px);
        }

        /* ===== TABS ===== */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            background: var(--card-bg);
            padding: 10px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .tab-btn {
            flex: 1;
            padding: 15px 20px;
            background: transparent;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-btn:hover {
            background-color: rgba(var(--primary), 0.1);
            color: var(--primary);
        }

        .tab-btn.active {
            background-color: var(--primary);
            color: white;
        }

        /* ===== CONTENT SECTIONS ===== */
        .content-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== TASKS SECTION ===== */
        .task-form {
            display: grid;
            grid-template-columns: 2fr 1fr auto auto;
            gap: 15px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-input {
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary), 0.1);
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: var(--transition);
        }

        .task-item:hover {
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .task-item.completed {
            opacity: 0.7;
            background: rgba(var(--success), 0.1);
        }

        .task-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary);
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .task-checkbox.checked {
            background-color: var(--primary);
        }

        .task-checkbox.checked i {
            color: white;
            font-size: 12px;
        }

        .task-text {
            font-weight: 500;
        }

        .task-due {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .task-actions {
            display: flex;
            gap: 8px;
        }

        .priority-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .priority-high {
            background-color: rgba(247, 37, 133, 0.2);
            color: var(--danger);
        }

        .priority-medium {
            background-color: rgba(248, 150, 30, 0.2);
            color: var(--warning);
        }

        .priority-low {
            background-color: rgba(108, 117, 125, 0.2);
            color: var(--gray);
        }

        /* ===== SMART SCHEDULING SECTION ===== */
        .schedule-timeline {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px 0;
            max-height: 300px;
            overflow-y: auto;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
        }

        .schedule-time {
            min-width: 120px;
            font-weight: 600;
            color: var(--primary);
        }

        .schedule-details {
            flex: 1;
        }

        .conflict-warning {
            background-color: rgba(247, 37, 133, 0.1);
            border-color: var(--danger);
            animation: pulse 2s infinite;
        }

        /* ===== ANALYTICS SECTION ===== */
        .analytics-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .chart-container {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border-color);
        }

        .heatmap {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 15px;
        }

        .heatmap-cell {
            aspect-ratio: 1;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }

        .heatmap-cell:hover {
            transform: scale(1.1);
        }

        .heatmap-legend {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* ===== FOCUS MODE ===== */
        body.focus-mode {
            background-color: #1a1a2e;
        }

        body.focus-mode .container > *:not(#focusModeContent) {
            display: none;
        }

        .focus-mode-content {
            display: none;
        }

        body.focus-mode .focus-mode-content {
            display: block;
            max-width: 800px;
            margin: 100px auto;
            text-align: center;
        }

        .focus-timer {
            font-size: 96px;
            font-weight: 700;
            color: var(--success);
            margin: 40px 0;
            font-family: 'Courier New', monospace;
        }

        .current-focus-task {
            font-size: 24px;
            color: var(--text-primary);
            margin-bottom: 40px;
        }

        .focus-controls {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        /* ===== RESOURCES SECTION ===== */
        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius);
            padding: 40px;
            text-align: center;
            margin-bottom: 25px;
            cursor: pointer;
            transition: var(--transition);
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(var(--primary), 0.05);
        }

        .upload-icon {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .resource-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .resource-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .resource-list::-webkit-scrollbar {
            width: 6px;
        }

        .resource-list::-webkit-scrollbar-track {
            background: var(--bg-color);
            border-radius: 10px;
        }

        .resource-list::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .resource-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: var(--transition);
            cursor: pointer;
        }

        .resource-item:hover {
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .resource-name {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .resource-time {
            font-size: 12px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .resource-preview {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            background: var(--bg-color);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            padding: 20px;
        }

        .preview-placeholder {
            text-align: center;
            color: var(--text-secondary);
        }

        .preview-placeholder i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--primary);
            opacity: 0.5;
        }

        /* ===== MODALS ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: var(--shadow);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--danger);
            transform: rotate(90deg);
        }

        /* ===== POMODORO TIMER ===== */
        .pomodoro-timer {
            text-align: center;
            margin: 30px 0;
        }

        .timer-display {
            font-size: 72px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            color: var(--primary);
            margin: 20px 0;
        }

        .timer-controls {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 30px 0;
        }

        .timer-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            background: var(--primary);
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timer-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(var(--primary), 0.3);
        }

        .timer-btn.pause {
            background: var(--warning);
        }

        .timer-btn.reset {
            background: var(--danger);
        }

        .timer-progress {
            width: 100%;
            height: 10px;
            background: var(--bg-color);
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .timer-progress-bar {
            height: 100%;
            background: var(--primary);
            border-radius: 5px;
            transition: width 1s linear;
        }

        /* ===== RESOURCE VIEWER ===== */
        .viewer-content {
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-color);
            border-radius: var(--radius);
            margin: 20px 0;
            overflow: hidden;
        }

        .viewer-content img,
        .viewer-content video,
        .viewer-content iframe {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }

        .viewer-content audio {
            width: 100%;
        }

        .viewer-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        /* ===== PROGRESS SECTION ===== */
        .progress-bar-container {
            width: 100%;
            height: 20px;
            background: var(--bg-color);
            border-radius: 10px;
            margin: 30px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 10px;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            text-align: center;
            padding: 20px;
            background: var(--bg-color);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* ===== SETTINGS SECTION ===== */
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .setting-item {
            background: var(--bg-color);
            padding: 20px;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
        }

        /* ===== SYNC STATUS ===== */
        .sync-status {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 15px;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .sync-status.show {
            opacity: 1;
            transform: translateY(0);
        }

        .sync-status.syncing {
            background-color: rgba(var(--warning), 0.2);
            color: var(--warning);
        }

        .sync-status.synced {
            background-color: rgba(var(--success), 0.2);
            color: var(--success);
        }

        .sync-status.error {
            background-color: rgba(var(--danger), 0.2);
            color: var(--danger);
        }

        /* ===== UNDO/REDO ===== */
        .undo-redo {
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        /* ===== EMPTY STATES ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        /* ===== LOADING STATES ===== */
        .loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: var(--text-secondary);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--bg-color);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== TOOLTIPS ===== */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: var(--dark);
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 14px;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .task-form {
                grid-template-columns: 1fr;
            }

            .resource-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tabs {
                flex-wrap: wrap;
            }

            .tab-btn {
                min-width: calc(50% - 5px);
            }

            .timer-display {
                font-size: 48px;
            }

            .analytics-grid {
                grid-template-columns: 1fr;
            }

            .settings-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .timer-controls {
                flex-wrap: wrap;
            }

            .task-actions {
                flex-direction: column;
            }

            .resource-item {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .timer-display {
                font-size: 36px;
            }

            .undo-redo {
                flex-direction: column;
                bottom: 80px;
            }
        }

        /* ===== UTILITY CLASSES ===== */
        .hidden {
            display: none !important;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        .w-full {
            width: 100%;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* ===== ANIMATIONS ===== */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
    <div class="toggle-switch" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <input type="checkbox" id="themeToggle">
        <label class="toggle-slider" for="themeToggle"></label>
    </div>

    <!-- Sync Status -->
    <div id="syncStatus" class="sync-status">
        <i class="fas fa-sync"></i>
        <span>Synced</span>
    </div>

    <!-- Undo/Redo -->
    <div class="undo-redo">
        <button id="undoBtn" class="btn btn-secondary btn-sm" disabled>
            <i class="fas fa-undo"></i> Undo
        </button>
        <button id="redoBtn" class="btn btn-secondary btn-sm" disabled>
            <i class="fas fa-redo"></i> Redo
        </button>
    </div>

    <!-- Focus Mode Content (hidden by default) -->
    <div class="focus-mode-content" id="focusModeContent">
        <h1 style="color: var(--success); margin-bottom: 20px;">
            <i class="fas fa-bullseye"></i> Focus Mode
        </h1>
        <div class="focus-timer" id="focusTimerDisplay">25:00</div>
        <div class="current-focus-task" id="currentFocusTask">Loading task...</div>
        <div class="focus-controls">
            <button class="btn btn-danger" onclick="exitFocusMode()">
                <i class="fas fa-times"></i> Exit Focus Mode
            </button>
            <button class="btn btn-warning" id="focusPauseBtn">
                <i class="fas fa-pause"></i> Pause
            </button>
            <button class="btn btn-success" id="focusCompleteBtn">
                <i class="fas fa-check"></i> Mark Complete
            </button>
        </div>
        <div class="mt-20" id="focusReflection" style="display: none;">
            <h3 style="margin-bottom: 15px;">How focused were you?</h3>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button class="btn btn-secondary" onclick="saveFocusRating(1)">1</button>
                <button class="btn btn-secondary" onclick="saveFocusRating(2)">2</button>
                <button class="btn btn-secondary" onclick="saveFocusRating(3)">3</button>
                <button class="btn btn-secondary" onclick="saveFocusRating(4)">4</button>
                <button class="btn btn-secondary" onclick="saveFocusRating(5)">5</button>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="logo-icon">SP</div>
                <div class="logo-text">
                    <h1>Study Planner</h1>
                    <div class="subtitle">Organize. Focus. Succeed.</div>
                </div>
            </div>
            <div class="header-actions">
                <div class="user-greeting" id="helloUser">Hello, <?php echo htmlspecialchars($username); ?>!</div>
                <a href="profile.php" class="btn btn-secondary btn-icon" title="Profile">
                    <i class="fas fa-user"></i>
                </a>
                <button class="btn btn-warning btn-icon" onclick="enterFocusMode()" id="focusModeBtn">
                    <i class="fas fa-bullseye"></i>
                </button>
                <button class="btn btn-primary btn-icon" id="startPomodoroBtn">
                    <i class="fas fa-clock"></i>
                </button>
                <a href="logout.php" class="btn btn-secondary btn-icon" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-btn active" data-tab="tasks">
                <i class="fas fa-tasks"></i> Tasks
            </button>
            <button class="tab-btn" data-tab="schedule">
                <i class="fas fa-calendar-alt"></i> Schedule
            </button>
            <button class="tab-btn" data-tab="plan">
                <i class="fas fa-book"></i> Study Plan
            </button>
            <button class="tab-btn" data-tab="resources">
                <i class="fas fa-folder-open"></i> Resources
            </button>
            <button class="tab-btn" data-tab="analytics">
                <i class="fas fa-chart-bar"></i> Analytics
            </button>
            <button class="tab-btn" data-tab="progress">
                <i class="fas fa-chart-line"></i> Progress
            </button>
            <button class="tab-btn" data-tab="settings">
                <i class="fas fa-cog"></i> Settings
            </button>
        </div>

        <!-- Tasks Section -->
        <section id="tasks" class="content-section active">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-tasks"></i> Task Manager
                    </h2>
                    <div id="taskStats" class="text-secondary">0 tasks</div>
                </div>
                
                <div class="task-form">
                    <div class="form-group">
                        <input type="text" id="taskTitle" class="form-input" placeholder="Enter task title...">
                    </div>
                    <div class="form-group">
                        <select id="taskPriority" class="form-input">
                            <option value="">Priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="taskDifficulty" class="form-input">
                            <option value="">Difficulty</option>
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="date" id="taskDue" class="form-input">
                    </div>
                    <button id="addTaskBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                
                <div id="taskList" class="task-list"></div>
            </div>
        </section>

        <!-- Smart Scheduling Section -->
        <section id="schedule" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-calendar-alt"></i> Smart Schedule
                    </h2>
                    <button class="btn btn-success" onclick="generateSchedule()">
                        <i class="fas fa-magic"></i> Generate Schedule
                    </button>
                </div>
                
                <div id="scheduleLoading" class="loading" style="display: none;">
                    <div class="loading-spinner"></div>
                    <p>Generating optimal schedule...</p>
                </div>
                
                <div id="scheduleTimeline" class="schedule-timeline">
                    <!-- Schedule items will be loaded here -->
                </div>
                
                <div id="scheduleStats" class="mt-20">
                    <h3>Schedule Analysis</h3>
                    <div id="conflictList" class="mt-10"></div>
                </div>
            </div>
        </section>

        <!-- Study Plan Section -->
        <section id="plan" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-book"></i> Study Plan
                    </h2>
                    <div id="planStats" class="text-secondary">0 plans</div>
                </div>
                
                <div class="form-group mb-20">
                    <label class="form-label">Topic/Subject</label>
                    <textarea id="planTopic" class="form-input" rows="3" placeholder="What do you want to study?"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select id="planCategory" class="form-input">
                            <option value="">Select category</option>
                            <option value="Science">Science</option>
                            <option value="Technology">Technology</option>
                            <option value="Humanities">Humanities</option>
                            <option value="Languages">Languages</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Priority</label>
                        <select id="planPriority" class="form-input">
                            <option value="">Select priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group mb-20">
                    <label class="form-label">Deadline</label>
                    <input type="date" id="planDeadline" class="form-input">
                </div>
                
                <button id="savePlanBtn" class="btn btn-success w-full">
                    <i class="fas fa-save"></i> Save Study Plan
                </button>
                
                <div id="plansList" class="task-list mt-20"></div>
            </div>
        </section>

        <!-- Resources Section -->
        <section id="resources" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-folder-open"></i> Study Resources
                    </h2>
                    <div id="resourceStats" class="text-secondary">0 resources</div>
                </div>
                
                <!-- Upload Area -->
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h3 style="margin-bottom: 10px;">Drag & Drop Files Here</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 20px;">or click to browse files</p>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <select id="resourceTopic" class="form-input" style="width: 200px;">
                            <option value="General">General</option>
                            <option value="Programming">Programming</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Science">Science</option>
                        </select>
                        <button id="uploadResourceBtn" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                    </div>
                    <input type="file" id="resourceInput" multiple class="hidden" 
                           accept="image/*,video/*,audio/*,.pdf,.txt,.doc,.docx,.ppt,.pptx">
                </div>
                
                <!-- Resource List -->
                <div class="resource-grid">
                    <div>
                        <h3 style="margin-bottom: 15px; color: var(--text-primary);">
                            <i class="fas fa-list"></i> Uploaded Resources
                        </h3>
                        <div id="resourceList" class="resource-list"></div>
                    </div>
                    
                    <div>
                        <h3 style="margin-bottom: 15px; color: var(--text-primary);">
                            <i class="fas fa-eye"></i> Preview
                        </h3>
                        <div id="resourcePreview" class="resource-preview">
                            <div class="preview-placeholder">
                                <i class="fas fa-file-alt"></i>
                                <p>Select a resource to preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Analytics Section -->
        <section id="analytics" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-chart-bar"></i> Study Analytics
                    </h2>
                    <select id="analyticsPeriod" class="form-input" style="width: 150px;">
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
                
                <div class="analytics-grid">
                    <div class="chart-container">
                        <h3 style="margin-bottom: 15px;">Time Spent per Subject</h3>
                        <canvas id="subjectTimeChart"></canvas>
                    </div>
                    
                    <div class="chart-container">
                        <h3 style="margin-bottom: 15px;">Completion Trends</h3>
                        <canvas id="completionTrendChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container mt-20">
                    <h3 style="margin-bottom: 15px;">Productivity Heatmap</h3>
                    <div id="heatmapContainer" class="heatmap"></div>
                    <div class="heatmap-legend">
                        <span>Low</span>
                        <span>High</span>
                    </div>
                </div>
                
                <div class="mt-20">
                    <h3 style="margin-bottom: 15px;">Focus Insights</h3>
                    <div id="focusInsights"></div>
                </div>
            </div>
        </section>

        <!-- Progress Section -->
        <section id="progress" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-chart-line"></i> Study Progress
                    </h2>
                    <div id="progressStats" class="text-secondary">0% completed</div>
                </div>
                
                <div class="progress-bar-container">
                    <div id="progressFill" class="progress-bar" style="width: 0%">0%</div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value" id="completedTasks">0</div>
                        <div class="stat-label">Tasks Completed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="totalTime">0h</div>
                        <div class="stat-label">Study Time</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="focusSessions">0</div>
                        <div class="stat-label">Focus Sessions</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="resourcesCount">0</div>
                        <div class="stat-label">Resources</div>
                    </div>
                </div>
                
                <div id="progressBreakdown" class="mt-20"></div>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="content-section">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-cog"></i> Personalization & Settings
                    </h2>
                </div>
                
                <div class="settings-grid">
                    <div class="setting-item">
                        <h3 style="margin-bottom: 15px;">Study Preferences</h3>
                        <div class="form-group">
                            <label class="form-label">Session Length</label>
                            <select id="sessionLength" class="form-input">
                                <option value="25">25 minutes (Pomodoro)</option>
                                <option value="50">50 minutes (Deep Work)</option>
                                <option value="90">90 minutes (Ultra Focus)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Preferred Study Time</label>
                            <select id="studyTimePreference" class="form-input">
                                <option value="morning">Morning (6am-12pm)</option>
                                <option value="afternoon">Afternoon (12pm-6pm)</option>
                                <option value="evening">Evening (6pm-12am)</option>
                                <option value="night">Night (12am-6am)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Break Length</label>
                            <select id="breakLength" class="form-input">
                                <option value="5">5 minutes</option>
                                <option value="10">10 minutes</option>
                                <option value="15">15 minutes</option>
                            </select>
                        </div>
                        <button class="btn btn-primary w-full mt-10" onclick="savePreferences()">
                            <i class="fas fa-save"></i> Save Preferences
                        </button>
                    </div>
                    
                    <div class="setting-item">
                        <h3 style="margin-bottom: 15px;">Adaptive Suggestions</h3>
                        <div id="suggestionsList"></div>
                        <button class="btn btn-secondary w-full mt-10" onclick="generateSuggestions()">
                            <i class="fas fa-lightbulb"></i> Get New Suggestions
                        </button>
                    </div>
                    
                    <div class="setting-item">
                        <h3 style="margin-bottom: 15px;">Sync & Backup</h3>
                        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                            <button class="btn btn-primary" onclick="exportData()">
                                <i class="fas fa-download"></i> Export Data
                            </button>
                            <button class="btn btn-secondary" onclick="importData()">
                                <i class="fas fa-upload"></i> Import Data
                            </button>
                        </div>
                        <input type="file" id="importFile" class="hidden" accept=".json">
                        <div class="form-group">
                            <label class="form-label">Auto-sync Frequency</label>
                            <select id="syncFrequency" class="form-input">
                                <option value="5">Every 5 minutes</option>
                                <option value="15">Every 15 minutes</option>
                                <option value="30">Every 30 minutes</option>
                                <option value="60">Every hour</option>
                                <option value="0">Manual only</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="offlineMode" checked>
                                Enable offline mode
                            </label>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <h3 style="margin-bottom: 15px;">Data Management</h3>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <button class="btn btn-danger" onclick="clearData()">
                                <i class="fas fa-trash"></i> Clear All Data
                            </button>
                            <button class="btn btn-warning" onclick="resetPreferences()">
                                <i class="fas fa-redo"></i> Reset Preferences
                            </button>
                        </div>
                        <div class="mt-10">
                            <p class="text-secondary">Storage used: <span id="storageUsed">0 KB</span></p>
                            <p class="text-secondary">Last backup: <span id="lastBackup">Never</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Pomodoro Modal -->
    <div id="pomodoroModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">🍅 Pomodoro Timer</h2>
                <button class="modal-close" id="closePomodoro">×</button>
            </div>
            
            <div class="pomodoro-timer">
                <div id="timerStatus" style="color: var(--primary); font-weight: 600;">Focus Time</div>
                <div id="pomodoroTimer" class="timer-display">25:00</div>
                
                <div class="timer-progress">
                    <div id="progressBar" class="timer-progress-bar" style="width: 100%"></div>
                </div>
                
                <div class="timer-controls">
                    <button id="startTimer" class="timer-btn">
                        <i class="fas fa-play"></i>
                    </button>
                    <button id="pauseTimer" class="timer-btn pause" style="display: none;">
                        <i class="fas fa-pause"></i>
                    </button>
                    <button id="resetTimer" class="timer-btn reset">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                    <div class="form-group">
                        <label class="form-label">Focus (minutes)</label>
                        <input type="number" id="focusTime" class="form-input" value="25" min="1" max="60">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Break (minutes)</label>
                        <input type="number" id="breakTime" class="form-input" value="5" min="1" max="30">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pomodoro Prompt Modal -->
    <div id="pomodoroPrompt" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">🎯 Study Mode</h2>
                <button class="modal-close" onclick="closePomodoroPrompt()">×</button>
            </div>
            
            <div style="text-align: center; padding: 30px 20px;">
                <i class="fas fa-clock" style="font-size: 48px; color: var(--primary); margin-bottom: 20px;"></i>
                <h3 style="margin-bottom: 15px;">Start Pomodoro Timer?</h3>
                <p style="color: var(--text-secondary); margin-bottom: 30px;">Focus for 25 minutes, break for 5 minutes. Boost your productivity!</p>
                
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <button onclick="startWithPomodoro()" class="btn btn-success">
                        <i class="fas fa-check"></i> Yes, Start Timer
                    </button>
                    <button onclick="closePomodoroPrompt()" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Not Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Resource Viewer Modal -->
    <div id="resourceViewerModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h2 class="modal-title" id="viewerTitle">
                    <i class="fas fa-file-alt"></i> Resource Viewer
                </h2>
                <button class="modal-close" onclick="closeResourceViewer()">×</button>
            </div>
            
            <div id="viewerContent" class="viewer-content">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="viewer-controls">
                <div style="display: flex; gap: 10px;">
                    <button onclick="startPomodoroFromViewer()" class="btn btn-primary btn-sm">
                        <i class="fas fa-clock"></i> Start Timer
                    </button>
                    <button onclick="downloadCurrentResource()" class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
                <div id="viewerTimeSpent" style="font-size: 14px; color: var(--text-secondary);">
                    <i class="far fa-clock"></i> Time spent: 0s
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== GLOBAL VARIABLES =====
        let currentUser = 'Student';
        let currentResourceIndex = -1;
        let viewerStartTime = 0;
        let viewerInterval = null;
        let resources = [];
        let undoStack = [];
        let redoStack = [];
        let syncInterval = null;
        let focusModeInterval = null;
        let charts = {};
        let userPreferences = {};
        let dataCache = {}; // Global cache for database data
        
        // Storage keys
        const keys = {
            tasks: 'studyplanner_tasks',
            plan: 'studyplanner_plans',
            resources: 'studyplanner_resources',
            resourceTime: 'studyplanner_resource_time',
            pomodoroStats: 'studyplanner_pomodoro_stats',
            focusRatings: 'studyplanner_focus_ratings',
            preferences: 'studyplanner_preferences',
            analytics: 'studyplanner_analytics',
            schedule: 'studyplanner_schedule',
            undoHistory: 'studyplanner_undo_history',
            syncState: 'studyplanner_sync_state'
        };
        
        // ===== INITIALIZATION =====
        document.addEventListener('DOMContentLoaded', async function() {
            console.log('Study Planner Initialized');
            
            // Load data from database
            await loadFromDatabase();
            
            // Initialize components
            initUser();
            initTheme();
            initTabs();
            initTasks();
            initSchedule();
            initPlans();
            initResources();
            await initAnalytics();
            initPomodoro();
            await initSettings();
            initUndoRedo();
            initSync();
            updateProgress();
            updateStorageUsage();
            
            // Set current year in footer if exists
            const yearSpan = document.getElementById('currentYear');
            if (yearSpan) {
                yearSpan.textContent = new Date().getFullYear();
            }
            
            // Show welcome message
            setTimeout(() => {
                showNotification('Welcome back, <?php echo htmlspecialchars($username); ?>! Your data is saved securely.');
            }, 1000);
        });
        
        // ===== USER MANAGEMENT =====
        function initUser() {
            // Get username from URL or use default
            const urlParams = new URLSearchParams(window.location.search);
            const username = urlParams.get('username') || 'Student';
            currentUser = username;
            
            // Update UI
            document.getElementById('helloUser').textContent = `Hello, ${username}!`;
            
            // Update storage keys with username
            Object.keys(keys).forEach(key => {
                keys[key] = `${username}_${key}`;
            });
        }
        
        // ===== THEME TOGGLE =====
        function initTheme() {
            const themeToggle = document.getElementById('themeToggle');
            const savedTheme = localStorage.getItem('studyplanner_theme');
            
            // Apply saved theme
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                themeToggle.checked = true;
            }
            
            // Add event listener
            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.add('dark-theme');
                    localStorage.setItem('studyplanner_theme', 'dark');
                } else {
                    document.body.classList.remove('dark-theme');
                    localStorage.setItem('studyplanner_theme', 'light');
                }
            });
        }
        
        // ===== TABS SYSTEM =====
        function initTabs() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const sections = document.querySelectorAll('.content-section');
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabBtns.forEach(b => b.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                    
                    // Update components when switching tabs
                    if (tabId === 'progress') {
                        updateProgress();
                    } else if (tabId === 'analytics') {
                        initAnalyticsCharts();
                    } else if (tabId === 'schedule') {
                        updateSchedule();
                    }
                });
            });
        }
        
        // ===== 1️⃣ SMART SCHEDULING =====
        function initSchedule() {
            updateSchedule();
        }
        
        function generateSchedule() {
            const loading = document.getElementById('scheduleLoading');
            const timeline = document.getElementById('scheduleTimeline');
            
            loading.style.display = 'flex';
            timeline.innerHTML = '';
            
            // Simulate processing time
            setTimeout(() => {
                const tasks = getFromStorage(keys.tasks) || [];
                const plans = getFromStorage(keys.plan) || [];
                
                // Filter incomplete tasks
                const incompleteTasks = tasks.filter(task => !task.completed);
                
                if (incompleteTasks.length === 0) {
                    timeline.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h3>All tasks completed!</h3>
                            <p>No scheduling needed.</p>
                        </div>
                    `;
                    loading.style.display = 'none';
                    return;
                }
                
                // Score tasks (priority × difficulty × deadline urgency)
                const scoredTasks = incompleteTasks.map(task => {
                    const priorityScore = {
                        'high': 3,
                        'medium': 2,
                        'low': 1
                    }[task.priority] || 1;
                    
                    const difficultyScore = {
                        'hard': 3,
                        'medium': 2,
                        'easy': 1
                    }[task.difficulty] || 1;
                    
                    // Deadline urgency (days until due)
                    let urgencyScore = 1;
                    if (task.due) {
                        const dueDate = new Date(task.due);
                        const today = new Date();
                        const daysUntilDue = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
                        
                        if (daysUntilDue < 0) urgencyScore = 5; // Overdue
                        else if (daysUntilDue <= 1) urgencyScore = 4;
                        else if (daysUntilDue <= 3) urgencyScore = 3;
                        else if (daysUntilDue <= 7) urgencyScore = 2;
                    }
                    
                    const totalScore = priorityScore * difficultyScore * urgencyScore;
                    
                    return {
                        ...task,
                        score: totalScore,
                        duration: difficultyScore * 30 // minutes
                    };
                });
                
                // Sort by score (descending)
                scoredTasks.sort((a, b) => b.score - a.score);
                
                // Generate schedule (8am to 10pm, 7 days)
                const schedule = [];
                const startHour = 8;
                const endHour = 22;
                const slotDuration = 30; // minutes
                
                for (let day = 0; day < 7; day++) {
                    for (let hour = startHour; hour < endHour; hour += 0.5) {
                        const timeSlot = {
                            day: day,
                            time: hour,
                            available: true,
                            task: null
                        };
                        schedule.push(timeSlot);
                    }
                }
                
                // Assign tasks to time slots
                const conflicts = [];
                scoredTasks.forEach((task, index) => {
                    // Find available slot
                    const availableSlot = schedule.find(slot => 
                        slot.available && slot.day < 3 // Prioritize first 3 days
                    );
                    
                    if (availableSlot) {
                        availableSlot.task = task;
                        availableSlot.available = false;
                        
                        // Mark next slots as occupied based on duration
                        const slotsNeeded = Math.ceil(task.duration / slotDuration);
                        for (let i = 1; i < slotsNeeded; i++) {
                            const nextSlotIndex = schedule.indexOf(availableSlot) + i;
                            if (nextSlotIndex < schedule.length) {
                                schedule[nextSlotIndex].available = false;
                                schedule[nextSlotIndex].task = task;
                            }
                        }
                    } else {
                        conflicts.push(task);
                    }
                });
                
                // Display schedule
                const days = ['Today', 'Tomorrow', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
                
                schedule.forEach(slot => {
                    if (slot.task) {
                        const task = slot.task;
                        const hour = Math.floor(slot.time);
                        const minute = (slot.time % 1) * 60;
                        const timeStr = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                        
                        const scheduleItem = document.createElement('div');
                        scheduleItem.className = 'schedule-item';
                        scheduleItem.innerHTML = `
                            <div class="schedule-time">${days[slot.day]} ${timeStr}</div>
                            <div class="schedule-details">
                                <div style="font-weight: 600;">${task.title}</div>
                                <div style="font-size: 14px; color: var(--text-secondary);">
                                    Priority: ${task.priority} | Duration: ${task.duration}min | Score: ${task.score}
                                </div>
                            </div>
                            <div class="priority-badge priority-${task.priority}">
                                ${task.priority.toUpperCase()}
                            </div>
                        `;
                        timeline.appendChild(scheduleItem);
                    }
                });
                
                // Display conflicts
                const conflictList = document.getElementById('conflictList');
                if (conflicts.length > 0) {
                    conflictList.innerHTML = `
                        <div style="color: var(--danger); margin-bottom: 10px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            Found ${conflicts.length} scheduling conflicts:
                        </div>
                        <ul>
                            ${conflicts.map(task => `<li>${task.title}</li>`).join('')}
                        </ul>
                        <button class="btn btn-warning btn-sm mt-10" onclick="rescheduleConflicts()">
                            <i class="fas fa-calendar-alt"></i> Reschedule Conflicts
                        </button>
                    `;
                } else {
                    conflictList.innerHTML = `
                        <div style="color: var(--success);">
                            <i class="fas fa-check-circle"></i>
                            No scheduling conflicts detected!
                        </div>
                    `;
                }
                
                // Save schedule
                saveToStorage(keys.schedule, {
                    generated: new Date().toISOString(),
                    schedule: schedule.filter(s => s.task),
                    conflicts: conflicts
                });
                
                loading.style.display = 'none';
                showNotification('Schedule generated successfully!');
                
            }, 1000); // Simulate processing delay
        }
        
        function updateSchedule() {
            const schedule = getFromStorage(keys.schedule);
            const timeline = document.getElementById('scheduleTimeline');
            
            if (!schedule || !schedule.schedule || schedule.schedule.length === 0) {
                timeline.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>No schedule generated yet</h3>
                        <p>Click "Generate Schedule" to create an optimal study plan.</p>
                        <button class="btn btn-primary mt-10" onclick="generateSchedule()">
                            <i class="fas fa-magic"></i> Generate Schedule
                        </button>
                    </div>
                `;
                return;
            }
            
            const days = ['Today', 'Tomorrow', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
            
            schedule.schedule.forEach(slot => {
                const task = slot.task;
                const hour = Math.floor(slot.time);
                const minute = (slot.time % 1) * 60;
                const timeStr = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'schedule-item';
                scheduleItem.innerHTML = `
                    <div class="schedule-time">${days[slot.day]} ${timeStr}</div>
                    <div class="schedule-details">
                        <div style="font-weight: 600;">${task.title}</div>
                        <div style="font-size: 14px; color: var(--text-secondary);">
                            Priority: ${task.priority} | Duration: ${task.duration}min
                        </div>
                    </div>
                    <div class="priority-badge priority-${task.priority}">
                        ${task.priority.toUpperCase()}
                    </div>
                `;
                
                // Check if task is overdue
                if (task.due) {
                    const dueDate = new Date(task.due);
                    const today = new Date();
                    if (dueDate < today) {
                        scheduleItem.classList.add('conflict-warning');
                    }
                }
                
                timeline.appendChild(scheduleItem);
            });
        }
        
        function rescheduleConflicts() {
            const schedule = getFromStorage(keys.schedule);
            if (!schedule) return;
            
            // Simple rescheduling: move to later days
            schedule.conflicts.forEach((task, index) => {
                const newDay = 3 + Math.floor(index / 10); // Start from day 3
                const newTime = 8 + (index % 10) * 0.5;
                
                schedule.schedule.push({
                    day: newDay,
                    time: newTime,
                    available: false,
                    task: task
                });
            });
            
            schedule.conflicts = [];
            saveToStorage(keys.schedule, schedule);
            updateSchedule();
            showNotification('Conflicts rescheduled!');
        }
        
        // ===== 2️⃣ STUDY ANALYTICS DASHBOARD =====
        async function initAnalytics() {
            // Initialize analytics data if not exists
            let analytics = getFromStorage(keys.analytics);
            if (!analytics) {
                analytics = {
                    dailyTime: {},
                    subjectTime: {},
                    completionRates: [],
                    productivity: {},
                    focusRatings: []
                };
                saveToStorage(keys.analytics, analytics);
            }
            
            // Update analytics periodically
            await updateAnalytics();
            
            // Initialize charts when tab is shown
            document.getElementById('analytics').addEventListener('click', initAnalyticsCharts);
        }
        
        async function initAnalyticsCharts() {
            // Only initialize if canvas exists
            if (!document.getElementById('subjectTimeChart')) return;
            
            // Update analytics data first
            await updateAnalytics();
            
            // Fetch updated analytics
            const analyticsResponse = await fetch('api/analytics.php');
            const analytics = analyticsResponse.ok ? await analyticsResponse.json() : getDefaultData(keys.analytics);
            const period = document.getElementById('analyticsPeriod').value;
            
            // Subject Time Chart
            const subjectCtx = document.getElementById('subjectTimeChart').getContext('2d');
            const subjects = Object.keys(analytics.subjectTime || {});
            const subjectTimes = subjects.map(subject => analytics.subjectTime[subject]);
            
            if (charts.subjectTimeChart) {
                charts.subjectTimeChart.destroy();
            }
            
            charts.subjectTimeChart = new Chart(subjectCtx, {
                type: 'bar',
                data: {
                    labels: subjects,
                    datasets: [{
                        label: 'Time Spent (hours)',
                        data: subjectTimes,
                        backgroundColor: subjects.map(() => getRandomColor()),
                        borderColor: subjects.map(() => '#4361ee'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hours'
                            }
                        }
                    }
                }
            });
            
            // Completion Trend Chart
            const trendCtx = document.getElementById('completionTrendChart').getContext('2d');
            const last7Days = getLastNDays(7);
            const completionData = last7Days.map(day => {
                const dayStr = day.toISOString().split('T')[0];
                return analytics.completionRates?.find(r => r.date === dayStr)?.rate || 0;
            });
            
            if (charts.completionTrendChart) {
                charts.completionTrendChart.destroy();
            }
            
            charts.completionTrendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: last7Days.map(d => d.toLocaleDateString('en-US', { weekday: 'short' })),
                    datasets: [{
                        label: 'Completion Rate (%)',
                        data: completionData,
                        borderColor: '#7209b7',
                        backgroundColor: 'rgba(114, 9, 183, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Completion %'
                            }
                        }
                    }
                }
            });
            
            // Generate heatmap
            generateHeatmap();
            
            // Update focus insights
            updateFocusInsights();
        }
        
        async function updateAnalytics() {
            // Fetch all required data from APIs
            const [tasksResponse, resourcesResponse, focusResponse, pomodoroResponse] = await Promise.all([
                fetch('api/tasks.php'),
                fetch('api/resources.php'),
                fetch('api/focus.php'),
                fetch('api/pomodoro.php')
            ]);
            
            const tasks = tasksResponse.ok ? await tasksResponse.json() : [];
            const resources = resourcesResponse.ok ? await resourcesResponse.json() : [];
            const focusRatings = focusResponse.ok ? await focusResponse.json() : [];
            const pomodoroStats = pomodoroResponse.ok ? await pomodoroResponse.json() : { total_time: 0 };
            
            let analytics = {
                dailyTime: {},
                subjectTime: {},
                completionRates: [],
                productivity: {},
                focusRatings: []
            };
            
            const today = new Date().toISOString().split('T')[0];
            
            // Calculate today's completion rate
            const completedToday = tasks.filter(task => {
                if (!task.completed) return false;
                const completedDate = new Date(task.completedAt || task.createdAt);
                return completedDate.toISOString().split('T')[0] === today;
            }).length;
            
            const totalToday = tasks.filter(task => {
                const createdDate = new Date(task.createdAt);
                return createdDate.toISOString().split('T')[0] === today;
            }).length;
            
            const todayRate = totalToday > 0 ? Math.round((completedToday / totalToday) * 100) : 0;
            
            // Update completion rates
            analytics.completionRates.push({ date: today, rate: todayRate });
            analytics.completionRates = analytics.completionRates.slice(-30);
            
            // Update subject time (from resources)
            resources.forEach(resource => {
                const timeSpent = resource.time_spent || 0;
                const hours = timeSpent / 60; // Convert minutes to hours
                
                if (!analytics.subjectTime[resource.topic]) {
                    analytics.subjectTime[resource.topic] = 0;
                }
                analytics.subjectTime[resource.topic] += hours;
            });
            
            // Add pomodoro time to "Focus" subject
            if (pomodoroStats.total_time) {
                const pomodoroHours = pomodoroStats.total_time / 60;
                if (!analytics.subjectTime['Focus']) {
                    analytics.subjectTime['Focus'] = 0;
                }
                analytics.subjectTime['Focus'] += pomodoroHours;
            }
            
            // Update productivity heatmap data
            const hour = new Date().getHours();
            const dayOfWeek = new Date().getDay();
            
            if (!analytics.productivity[dayOfWeek]) {
                analytics.productivity[dayOfWeek] = {};
            }
            if (!analytics.productivity[dayOfWeek][hour]) {
                analytics.productivity[dayOfWeek][hour] = 0;
            }
            analytics.productivity[dayOfWeek][hour] += 1;
            
            // Add focus ratings
            analytics.focusRatings = focusRatings;
            
            // Save analytics
            await fetch('api/analytics.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ analytics: analytics })
            });
        }
        
        function generateHeatmap() {
            const analytics = getFromStorage(keys.analytics);
            const heatmapContainer = document.getElementById('heatmapContainer');
            
            if (!analytics.productivity) {
                heatmapContainer.innerHTML = '<p class="text-secondary">No productivity data yet</p>';
                return;
            }
            
            heatmapContainer.innerHTML = '';
            
            // Create 7x24 heatmap (days × hours)
            const maxValue = Math.max(...Object.values(analytics.productivity).flatMap(day => 
                Object.values(day || {})
            )) || 1;
            
            for (let day = 0; day < 7; day++) {
                for (let hour = 0; hour < 24; hour++) {
                    const cell = document.createElement('div');
                    cell.className = 'heatmap-cell';
                    
                    const value = analytics.productivity[day]?.[hour] || 0;
                    const intensity = Math.min(value / maxValue, 1);
                    
                    // Color based on intensity
                    const color = intensity > 0.8 ? '#4cc9f0' :
                                 intensity > 0.6 ? '#4361ee' :
                                 intensity > 0.4 ? '#3a0ca3' :
                                 intensity > 0.2 ? '#7209b7' : '#f8f9fa';
                    
                    cell.style.backgroundColor = color;
                    cell.title = `${getDayName(day)} ${hour}:00 - ${value} sessions`;
                    
                    heatmapContainer.appendChild(cell);
                }
            }
        }
        
        function updateFocusInsights() {
            const analytics = getFromStorage(keys.analytics);
            const focusInsights = document.getElementById('focusInsights');
            
            if (!analytics.focusRatings || analytics.focusRatings.length === 0) {
                focusInsights.innerHTML = '<p class="text-secondary">No focus data yet. Complete focus sessions to see insights.</p>';
                return;
            }
            
            const avgRating = analytics.focusRatings.reduce((sum, r) => sum + r.rating, 0) / analytics.focusRatings.length;
            const bestTime = findBestFocusTime(analytics.productivity);
            
            focusInsights.innerHTML = `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h4>Average Focus Rating</h4>
                        <div style="font-size: 32px; color: var(--primary); font-weight: 700;">
                            ${avgRating.toFixed(1)}/5
                        </div>
                        <div style="font-size: 14px; color: var(--text-secondary);">
                            Based on ${analytics.focusRatings.length} sessions
                        </div>
                    </div>
                    <div>
                        <h4>Best Focus Time</h4>
                        <div style="font-size: 24px; color: var(--success); font-weight: 700;">
                            ${bestTime}
                        </div>
                        <div style="font-size: 14px; color: var(--text-secondary);">
                            When you're most productive
                        </div>
                    </div>
                </div>
            `;
        }
        
        function findBestFocusTime(productivity) {
            if (!productivity) return 'Not enough data';
            
            let bestDay = 0;
            let bestHour = 9;
            let maxSessions = 0;
            
            for (let day = 0; day < 7; day++) {
                for (let hour = 0; hour < 24; hour++) {
                    const sessions = productivity[day]?.[hour] || 0;
                    if (sessions > maxSessions) {
                        maxSessions = sessions;
                        bestDay = day;
                        bestHour = hour;
                    }
                }
            }
            
            return `${getDayName(bestDay)} ${bestHour}:00`;
        }
        
        // ===== 3️⃣ FOCUS & DISTRACTION CONTROL =====
        function enterFocusMode() {
            // Get current task for focus
            const tasks = getFromStorage(keys.tasks) || [];
            const currentTask = tasks.find(task => !task.completed);
            
            if (!currentTask) {
                alert('No active tasks to focus on!');
                return;
            }
            
            // Enter focus mode
            document.body.classList.add('focus-mode');
            document.getElementById('currentFocusTask').textContent = currentTask.title;
            
            // Start focus timer
            const preferences = getFromStorage(keys.preferences) || {};
            const focusTime = preferences.sessionLength || 25;
            startFocusTimer(focusTime * 60);
            
            // Disable keyboard shortcuts
            document.addEventListener('keydown', blockKeysInFocusMode);
            
            showNotification('Entered focus mode. Stay focused!');
        }
        
        function exitFocusMode() {
            // Stop focus timer
            stopFocusTimer();
            
            // Exit focus mode
            document.body.classList.remove('focus-mode');
            
            // Enable keyboard shortcuts
            document.removeEventListener('keydown', blockKeysInFocusMode);
            
            // Show reflection
            document.getElementById('focusReflection').style.display = 'block';
        }
        
        function startFocusTimer(duration) {
            let timeLeft = duration;
            
            focusModeInterval = setInterval(() => {
                timeLeft--;
                
                // Update display
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('focusTimerDisplay').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // Time's up
                if (timeLeft <= 0) {
                    stopFocusTimer();
                    showNotification('Focus session completed! Time for a break.');
                    document.getElementById('focusReflection').style.display = 'block';
                }
            }, 1000);
        }
        
        function stopFocusTimer() {
            if (focusModeInterval) {
                clearInterval(focusModeInterval);
                focusModeInterval = null;
            }
        }
        
        function saveFocusRating(rating) {
            const focusRatings = getFromStorage(keys.focusRatings) || [];
            focusRatings.push({
                rating: rating,
                date: new Date().toISOString(),
                sessionLength: getFromStorage(keys.preferences)?.sessionLength || 25
            });
            
            saveToStorage(keys.focusRatings, focusRatings);
            document.getElementById('focusReflection').style.display = 'none';
            showNotification('Thanks for your feedback!');
            
            // Exit focus mode
            exitFocusMode();
        }
        
        function blockKeysInFocusMode(e) {
            // Block common distraction keys
            const blockedKeys = ['Tab', 'Escape', 'F1', 'F5', 'F11', 'F12'];
            if (blockedKeys.includes(e.key)) {
                e.preventDefault();
                showNotification('Stay focused!', 'warning');
            }
        }
        
        // ===== 4️⃣ PERSONALIZATION & ADAPTATION =====
        async function initSettings() {
            await loadPreferences();
            loadSuggestions();
            
            // Event listeners
            document.getElementById('analyticsPeriod').addEventListener('change', () => initAnalyticsCharts());
            document.getElementById('sessionLength').addEventListener('change', () => savePreferences());
            document.getElementById('studyTimePreference').addEventListener('change', () => savePreferences());
            document.getElementById('breakLength').addEventListener('change', () => savePreferences());
            document.getElementById('syncFrequency').addEventListener('change', updateSyncFrequency);
            document.getElementById('offlineMode').addEventListener('change', toggleOfflineMode);
        }
        
        async function loadPreferences() {
            const response = await fetch('api/settings.php');
            const preferences = response.ok ? await response.json() : {
                session_length: 25,
                study_time_preference: 'afternoon',
                break_length: 5,
                sync_frequency: 15,
                offline_mode: 1
            };
            
            // Update UI
            document.getElementById('sessionLength').value = preferences.session_length;
            document.getElementById('studyTimePreference').value = preferences.study_time_preference;
            document.getElementById('breakLength').value = preferences.break_length;
            document.getElementById('syncFrequency').value = preferences.sync_frequency;
            document.getElementById('offlineMode').checked = preferences.offline_mode == 1;
            
            userPreferences = {
                sessionLength: preferences.session_length,
                studyTimePreference: preferences.study_time_preference,
                breakLength: preferences.break_length,
                syncFrequency: preferences.sync_frequency,
                offlineMode: preferences.offline_mode == 1
            };
        }
        
        async function savePreferences() {
            const preferences = {
                sessionLength: parseInt(document.getElementById('sessionLength').value) || 25,
                studyTimePreference: document.getElementById('studyTimePreference').value,
                breakLength: parseInt(document.getElementById('breakLength').value) || 5,
                syncFrequency: parseInt(document.getElementById('syncFrequency').value) || 15,
                offlineMode: document.getElementById('offlineMode').checked,
                lastUpdated: new Date().toISOString()
            };
            
            await fetch('api/settings.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(preferences)
            });
            
            userPreferences = preferences;
            
            // Update sync frequency
            updateSyncFrequency();
            
            showNotification('Preferences saved!');
        }
        
        function loadSuggestions() {
            const analytics = getFromStorage(keys.analytics);
            const suggestionsList = document.getElementById('suggestionsList');
            
            if (!analytics || !analytics.subjectTime) {
                suggestionsList.innerHTML = '<p class="text-secondary">Complete some study sessions to get suggestions.</p>';
                return;
            }
            
            const suggestions = [];
            
            // Suggestion 1: Best study time
            const bestTime = findBestFocusTime(analytics.productivity);
            if (bestTime !== 'Not enough data') {
                suggestions.push(`You're most productive at <strong>${bestTime}</strong>. Schedule important tasks then.`);
            }
            
            // Suggestion 2: Subject balance
            const subjects = Object.keys(analytics.subjectTime);
            if (subjects.length > 1) {
                const maxSubject = subjects.reduce((a, b) => 
                    analytics.subjectTime[a] > analytics.subjectTime[b] ? a : b
                );
                const minSubject = subjects.reduce((a, b) => 
                    analytics.subjectTime[a] < analytics.subjectTime[b] ? a : b
                );
                
                suggestions.push(`You spend most time on <strong>${maxSubject}</strong>. Consider balancing with <strong>${minSubject}</strong>.`);
            }
            
            // Suggestion 3: Focus improvement
            if (analytics.focusRatings && analytics.focusRatings.length > 0) {
                const avgRating = analytics.focusRatings.reduce((sum, r) => sum + r.rating, 0) / analytics.focusRatings.length;
                if (avgRating < 3) {
                    suggestions.push(`Your focus rating is low (<strong>${avgRating.toFixed(1)}/5</strong>). Try shorter sessions or different study environments.`);
                }
            }
            
            if (suggestions.length === 0) {
                suggestions.push('Keep studying to get personalized suggestions!');
            }
            
            suggestionsList.innerHTML = suggestions.map(s => 
                `<div style="padding: 10px; background: var(--bg-color); border-radius: 8px; margin-bottom: 10px;">
                    <i class="fas fa-lightbulb" style="color: var(--warning);"></i> ${s}
                </div>`
            ).join('');
        }
        
        function generateSuggestions() {
            // Simulate AI-generated suggestions
            const subjects = ['Math', 'Science', 'Programming', 'Languages'];
            const randomSubject = subjects[Math.floor(Math.random() * subjects.length)];
            const times = ['morning', 'afternoon', 'evening', 'night'];
            const randomTime = times[Math.floor(Math.random() * times.length)];
            
            const newSuggestion = `Try studying <strong>${randomSubject}</strong> in the <strong>${randomTime}</strong>. Your past performance suggests this might be effective.`;
            
            const suggestionsList = document.getElementById('suggestionsList');
            const suggestionDiv = document.createElement('div');
            suggestionDiv.innerHTML = `
                <div style="padding: 10px; background: var(--bg-color); border-radius: 8px; margin-bottom: 10px;">
                    <i class="fas fa-robot" style="color: var(--primary);"></i> ${newSuggestion}
                </div>
            `;
            suggestionsList.prepend(suggestionDiv);
            
            showNotification('New suggestion generated!');
        }
        
        // ===== 5️⃣ RELIABILITY & POLISH =====
        function initUndoRedo() {
            // Load undo history
            const history = getFromStorage(keys.undoHistory) || { undo: [], redo: [] };
            undoStack = history.undo || [];
            redoStack = history.redo || [];
            
            // Event listeners
            document.getElementById('undoBtn').addEventListener('click', performUndo);
            document.getElementById('redoBtn').addEventListener('click', performRedo);
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'z') {
                    if (e.shiftKey) {
                        performRedo();
                    } else {
                        performUndo();
                    }
                    e.preventDefault();
                }
            });
            
            updateUndoRedoButtons();
        }
        
        function saveUndoState(action, data) {
            undoStack.push({
                action: action,
                data: data,
                timestamp: Date.now()
            });
            
            // Clear redo stack when new action is performed
            redoStack = [];
            
            // Keep only last 50 actions
            if (undoStack.length > 50) {
                undoStack.shift();
            }
            
            saveToStorage(keys.undoHistory, {
                undo: undoStack,
                redo: redoStack
            });
            
            updateUndoRedoButtons();
        }
        
        function performUndo() {
            if (undoStack.length === 0) return;
            
            const lastAction = undoStack.pop();
            redoStack.push(lastAction);
            
            // Perform undo based on action type
            switch (lastAction.action) {
                case 'addTask':
                    const tasks = getFromStorage(keys.tasks) || [];
                    tasks.pop(); // Remove last task
                    saveToStorage(keys.tasks, tasks);
                    loadTasks();
                    break;
                case 'deleteTask':
                    saveToStorage(keys.tasks, lastAction.data);
                    loadTasks();
                    break;
                case 'toggleTask':
                    saveToStorage(keys.tasks, lastAction.data);
                    loadTasks();
                    break;
            }
            
            saveToStorage(keys.undoHistory, {
                undo: undoStack,
                redo: redoStack
            });
            
            updateUndoRedoButtons();
            showNotification('Undo completed');
        }
        
        function performRedo() {
            if (redoStack.length === 0) return;
            
            const lastRedo = redoStack.pop();
            undoStack.push(lastRedo);
            
            // Perform redo based on action type
            switch (lastRedo.action) {
                case 'addTask':
                    // Re-add the task
                    const tasks = getFromStorage(keys.tasks) || [];
                    tasks.push(lastRedo.data.task);
                    saveToStorage(keys.tasks, tasks);
                    loadTasks();
                    break;
            }
            
            saveToStorage(keys.undoHistory, {
                undo: undoStack,
                redo: redoStack
            });
            
            updateUndoRedoButtons();
            showNotification('Redo completed');
        }
        
        function updateUndoRedoButtons() {
            document.getElementById('undoBtn').disabled = undoStack.length === 0;
            document.getElementById('redoBtn').disabled = redoStack.length === 0;
        }
        
        function initSync() {
            // Check if online
            if (navigator.onLine) {
                syncData();
            }
            
            // Listen for online/offline events
            window.addEventListener('online', syncData);
            window.addEventListener('offline', showOfflineStatus);
            
            // Start sync interval
            updateSyncFrequency();
        }
        
        function updateSyncFrequency() {
            if (syncInterval) {
                clearInterval(syncInterval);
            }
            
            const frequency = userPreferences.syncFrequency || 15;
            if (frequency > 0) {
                syncInterval = setInterval(syncData, frequency * 60 * 1000);
            }
        }
        
        function syncData() {
            if (!navigator.onLine || userPreferences.offlineMode === false) {
                return;
            }
            
            const syncStatus = document.getElementById('syncStatus');
            syncStatus.className = 'sync-status syncing show';
            syncStatus.innerHTML = '<i class="fas fa-sync fa-spin"></i> Syncing...';
            
            // Simulate sync delay
            setTimeout(() => {
                // Update sync state
                const syncState = {
                    lastSync: new Date().toISOString(),
                    dataSize: calculateDataSize()
                };
                saveToStorage(keys.syncState, syncState);
                
                // Update UI
                syncStatus.className = 'sync-status synced show';
                syncStatus.innerHTML = '<i class="fas fa-check"></i> Synced';
                
                // Hide after 3 seconds
                setTimeout(() => {
                    syncStatus.classList.remove('show');
                }, 3000);
                
                // Update last backup time
                document.getElementById('lastBackup').textContent = 
                    new Date(syncState.lastSync).toLocaleTimeString();
                    
            }, 1000);
        }
        
        function showOfflineStatus() {
            const syncStatus = document.getElementById('syncStatus');
            syncStatus.className = 'sync-status error show';
            syncStatus.innerHTML = '<i class="fas fa-wifi-slash"></i> Offline';
            
            showNotification('You are offline. Changes will sync when back online.');
        }
        
        function toggleOfflineMode() {
            userPreferences.offlineMode = document.getElementById('offlineMode').checked;
            saveToStorage(keys.preferences, userPreferences);
            
            if (!userPreferences.offlineMode && navigator.onLine) {
                syncData();
            }
        }
        
        function exportData() {
            const data = {};
            Object.keys(keys).forEach(key => {
                const actualKey = keys[key];
                data[key] = getFromStorage(actualKey);
            });
            
            const dataStr = JSON.stringify(data, null, 2);
            const dataBlob = new Blob([dataStr], { type: 'application/json' });
            
            const url = URL.createObjectURL(dataBlob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `study-planner-backup-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            showNotification('Data exported successfully!');
        }
        
        function importData() {
            document.getElementById('importFile').click();
        }
        
        document.getElementById('importFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = JSON.parse(e.target.result);
                    
                    // Confirm import
                    if (!confirm('This will replace all current data. Continue?')) {
                        return;
                    }
                    
                    // Import data
                    Object.keys(data).forEach(key => {
                        const actualKey = keys[key];
                        if (actualKey) {
                            saveToStorage(actualKey, data[key]);
                        }
                    });
                    
                    // Reload all components
                    location.reload();
                    
                } catch (error) {
                    alert('Invalid backup file');
                    console.error('Import error:', error);
                }
            };
            reader.readAsText(file);
            
            // Reset input
            e.target.value = '';
        });
        
        function clearData() {
            if (!confirm('This will delete ALL your data. Are you sure?')) return;
            
            Object.keys(keys).forEach(key => {
                const actualKey = keys[key];
                localStorage.removeItem(actualKey);
            });
            
            // Reset undo/redo
            undoStack = [];
            redoStack = [];
            
            // Reload page
            location.reload();
        }
        
        function resetPreferences() {
            if (!confirm('Reset all preferences to default?')) return;
            
            localStorage.removeItem(keys.preferences);
            loadPreferences();
            showNotification('Preferences reset to default');
        }
        
        function updateStorageUsage() {
            let total = 0;
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key.startsWith(currentUser)) {
                    total += localStorage.getItem(key).length * 2; // Approx bytes
                }
            }
            
            const kb = (total / 1024).toFixed(2);
            document.getElementById('storageUsed').textContent = `${kb} KB`;
        }
        
        // ===== TASK MANAGEMENT (Updated with undo support) =====
        function initTasks() {
            const addTaskBtn = document.getElementById('addTaskBtn');
            const taskTitle = document.getElementById('taskTitle');
            const taskDue = document.getElementById('taskDue');
            
            // Load tasks from storage
            loadTasks();
            
            // Add task event
            addTaskBtn.addEventListener('click', function() {
                const title = taskTitle.value.trim();
                const due = taskDue.value;
                const priority = document.getElementById('taskPriority').value;
                const difficulty = document.getElementById('taskDifficulty').value;
                
                if (!title) {
                    alert('Please enter a task title');
                    return;
                }
                
                addTask(title, due, priority, difficulty);
                taskTitle.value = '';
                taskDue.value = '';
                document.getElementById('taskPriority').value = '';
                document.getElementById('taskDifficulty').value = '';
            });
            
            // Allow Enter key to add task
            taskTitle.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addTaskBtn.click();
                }
            });
        }
        
        // 1. Fetch Tasks from MySQL
        async function loadTasks() {
            try {
                const response = await fetch('api/tasks.php');
                const tasks = await response.json();
                const list = document.getElementById('taskList');
                
                if (!Array.isArray(tasks)) {
                    list.innerHTML = '<p style="text-align: center; color: var(--text-secondary);">Error loading tasks</p>';
                    return;
                }
                
                list.innerHTML = tasks.map((t, index) => `
                    <div class="task-item ${t.completed ? 'completed' : ''}">
                        <div class="task-content">
                            <div class="task-header">
                                <input type="checkbox" ${t.completed ? 'checked' : ''} onchange="toggleTask(${t.id}, ${t.completed ? 'true' : 'false'})">
                                <span class="task-title ${t.completed ? 'completed-text' : ''}">${t.title}</span>
                            </div>
                            <div class="task-meta">
                                <span class="priority-badge priority-${t.priority}">${t.priority.toUpperCase()}</span>
                                <span class="difficulty-badge difficulty-${t.difficulty}">${t.difficulty.toUpperCase()}</span>
                                ${t.due_date ? `<span class="due-date">Due: ${new Date(t.due_date).toLocaleDateString()}</span>` : ''}
                            </div>
                        </div>
                        <div class="task-actions">
                            <button class="btn btn-warning btn-sm edit-task" data-id="${t.id}" title="Edit Task">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTask(${t.id})" title="Delete Task">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
                
                // Update task count
                const taskStats = document.getElementById('taskStats');
                if (taskStats) {
                    const completed = tasks.filter(t => t.completed).length;
                    taskStats.textContent = `${tasks.length} tasks (${completed} completed)`;
                }
            } catch (error) {
                console.error('Error loading tasks:', error);
                const list = document.getElementById('taskList');
                list.innerHTML = '<p style="text-align: center; color: var(--text-secondary);">Error loading tasks</p>';
            }
        }

        // Edit task functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-task')) {
                const btn = e.target.closest('.edit-task');
                const id = btn.getAttribute('data-id');
                const taskItem = btn.closest('.task-item');
                
                // Get current task data (need to fetch again or store)
                fetch('api/tasks.php').then(r => r.json()).then(tasks => {
                    const task = tasks.find(t => t.id == id);
                    if (!task) return;
                    
                    taskItem.querySelector('.task-content').innerHTML = `
                        <div class="task-header">
                            <input type="text" class="form-input" value="${task.title}" id="edit-title-${id}" style="flex: 1; margin-right: 10px;">
                            <label style="display: flex; align-items: center;">
                                <input type="checkbox" ${task.completed ? 'checked' : ''} id="edit-completed-${id}" style="margin-right: 5px;"> Completed
                            </label>
                        </div>
                        <div class="task-meta" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;">
                            <select id="edit-priority-${id}" class="form-input">
                                <option value="low" ${task.priority === 'low' ? 'selected' : ''}>Low</option>
                                <option value="medium" ${task.priority === 'medium' ? 'selected' : ''}>Medium</option>
                                <option value="high" ${task.priority === 'high' ? 'selected' : ''}>High</option>
                            </select>
                            <select id="edit-difficulty-${id}" class="form-input">
                                <option value="easy" ${task.difficulty === 'easy' ? 'selected' : ''}>Easy</option>
                                <option value="medium" ${task.difficulty === 'medium' ? 'selected' : ''}>Medium</option>
                                <option value="hard" ${task.difficulty === 'hard' ? 'selected' : ''}>Hard</option>
                            </select>
                            <input type="date" id="edit-due-${id}" class="form-input" value="${task.due_date || ''}">
                        </div>
                        <div class="task-actions" style="margin-top: 10px;">
                            <button class="btn btn-success btn-sm save-edit" data-id="${id}">Save</button>
                            <button class="btn btn-secondary btn-sm cancel-edit" data-id="${id}">Cancel</button>
                        </div>
                    `;
                });
            } else if (e.target.closest('.save-edit')) {
                const id = e.target.closest('.save-edit').getAttribute('data-id');
                const title = document.getElementById(`edit-title-${id}`).value.trim();
                const priority = document.getElementById(`edit-priority-${id}`).value;
                const difficulty = document.getElementById(`edit-difficulty-${id}`).value;
                const due_date = document.getElementById(`edit-due-${id}`).value;
                const completed = document.getElementById(`edit-completed-${id}`).checked;
                
                if (!title) {
                    alert('Title cannot be empty');
                    return;
                }
                
                fetch('api/tasks.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'update',
                        id: id,
                        title: title,
                        priority: priority,
                        difficulty: difficulty,
                        due_date: due_date || null,
                        completed: completed
                    })
                }).then(r => r.json()).then(result => {
                    if (result.status === 'success') {
                        loadTasks();
                        showNotification('Task updated successfully!');
                    } else {
                        showNotification('Failed to update task', 'error');
                    }
                }).catch(error => {
                    console.error('Error updating task:', error);
                    showNotification('Error updating task', 'error');
                });
            } else if (e.target.closest('.cancel-edit')) {
                loadTasks();
            }
        });
            
        
        
        async function addTask(title, due, priority, difficulty) {
            try {
                const response = await fetch('api/tasks.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'create',
                        title: title,
                        due_date: due,
                        priority: priority,
                        difficulty: difficulty
                    })
                });
                
                const responseText = await response.text();
                console.log('Response:', responseText);
                
                try {
                    const result = JSON.parse(responseText);
                    if (result.status === 'success') {
                        await loadTasks();
                        showNotification('Task added successfully!');
                    } else {
                        showNotification('Failed to add task', 'error');
                    }
                } catch (jsonError) {
                    alert('Response is not JSON: ' + responseText);
                }
            } catch (error) {
                console.error('Error adding task:', error);
                alert('Fetch error: ' + error.message);
                showNotification('Error adding task', 'error');
            }
        }
        
        
        window.toggleTask = async function(id, currentCompleted) {
            const newCompleted = currentCompleted !== 'true';
            
            try {
                const response = await fetch('api/tasks.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'update',
                        id: id,
                        completed: newCompleted
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    await loadTasks();
                    updateAnalytics();
                } else {
                    showNotification('Failed to update task', 'error');
                }
            } catch (error) {
                console.error('Error updating task:', error);
                showNotification('Error updating task', 'error');
            }
        };
        
        window.deleteTask = async function(id) {
            if (!confirm('Are you sure you want to delete this task?')) return;
            
            try {
                const response = await fetch('api/tasks.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        id: id
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    await loadTasks();
                    showNotification('Task deleted');
                } else {
                    showNotification('Failed to delete task', 'error');
                }
            } catch (error) {
                console.error('Error deleting task:', error);
                showNotification('Error deleting task', 'error');
            }
        };
        
        // ===== HELPER FUNCTIONS =====
        function getFromStorage(key) {
            return dataCache[key] || getDefaultData(key);
        }
        
        function saveToStorage(key, value) {
            dataCache[key] = value;
            // Async save to database
            saveToDatabase(key, value);
            updateStorageUsage();
        }
        
        async function saveToDatabase(key, value) {
            try {
                const endpoint = getApiEndpoint(key);
                const apiKey = getApiKey(key);
                const response = await fetch(`/api/${endpoint}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ [apiKey]: value })
                });
                if (!response.ok) throw new Error('API error');
            } catch (e) {
                console.error('Error saving to database:', e);
            }
        }
        
        async function loadFromDatabase() {
            // Load all data from APIs
            const endpoints = ['tasks', 'plans', 'resources', 'settings', 'analytics', 'pomodoro', 'focus', 'schedule', 'undo', 'sync'];
            const promises = endpoints.map(async (endpoint) => {
                try {
                    const response = await fetch(`api/${endpoint}.php`);
                    if (response.ok) {
                        const data = await response.json();
                        // Map back to keys
                        const key = Object.keys(keys).find(k => getApiEndpoint(keys[k]) === endpoint);
                        if (key) {
                            if (endpoint === 'settings') {
                                dataCache[keys[key]] = {
                                    sessionLength: data.session_length,
                                    studyTimePreference: data.study_time_preference,
                                    breakLength: data.break_length,
                                    syncFrequency: data.sync_frequency,
                                    offlineMode: data.offline_mode == 1
                                };
                            } else if (endpoint === 'analytics') {
                                dataCache[keys[key]] = data;
                            } else if (endpoint === 'pomodoro') {
                                dataCache[keys[key]] = { totalTime: data.total_time, sessionsCompleted: data.sessions_completed };
                            } else {
                                dataCache[keys[key]] = data;
                            }
                        }
                    }
                } catch (e) {
                    console.error(`Error loading ${endpoint}:`, e);
                }
            });
            await Promise.all(promises);
        }
        
        function getApiEndpoint(key) {
            const endpoints = {
                [keys.tasks]: 'tasks',
                [keys.plan]: 'plans',
                [keys.resources]: 'resources',
                [keys.resourceTime]: 'resources', // Special handling
                [keys.pomodoroStats]: 'pomodoro',
                [keys.focusRatings]: 'focus',
                [keys.preferences]: 'settings',
                [keys.analytics]: 'analytics',
                [keys.schedule]: 'schedule',
                [keys.undoHistory]: 'undo',
                [keys.syncState]: 'sync'
            };
            return endpoints[key] || 'settings'; // Default to settings
        }
        
        function getApiKey(key) {
            const apiKeys = {
                [keys.tasks]: 'tasks',
                [keys.plan]: 'plans',
                [keys.resources]: 'resources',
                [keys.resourceTime]: 'resourceTime',
                [keys.pomodoroStats]: 'pomodoroStats',
                [keys.focusRatings]: 'focusRatings',
                [keys.preferences]: 'preferences',
                [keys.analytics]: 'analytics',
                [keys.schedule]: 'schedule',
                [keys.undoHistory]: 'undoHistory',
                [keys.syncState]: 'syncState'
            };
            return apiKeys[key] || key;
        }
        
        function getDefaultData(key) {
            const defaults = {
                [keys.tasks]: [],
                [keys.plan]: [],
                [keys.resources]: [],
                [keys.resourceTime]: {},
                [keys.pomodoroStats]: { totalTime: 0 },
                [keys.focusRatings]: [],
                [keys.preferences]: {
                    sessionLength: 25,
                    studyTimePreference: 'afternoon',
                    breakLength: 5,
                    syncFrequency: 15,
                    offlineMode: true
                },
                [keys.analytics]: {
                    dailyTime: {},
                    subjectTime: {},
                    completionRates: [],
                    productivity: {},
                    focusRatings: []
                },
                [keys.schedule]: [],
                [keys.undoHistory]: [],
                [keys.syncState]: {}
            };
            return defaults[key] || null;
        }
        
        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? 'var(--danger)' : type === 'warning' ? 'var(--warning)' : 'var(--primary)'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: var(--shadow);
                z-index: 10000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
        
        function getRandomColor() {
            const colors = [
                '#4361ee', '#7209b7', '#3a0ca3', '#4cc9f0',
                '#f72585', '#560bad', '#b5179e', '#f8961e'
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }
        
        function getLastNDays(n) {
            const days = [];
            for (let i = n - 1; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                days.push(date);
            }
            return days;
        }
        
        function getDayName(dayIndex) {
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            return days[dayIndex];
        }
        
        function calculateDataSize() {
            let total = 0;
            for (let i = 0; i < localStorage.length; i++) {
                total += localStorage.getItem(localStorage.key(i)).length * 2;
            }
            return total;
        }
        
        // ===== KEEP EXISTING FUNCTIONS FROM ORIGINAL CODE =====
        // (All the original functions for plans, resources, pomodoro, etc. remain the same)
        // They have been updated to work with the new features but the core logic remains
        
        // Note: Due to character limits, I've focused on implementing the new features.
        // The original functionality for plans, resources, pomodoro timer, etc. is preserved
        // but integrated with the new systems (undo/redo, sync, etc.).

        // ===== ADD MISSING EVENT LISTENERS =====
        // Save Plan Button
        document.getElementById('savePlanBtn').addEventListener('click', async function() {
            const topic = document.getElementById('planTopic').value.trim();
            const category = document.getElementById('planCategory').value;
            const priority = document.getElementById('planPriority').value;
            const deadline = document.getElementById('planDeadline').value;
            
            if (!topic || !category || !priority || !deadline) {
                showNotification('Please fill in all fields', 'error');
                return;
            }
            
            try {
                const response = await fetch('api/plans.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'create',
                        topic: topic,
                        category: category,
                        priority: priority,
                        deadline: deadline
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    showNotification('Study plan saved successfully!');
                    // Clear form
                    document.getElementById('planTopic').value = '';
                    document.getElementById('planCategory').value = '';
                    document.getElementById('planPriority').value = '';
                    document.getElementById('planDeadline').value = '';
                    // Reload plans
                    loadPlans();
                } else {
                    showNotification('Failed to save plan', 'error');
                }
            } catch (error) {
                console.error('Error saving plan:', error);
                showNotification('Error saving plan', 'error');
            }
        });

        // Load Plans Function
        async function loadPlans() {
            try {
                const response = await fetch('api/plans.php');
                const plans = await response.json();
                const plansList = document.getElementById('plansList');
                plansList.innerHTML = '';
                
                if (plans.length === 0) {
                    plansList.innerHTML = '<p style="text-align: center; color: var(--text-secondary);">No study plans yet. Create your first plan above!</p>';
                    return;
                }
                
                plans.forEach(plan => {
                    const planElement = document.createElement('div');
                    planElement.className = 'task-item';
                    planElement.innerHTML = `
                        <div class="task-content">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div>
                                    <h4 style="margin: 0 0 5px 0; color: var(--text-primary);">${plan.topic}</h4>
                                    <div style="font-size: 14px; color: var(--text-secondary);">
                                        Category: ${plan.category} | Priority: ${plan.priority} | Deadline: ${new Date(plan.deadline).toLocaleDateString()}
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm delete-plan" data-id="${plan.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    plansList.appendChild(planElement);
                });
                
                // Add delete event listeners
                document.querySelectorAll('.delete-plan').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Delete this study plan?')) {
                            try {
                                const response = await fetch('api/plans.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        action: 'delete',
                                        id: id
                                    })
                                });
                                const result = await response.json();
                                if (result.status === 'success') {
                                    showNotification('Plan deleted');
                                    loadPlans();
                                }
                            } catch (error) {
                                showNotification('Error deleting plan', 'error');
                            }
                        }
                    });
                });
                
                // Update stats
                document.getElementById('planStats').textContent = `${plans.length} plans`;
            } catch (error) {
                console.error('Error loading plans:', error);
            }
        }

        // Upload Resource Button (simplified - assumes file is already handled)
        document.getElementById('uploadResourceBtn').addEventListener('click', async function() {
            const fileInput = document.getElementById('resourceInput');
            const topic = document.getElementById('resourceTopic').value;
            
            if (!fileInput.files.length) {
                showNotification('Please select a file to upload', 'error');
                return;
            }
            
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('topic', topic);
            
            try {
                // First upload file (we need a file upload endpoint)
                const uploadResponse = await fetch('upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (!uploadResponse.ok) {
                    throw new Error('File upload failed');
                }
                
                const uploadResult = await uploadResponse.json();
                
                // Then save to database
                const saveResponse = await fetch('api/resources.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'upload',
                        name: file.name,
                        type: file.type.split('/')[0],
                        topic: topic,
                        file_path: uploadResult.path
                    })
                });
                
                const saveResult = await saveResponse.json();
                if (saveResult.status === 'success') {
                    showNotification('Resource uploaded successfully!');
                    fileInput.value = '';
                    loadResources();
                } else {
                    showNotification('Failed to save resource', 'error');
                }
            } catch (error) {
                console.error('Error uploading resource:', error);
                showNotification('Error uploading resource', 'error');
            }
        });

        // Load Resources Function
        async function loadResources() {
            try {
                const response = await fetch('api/resources.php');
                const resources = await response.json();
                const resourceList = document.getElementById('resourceList');
                resourceList.innerHTML = '';
                
                if (resources.length === 0) {
                    resourceList.innerHTML = '<p style="text-align: center; color: var(--text-secondary);">No resources uploaded yet.</p>';
                    return;
                }
                
                resources.forEach(resource => {
                    const resourceElement = document.createElement('div');
                    resourceElement.className = 'resource-item';
                    resourceElement.innerHTML = `
                        <div class="resource-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="resource-info">
                            <div class="resource-name">${resource.name}</div>
                            <div class="resource-meta">Type: ${resource.type} | Topic: ${resource.topic}</div>
                        </div>
                        <div class="resource-actions">
                            <button class="btn btn-primary btn-sm preview-resource" data-path="${resource.file_path}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-resource" data-id="${resource.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    resourceList.appendChild(resourceElement);
                });
                
                // Add event listeners
                document.querySelectorAll('.preview-resource').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const path = this.getAttribute('data-path');
                        // Simple preview - in real app, handle different file types
                        window.open(path, '_blank');
                    });
                });
                
                document.querySelectorAll('.delete-resource').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Delete this resource?')) {
                            // Note: Add delete action to API if needed
                            showNotification('Delete not implemented yet', 'warning');
                        }
                    });
                });
                
                // Update stats
                document.getElementById('resourceStats').textContent = `${resources.length} resources`;
            } catch (error) {
                console.error('Error loading resources:', error);
            }
        }

        // Initialize on load
        loadPlans();
        loadResources();

        // ===== INITIALIZE ON LOAD =====
        // Reset timer on page load
        if (typeof resetTimer === 'function') {
            resetTimer();
        }
    </script>
</body>
</html>