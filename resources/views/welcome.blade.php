<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrippersShield - Travel Insurance | Har Journey Hogi Insured</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --pb-blue-dark: #0a2540;
            --pb-blue-primary: #0065ff;
            --pb-blue-hover: #0747a6;
            --pb-blue-bg: #ebf3ff;
            --pb-cyan: #00c7e6;
            --pb-text-main: #172b4d;
            --pb-text-muted: #626f86;
            --pb-border: #dfe1e6;
            --pb-card-bg: #ffffff;
            --pb-tag-bg: #e6fcff;
            --pb-tag-color: #008da6;
            --pb-warning-bg: #fff0b3;
            --pb-warning-color: #7a5d00;
            --pb-success-bg: #e3fcef;
            --pb-success-color: #006644;
            --pb-danger-bg: #ffebe6;
            --pb-danger-color: #bf2600;
            --pb-shadow: 0 4px 20px rgba(9, 30, 66, 0.08);
            --pb-shadow-hover: 0 8px 30px rgba(9, 30, 66, 0.14);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #f7f9fc;
            color: var(--pb-text-main);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .top-utility-bar {
            background: #ffffff;
            border-bottom: 1px solid #edf0f5;
            font-size: 13px;
            color: var(--pb-text-muted);
            padding: 8px 32px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 24px;
        }

        .top-utility-bar a {
            color: var(--pb-text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .top-utility-bar a:hover {
            color: var(--pb-blue-primary);
        }

        .phone-highlight {
            font-weight: 600;
            color: var(--pb-text-main);
        }

        /* Main Navigation */
        .main-header {
            background: #ffffff;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .shield-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0065ff 0%, #00c7e6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0, 101, 255, 0.25);
        }

        .brand-name {
            font-size: 24px;
            font-weight: 800;
            color: var(--pb-blue-dark);
            letter-spacing: -0.5px;
        }

        .brand-name span {
            color: var(--pb-blue-primary);
        }

        .brand-sub {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #ff5630;
            letter-spacing: 1px;
            display: block;
        }

        .nav-links {
            display: flex;
            gap: 28px;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            color: var(--pb-text-main);
            transition: color 0.2s;
            position: relative;
        }

        .nav-links a.active, .nav-links a:hover {
            color: var(--pb-blue-primary);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--pb-blue-primary);
            border-radius: 3px;
        }

        .btn-signin {
            border: 1.5px solid var(--pb-blue-primary);
            color: var(--pb-blue-primary);
            background: transparent;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-signin:hover {
            background: var(--pb-blue-primary);
            color: #ffffff;
        }

        /* Hero Wrapper */
        .hero-banner {
            background: linear-gradient(180deg, #f0f6ff 0%, #f7f9fc 100%);
            padding: 40px 32px 60px;
            flex-grow: 1;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: start;
        }

        /* Left Column */
        .hero-left h1 {
            font-size: 38px;
            font-weight: 800;
            color: var(--pb-blue-dark);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .hero-desc {
            font-size: 15px;
            color: var(--pb-text-muted);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .hero-desc a {
            color: var(--pb-blue-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .section-subhead {
            font-size: 18px;
            font-weight: 700;
            color: var(--pb-blue-dark);
            margin-bottom: 20px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 36px;
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid #eef2f8;
            padding: 16px;
            border-radius: 12px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--pb-shadow);
        }

        .feature-icon-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .icon-yellow { background: #fff8e6; color: #ffab00; }
        .icon-blue { background: #ebf3ff; color: #0065ff; }
        .icon-red { background: #ffebe6; color: #ff5630; }
        .icon-green { background: #e3fcef; color: #36b37e; }

        .feature-text h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--pb-text-main);
            margin-bottom: 4px;
        }

        .feature-text p {
            font-size: 12px;
            color: var(--pb-text-muted);
            line-height: 1.4;
        }

        /* Trust Banner */
        .trust-banner {
            background: #e8f2ff;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #d0e4ff;
        }

        .trust-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #d7e7fd;
        }

        .stat-item h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--pb-blue-dark);
        }

        .stat-item p {
            font-size: 11px;
            font-weight: 600;
            color: var(--pb-text-muted);
        }

        .trust-caption {
            font-size: 12px;
            color: var(--pb-text-muted);
            text-align: center;
            font-weight: 500;
        }

        /* Right Column Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(9, 30, 66, 0.1);
            border: 1px solid #edf1f7;
        }

        .form-card h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--pb-blue-dark);
            margin-bottom: 24px;
            line-height: 1.3;
        }

        .field-group {
            margin-bottom: 20px;
        }

        .search-box-wrapper {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1.5px solid #dcdfe5;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: var(--pb-text-main);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            border-color: var(--pb-blue-primary);
            box-shadow: 0 0 0 3px rgba(0, 101, 255, 0.15);
        }

        .search-icon-svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #8993a4;
        }

        .dest-pills-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--pb-text-muted);
            margin: 16px 0 10px;
        }

        .dest-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 24px;
        }

        .dest-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #f4f5f7;
            border: 1.5px solid #ebecf0;
            border-radius: 24px;
            font-size: 13px;
            font-weight: 600;
            color: var(--pb-text-main);
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .dest-pill:hover {
            border-color: #b3d4ff;
            background: #ebf3ff;
            color: var(--pb-blue-primary);
        }

        .dest-pill.active {
            background: #ebf3ff;
            border-color: var(--pb-blue-primary);
            color: var(--pb-blue-primary);
            font-weight: 700;
        }

        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .input-labeled {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-labeled label {
            font-size: 12px;
            font-weight: 600;
            color: var(--pb-text-muted);
        }

        .custom-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #dcdfe5;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
        }

        .custom-input:focus {
            border-color: var(--pb-blue-primary);
            box-shadow: 0 0 0 3px rgba(0, 101, 255, 0.15);
        }

        .traveller-row {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .traveller-row-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--pb-blue-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .meta-inputs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-view-plans {
            width: 100%;
            background: #0065ff;
            color: white;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(0, 101, 255, 0.35);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-view-plans:hover {
            background: #0052cc;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 101, 255, 0.45);
        }

        .form-disclaimer {
            font-size: 11px;
            color: #7a869a;
            text-align: center;
            margin-top: 14px;
            line-height: 1.4;
        }

        /* Plan Selector / Results Section */
        .plans-section {
            display: none;
            margin-top: 40px;
            background: #ffffff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: var(--pb-shadow);
            border: 1px solid #edf1f7;
        }

        .plans-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebecf0;
        }

        .plans-title h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--pb-blue-dark);
        }

        .plans-title p {
            font-size: 13px;
            color: var(--pb-text-muted);
        }

        .sum-insured-selector {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .sum-pill {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1.5px solid #dfe1e6;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            background: #ffffff;
        }

        .sum-pill.active {
            border-color: var(--pb-blue-primary);
            background: #ebf3ff;
            color: var(--pb-blue-primary);
            font-weight: 700;
        }

        .plans-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .plan-box {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            position: relative;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s;
        }

        .plan-box:hover {
            border-color: #b3d4ff;
            transform: translateY(-2px);
        }

        .plan-box.selected {
            border-color: var(--pb-blue-primary);
            box-shadow: 0 0 0 2px var(--pb-blue-primary), var(--pb-shadow);
            background: #fbfdff;
        }

        .plan-badge {
            position: absolute;
            top: -12px;
            right: 18px;
            background: #ff5630;
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .plan-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--pb-blue-dark);
            margin-bottom: 4px;
        }

        .plan-rate {
            font-size: 13px;
            color: var(--pb-text-muted);
            margin-bottom: 16px;
        }

        .plan-price-large {
            font-size: 32px;
            font-weight: 800;
            color: var(--pb-blue-primary);
            margin-bottom: 8px;
        }

        .plan-features-list {
            list-style: none;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f0f2f5;
            font-size: 13px;
            color: #42526e;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .plan-features-list li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Pricing Breakdown Box */
        .pricing-breakdown-box {
            background: #f4f7fb;
            border: 1px solid #e1e7f0;
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 32px;
        }

        .breakdown-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--pb-blue-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .formula-text {
            font-family: monospace;
            background: #ffffff;
            border: 1px solid #dcdfe5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            color: #0c2340;
            margin-top: 6px;
            display: block;
        }

        /* Mock Insurer Sandbox Bar */
        .sandbox-panel {
            background: #f0f4f9;
            border: 2px dashed #b3d4ff;
            border-radius: 16px;
            padding: 24px;
            margin-top: 24px;
        }

        .sandbox-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--pb-blue-dark);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sandbox-controls {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 12px;
            align-items: center;
        }

        .sandbox-select {
            padding: 12px 14px;
            border: 1.5px solid #c1c7d0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            background: #ffffff;
            outline: none;
        }

        .btn-action {
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .btn-issue { background: #0065ff; color: #ffffff; }
        .btn-issue:hover { background: #0747a6; }
        .btn-reconcile { background: #ffab00; color: #172b4d; }
        .btn-reconcile:hover { background: #ff9900; }
        .btn-secondary { background: #ffffff; border: 1.5px solid #dfe1e6; color: var(--pb-text-main); }
        .btn-secondary:hover { background: #f4f5f7; border-color: #c1c7d0; }

        /* Status & Audit Trail Card */
        .status-audit-card {
            display: none;
            margin-top: 32px;
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--pb-shadow);
            border: 1px solid #edf1f7;
        }

        .status-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ebecf0;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-ISSUED { background: #e3fcef; color: #006644; border: 1px solid #abf5d1; }
        .badge-VALIDATED { background: #deebff; color: #0747a6; border: 1px solid #b3d4ff; }
        .badge-SUBMITTED { background: #eae6ff; color: #403294; border: 1px solid #c0b6f2; }
        .badge-PENDING_CONFIRMATION { background: #fff0b3; color: #7a5d00; border: 1px solid #ffe380; }
        .badge-NEEDS_RECONCILIATION { background: #fffae6; color: #ff8b00; border: 1px solid #ffc400; }
        .badge-FAILED { background: #ffebe6; color: #bf2600; border: 1px solid #ffbdad; }

        .timeline-list {
            position: relative;
            margin-left: 18px;
            padding-left: 20px;
            border-left: 2px solid #ebecf0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -27px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0065ff;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #0065ff;
        }

        .timeline-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--pb-blue-dark);
        }

        .timeline-desc {
            font-size: 12px;
            color: var(--pb-text-muted);
        }

        .timeline-time {
            font-size: 11px;
            color: #8993a4;
        }

        /* Requests Table Section */
        .requests-table-section {
            margin-top: 48px;
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--pb-shadow);
            border: 1px solid #edf1f7;
        }

        .table-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table th {
            text-align: left;
            padding: 12px 14px;
            background: #f8fafc;
            color: var(--pb-text-muted);
            font-weight: 700;
            border-bottom: 1.5px solid #edf1f7;
        }

        .data-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f3f6;
            color: var(--pb-text-main);
        }

        .data-table tr:hover {
            background: #fbfdff;
        }

        /* Footer */
        .app-footer {
            background: var(--pb-blue-dark);
            color: #8993a4;
            padding: 32px;
            font-size: 13px;
            text-align: center;
            margin-top: 60px;
        }

        .app-footer a {
            color: #b3d4ff;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; }
            .plans-cards-grid { grid-template-columns: 1fr; }
            .sandbox-controls { grid-template-columns: 1fr; }
            .trust-stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <!-- Top Utility Bar (Policybazaar Style) -->
    <div class="top-utility-bar">
        <span>Claim</span>
        <span>Get The App</span>
        <span>English ▾</span>
        <span>Sales: <span class="phone-highlight">1800-208-8787</span></span>
        <span>Service: <span class="phone-highlight">1800-258-5970</span></span>
        <span>Claims: <span class="phone-highlight">1800-258-5881</span></span>
        <a href="#contact">Contact Us</a>
    </div>

    <!-- Main Navigation Bar -->
    <header class="main-header">
        <a href="/" class="logo-group">
            <div class="shield-icon">🛡️</div>
            <div>
                <div class="brand-name">trippers<span>shield</span></div>
                <span class="brand-sub">Har Journey Hogi Insured</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#insurance">Term Insurance</a></li>
            <li><a href="#investment">Investment Plans</a></li>
            <li><a href="#health">Health Insurance</a></li>
            <li><a href="#travel" class="active">Travel Insurance</a></li>
            <li><a href="#motor">Motor Insurance</a></li>
            <li><a href="#renewal">Renewal</a></li>
        </ul>

        <button class="btn-signin" onclick="scrollToExplorer()">Operations Console</button>
    </header>

    <!-- Hero Content -->
    <main class="hero-banner">
        <div class="container">
            <div class="hero-grid">
                
                <!-- Left Column -->
                <div class="hero-left">
                    <h1>Travel Insurance</h1>
                    <p class="hero-desc">
                        Travel insurance gives you complete financial protection in case of trip cancellations, medical emergencies, flight delays, and baggage loss while travelling. It acts as an uncompromising safety net for domestic and international trips.
                    </p>

                    <h3 class="section-subhead">Why TrippersShield?</h3>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper icon-yellow">🩺</div>
                            <div class="feature-text">
                                <h4>No Health Checkup Required</h4>
                                <p>Get instant travel insurance without medical checks</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon-wrapper icon-blue">🎧</div>
                            <div class="feature-text">
                                <h4>24*7 Support Helpline</h4>
                                <p>Get worldwide emergency assistance anytime, anywhere</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon-wrapper icon-red">⚡</div>
                            <div class="feature-text">
                                <h4>Quick Claim Settlement</h4>
                                <p>Direct cashless hospitalisation and express claim processing</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon-wrapper icon-green">🛡️</div>
                            <div class="feature-text">
                                <h4>PED Covered</h4>
                                <p>Comprehensive emergency coverage for pre-existing diseases</p>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Stats Banner -->
                    <div class="trust-banner">
                        <div class="trust-stats">
                            <div class="stat-item">
                                <h3>⭐ 4.9/5</h3>
                                <p>Customer Rating</p>
                            </div>
                            <div class="stat-item">
                                <h3>5.9 Crore+</h3>
                                <p>Policies Issued</p>
                            </div>
                            <div class="stat-item">
                                <h3>2 Minutes</h3>
                                <p>Instant Policy</p>
                            </div>
                            <div class="stat-item">
                                <h3>Visa Compliant</h3>
                                <p>Schengen & Global</p>
                            </div>
                        </div>
                        <p class="trust-caption">
                            TrippersShield is a licensed digital travel insurance distributor ensuring 100% idempotent policy intake and guaranteed zero duplicate issuance.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Card Form -->
                <div class="hero-right">
                    <div class="form-card">
                        <h2>Your Trip Is Priceless, Protect It Affordably</h2>

                        <div class="field-group">
                            <div class="search-box-wrapper">
                                <svg class="search-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="destinationInput" class="search-input" placeholder="Search destination country or select below" value="United Kingdom" oninput="updateDestinationType()">
                            </div>

                            <div class="dest-pills-label">Popular Destinations (Click to select)</div>
                            <div class="dest-pills" id="destPills">
                                <div class="dest-pill" onclick="selectDestination('Domestic India', 'DOMESTIC')">🇮🇳 Domestic India</div>
                                <div class="dest-pill" onclick="selectDestination('Schengen Area', 'INTERNATIONAL')">🇪🇺 Schengen</div>
                                <div class="dest-pill" onclick="selectDestination('USA', 'INTERNATIONAL')">🇺🇸 USA</div>
                                <div class="dest-pill" onclick="selectDestination('UAE / Dubai', 'INTERNATIONAL')">🇦🇪 UAE</div>
                                <div class="dest-pill" onclick="selectDestination('Germany', 'INTERNATIONAL')">🇩🇪 Germany</div>
                                <div class="dest-pill active" onclick="selectDestination('United Kingdom', 'INTERNATIONAL')">🇬🇧 United Kingdom</div>
                                <div class="dest-pill" onclick="selectDestination('Thailand', 'INTERNATIONAL')">🇹🇭 Thailand</div>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="date-row">
                            <div class="input-labeled">
                                <label for="tripStart">Start date</label>
                                <input type="date" id="tripStart" class="custom-input" value="2026-11-10" onchange="calculateLive()">
                            </div>
                            <div class="input-labeled">
                                <label for="tripEnd">End date</label>
                                <input type="date" id="tripEnd" class="custom-input" value="2026-11-14" onchange="calculateLive()">
                            </div>
                        </div>

                        <!-- Traveller Info & Meta (Agent ID & Client Request ID) -->
                        <div class="traveller-row">
                            <div class="traveller-row-title">
                                <span>👤 Traveller & Agent Information</span>
                                <span style="font-size: 11px; color: #0065ff; cursor: pointer;" onclick="randomizeRequestId()">⚡ New Request ID</span>
                            </div>
                            <div class="meta-inputs-grid">
                                <div class="input-labeled">
                                    <label>Customer Name</label>
                                    <input type="text" id="customerName" class="custom-input" value="Sample Customer">
                                </div>
                                <div class="input-labeled">
                                    <label>Date of Birth</label>
                                    <input type="date" id="dob" class="custom-input" value="1998-04-10" onchange="calculateLive()">
                                </div>
                                <div class="input-labeled">
                                    <label>Agent ID</label>
                                    <input type="text" id="agentId" class="custom-input" value="AGENT-17">
                                </div>
                                <div class="input-labeled">
                                    <label>Client Request ID</label>
                                    <input type="text" id="clientRequestId" class="custom-input" value="AGT-2026-0001">
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn-view-plans" onclick="showPlans()">
                            <span>View plans</span>
                            <span style="font-size: 18px;">›</span>
                        </button>

                        <p class="form-disclaimer">
                            By clicking on "View plans" you agree to our deterministic pricing engine and automated issuance workflow.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Plan Comparison & Pricing Engine Section -->
            <section class="plans-section" id="plansSection">
                <div class="plans-header">
                    <div class="plans-title">
                        <h2>Select Coverage & Compare Plans</h2>
                        <p id="tripSummarySubtitle">5 Days • International • Age 28</p>
                    </div>

                    <!-- Sum Insured Selector -->
                    <div class="sum-insured-selector">
                        <span style="font-size: 13px; font-weight: 600; color: #626f86;">Sum Insured:</span>
                        <div class="sum-pill" onclick="selectSumInsured(100000)">₹1,00,000 <small>(1.00x)</small></div>
                        <div class="sum-pill active" onclick="selectSumInsured(300000)">₹3,00,000 <small>(1.25x)</small></div>
                        <div class="sum-pill" onclick="selectSumInsured(500000)">₹5,00,000 <small>(1.50x)</small></div>
                    </div>
                </div>

                <!-- Plan Boxes -->
                <div class="plans-cards-grid">
                    <!-- BASIC -->
                    <div class="plan-box" id="planBoxBASIC" onclick="selectPlan('BASIC')">
                        <div class="plan-name">BASIC PLAN</div>
                        <div class="plan-rate">Base ₹12 / day</div>
                        <div class="plan-price-large" id="priceBASIC">₹135.00</div>
                        <ul class="plan-features-list">
                            <li>✓ Emergency Medical Inpatient</li>
                            <li>✓ Baggage Loss Cover</li>
                            <li>✓ Emergency Dental Treatment</li>
                        </ul>
                    </div>

                    <!-- PLUS -->
                    <div class="plan-box selected" id="planBoxPLUS" onclick="selectPlan('PLUS')">
                        <span class="plan-badge">Recommended</span>
                        <div class="plan-name">PLUS PLAN</div>
                        <div class="plan-rate">Base ₹20 / day</div>
                        <div class="plan-price-large" id="pricePLUS">₹225.00</div>
                        <ul class="plan-features-list">
                            <li>✓ All Basic Plan Benefits</li>
                            <li>✓ Trip Cancellation & Delay</li>
                            <li>✓ Passport Loss Assistance</li>
                            <li>✓ Cashless OPD Coverage</li>
                        </ul>
                    </div>

                    <!-- PREMIUM -->
                    <div class="plan-box" id="planBoxPREMIUM" onclick="selectPlan('PREMIUM')">
                        <div class="plan-name">PREMIUM PLAN</div>
                        <div class="plan-rate">Base ₹30 / day</div>
                        <div class="plan-price-large" id="pricePREMIUM">₹337.50</div>
                        <ul class="plan-features-list">
                            <li>✓ All Plus Plan Benefits</li>
                            <li>✓ Adventure Sports Coverage</li>
                            <li>✓ Home Burglary during travel</li>
                            <li>✓ Zero Deductible on Claims</li>
                        </ul>
                    </div>
                </div>

                <!-- Pricing Formula Breakdown -->
                <div class="pricing-breakdown-box">
                    <div class="breakdown-title">
                        <span>Deterministic Pricing Formula Snapshot:</span>
                        <span id="rateBreakdownPills" style="font-size: 12px; color: #0065ff; font-weight: 600;">₹20 × 5 Days × 1.00 × 1.80 × 1.25</span>
                    </div>
                    <code class="formula-text" id="formulaDisplay">
                        premium = base_daily_rate(₹20) × travel_days(5) × age_multiplier(1.00) × destination_multiplier(1.80) × coverage_multiplier(1.25) = ₹225.00
                    </code>
                </div>

                <!-- Issuance & Mock Insurer Simulation Sandbox -->
                <div class="sandbox-panel">
                    <div class="sandbox-title">
                        <span>🧪 Mock Insurer Reliability Test Sandbox</span>
                        <span style="font-size: 12px; font-weight: 500; color: #626f86;">(Test all failure, timeout, callback, and duplicate scenarios)</span>
                    </div>

                    <div class="sandbox-controls">
                        <select id="scenarioSelect" class="sandbox-select">
                            <option value="SUCCESS">🟢 SUCCESS - Instant policy issuance (Mark ISSUED)</option>
                            <option value="TEMPORARY_FAILURE">🔴 TEMPORARY_FAILURE - Returns 503 (Test safe retry)</option>
                            <option value="TIMEOUT_AFTER_ISSUE">🟡 TIMEOUT_AFTER_ISSUE - Insurer timeout (Mark NEEDS_RECONCILIATION)</option>
                            <option value="DELAYED_CALLBACK">🔵 DELAYED_CALLBACK - Queues async event (Mark PENDING_CONFIRMATION)</option>
                            <option value="DUPLICATE_CALLBACK">🟣 DUPLICATE_CALLBACK - Send duplicate webhook 3 times</option>
                        </select>

                        <button type="button" class="btn-action btn-issue" id="btnIntakeAndSubmit" onclick="runIntakeAndSubmit()">
                            🚀 Ingest & Issue
                        </button>

                        <button type="button" class="btn-action btn-secondary" onclick="simulateDuplicateIntake()">
                            ⚡ Test Duplicate Intake
                        </button>

                        <button type="button" class="btn-action btn-reconcile" id="btnReconcile" onclick="runReconciliation()">
                            🔄 Reconcile Status
                        </button>
                    </div>
                </div>
            </section>

            <!-- Status, References, and Audit Trail Section -->
            <section class="status-audit-card" id="statusAuditCard">
                <div class="status-header-row">
                    <div>
                        <span style="font-size: 12px; font-weight: 700; color: #626f86;">POLICY STATUS:</span>
                        <span class="badge-status badge-VALIDATED" id="currentStatusBadge">VALIDATED</span>
                        <span id="activeClientReqId" style="margin-left: 12px; font-size: 13px; font-weight: 600; color: #172b4d;"></span>
                    </div>

                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div id="policyNumberDisplay" style="font-size: 13px; font-weight: 700; color: #006644;"></div>
                        <div id="providerRefDisplay" style="font-size: 12px; font-weight: 600; color: #626f86;"></div>
                        <button class="btn-action btn-secondary" style="padding: 6px 12px; font-size: 12px;" onclick="refreshActivePolicy()">↻ Refresh</button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <!-- Left: Audit Trail Timeline -->
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #0a2540; margin-bottom: 16px;">
                            📜 State Transition Audit Trail
                        </h4>
                        <div class="timeline-list" id="timelineContainer">
                            <!-- Populated dynamically -->
                        </div>
                    </div>

                    <!-- Right: Issuance Attempts -->
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #0a2540; margin-bottom: 16px;">
                            📡 Issuance Attempts & Idempotency Keys
                        </h4>
                        <div id="attemptsContainer" style="display: flex; flex-direction: column; gap: 10px;">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Manual Webhook Trigger Helper for Async Callback testing -->
                        <div style="margin-top: 20px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                            <div style="font-size: 12px; font-weight: 700; color: #172b4d; margin-bottom: 6px;">
                                📨 Webhook Simulation Trigger:
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="btn-action btn-secondary" style="font-size: 12px; padding: 6px 12px;" onclick="triggerSimulatedCallback(1)">
                                    Deliver Webhook (1x)
                                </button>
                                <button type="button" class="btn-action btn-secondary" style="font-size: 12px; padding: 6px 12px;" onclick="triggerSimulatedCallback(3)">
                                    Deliver Duplicate (3x)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Policy Requests Explorer Table -->
            <section class="requests-table-section" id="requestsExplorer">
                <div class="table-header-bar">
                    <div>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--pb-blue-dark);">
                            Operations Dashboard: Policy Purchase Requests
                        </h3>
                        <p style="font-size: 13px; color: var(--pb-text-muted);">
                            Real-time database records, audit states, attempts, and insurer references
                        </p>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <select id="filterStatus" class="custom-input" style="padding: 8px 12px; font-size: 13px;" onchange="loadRequestsTable()">
                            <option value="">All Statuses</option>
                            <option value="RECEIVED">RECEIVED</option>
                            <option value="VALIDATED">VALIDATED</option>
                            <option value="SUBMITTED">SUBMITTED</option>
                            <option value="PENDING_CONFIRMATION">PENDING_CONFIRMATION</option>
                            <option value="ISSUED">ISSUED</option>
                            <option value="FAILED">FAILED</option>
                            <option value="NEEDS_RECONCILIATION">NEEDS_RECONCILIATION</option>
                        </select>
                        <button class="btn-action btn-secondary" style="padding: 8px 14px;" onclick="loadRequestsTable()">↻ Refresh Table</button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client Request ID</th>
                                <th>Agent</th>
                                <th>Customer</th>
                                <th>Trip Dates</th>
                                <th>Plan / Sum</th>
                                <th>Premium</th>
                                <th>Status</th>
                                <th>Policy #</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="requestsTableBody">
                            <tr>
                                <td colspan="10" style="text-align: center; color: #8993a4; padding: 24px;">Loading records...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <p>TrippersShield PolicyFlow Engine • Candidate Technical Assessment • Version 1.0</p>
        <p style="margin-top: 6px;">REST API • PHP 8.5 • Laravel 12 • SQLite/MySQL • Deterministic Insurance Underwriting</p>
    </footer>

    <!-- JavaScript Interactive Logic -->
    <script>
        let currentDestination = 'INTERNATIONAL';
        let currentPlan = 'PLUS';
        let currentSumInsured = 300000;
        let activePolicyId = null;

        // Base Pricing Constants
        const BASE_RATES = { BASIC: 12.00, PLUS: 20.00, PREMIUM: 30.00 };
        const DEST_MULTIPLIERS = { DOMESTIC: 1.00, INTERNATIONAL: 1.80 };
        const COV_MULTIPLIERS = { 100000: 1.00, 300000: 1.25, 500000: 1.50 };

        function selectDestination(name, type) {
            document.getElementById('destinationInput').value = name;
            currentDestination = type;

            document.querySelectorAll('.dest-pill').forEach(pill => {
                pill.classList.remove('active');
                if (pill.innerText.includes(name.split(' ')[0])) {
                    pill.classList.add('active');
                }
            });

            calculateLive();
        }

        function updateDestinationType() {
            const val = document.getElementById('destinationInput').value.toLowerCase();
            if (val.includes('india') || val.includes('domestic')) {
                currentDestination = 'DOMESTIC';
            } else {
                currentDestination = 'INTERNATIONAL';
            }
            calculateLive();
        }

        function selectSumInsured(amount) {
            currentSumInsured = amount;
            document.querySelectorAll('.sum-pill').forEach(pill => {
                pill.classList.toggle('active', pill.innerText.includes(amount.toLocaleString('en-IN')));
            });
            calculateLive();
        }

        function selectPlan(plan) {
            currentPlan = plan;
            document.querySelectorAll('.plan-box').forEach(box => {
                box.classList.remove('selected');
            });
            document.getElementById(`planBox${plan}`).classList.add('selected');
            calculateLive();
        }

        function randomizeRequestId() {
            const rand = Math.floor(1000 + Math.random() * 9000);
            document.getElementById('clientRequestId').value = `AGT-2026-${rand}`;
        }

        function getAge(dob, tripStart) {
            const b = new Date(dob);
            const s = new Date(tripStart);
            let age = s.getFullYear() - b.getFullYear();
            const m = s.getMonth() - b.getMonth();
            if (m < 0 || (m === 0 && s.getDate() < b.getDate())) {
                age--;
            }
            return Math.max(0, age);
        }

        function getAgeMultiplier(age) {
            if (age <= 17) return 1.10;
            if (age <= 60) return 1.00;
            if (age <= 70) return 1.50;
            return 2.00;
        }

        function calculateLive() {
            const startVal = document.getElementById('tripStart').value;
            const endVal = document.getElementById('tripEnd').value;
            const dobVal = document.getElementById('dob').value;

            if (!startVal || !endVal || !dobVal) return;

            const start = new Date(startVal);
            const end = new Date(endVal);
            const diffTime = Math.max(0, end - start);
            const travelDays = Math.max(1, Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1);

            const age = getAge(dobVal, startVal);
            const ageMul = getAgeMultiplier(age);
            const destMul = DEST_MULTIPLIERS[currentDestination] || 1.80;
            const covMul = COV_MULTIPLIERS[currentSumInsured] || 1.25;

            // Update plan prices
            ['BASIC', 'PLUS', 'PREMIUM'].forEach(plan => {
                const base = BASE_RATES[plan];
                const total = (base * travelDays * ageMul * destMul * covMul).toFixed(2);
                const el = document.getElementById(`price${plan}`);
                if (el) el.innerText = `₹${total}`;
            });

            // Update subtitle and breakdown formula
            document.getElementById('tripSummarySubtitle').innerText = 
                `${travelDays} Days • ${currentDestination} • Age ${age} (${ageMul.toFixed(2)}x)`;

            const currentBase = BASE_RATES[currentPlan];
            const currentTotal = (currentBase * travelDays * ageMul * destMul * covMul).toFixed(2);

            document.getElementById('rateBreakdownPills').innerText = 
                `₹${currentBase} × ${travelDays} Days × ${ageMul.toFixed(2)} × ${destMul.toFixed(2)} × ${covMul.toFixed(2)}`;

            document.getElementById('formulaDisplay').innerText = 
                `premium = base_daily_rate(₹${currentBase}) × travel_days(${travelDays}) × age_multiplier(${ageMul.toFixed(2)}) × destination_multiplier(${destMul.toFixed(2)}) × coverage_multiplier(${covMul.toFixed(2)}) = ₹${currentTotal}`;
        }

        function showPlans() {
            calculateLive();
            const section = document.getElementById('plansSection');
            section.style.display = 'block';
            section.scrollIntoView({ behavior: 'smooth' });
        }

        async function runIntakeAndSubmit() {
            const btn = document.getElementById('btnIntakeAndSubmit');
            btn.disabled = true;
            btn.innerText = 'Processing...';

            try {
                // 1. Post Intake
                const intakePayload = {
                    client_request_id: document.getElementById('clientRequestId').value.trim(),
                    agent_id: document.getElementById('agentId').value.trim(),
                    customer_name: document.getElementById('customerName').value.trim(),
                    date_of_birth: document.getElementById('dob').value,
                    destination: currentDestination,
                    trip_start: document.getElementById('tripStart').value,
                    trip_end: document.getElementById('tripEnd').value,
                    plan_code: currentPlan,
                    sum_insured: currentSumInsured,
                };

                const intakeRes = await fetch('/api/policy-requests', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(intakePayload),
                });

                const intakeData = await intakeRes.json();
                if (!intakeRes.ok) {
                    alert(`Intake Error: ${intakeData.message || 'Validation failed'}`);
                    return;
                }

                activePolicyId = intakeData.data.id;

                // 2. Submit for issuance with selected scenario
                const scenario = document.getElementById('scenarioSelect').value;
                const submitRes = await fetch(`/api/policy-requests/${activePolicyId}/submit`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ scenario }),
                });

                const submitData = await submitRes.json();
                await refreshActivePolicy();
                loadRequestsTable();

            } catch (err) {
                console.error(err);
                alert(`Error: ${err.message}`);
            } finally {
                btn.disabled = false;
                btn.innerText = '🚀 Ingest & Issue';
            }
        }

        async function simulateDuplicateIntake() {
            const intakePayload = {
                client_request_id: document.getElementById('clientRequestId').value.trim(),
                agent_id: document.getElementById('agentId').value.trim(),
                customer_name: document.getElementById('customerName').value.trim(),
                date_of_birth: document.getElementById('dob').value,
                destination: currentDestination,
                trip_start: document.getElementById('tripStart').value,
                trip_end: document.getElementById('tripEnd').value,
                plan_code: currentPlan,
                sum_insured: currentSumInsured,
            };

            const res = await fetch('/api/policy-requests', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(intakePayload),
            });

            const data = await res.json();
            alert(`Duplicate Intake Result:\nHTTP Status: ${res.status}\nis_duplicate: ${data.is_duplicate}\nMessage: ${data.message}`);
            
            if (data.data && data.data.id) {
                activePolicyId = data.data.id;
                refreshActivePolicy();
            }
            loadRequestsTable();
        }

        async function runReconciliation() {
            if (!activePolicyId) {
                alert('Please submit a policy request first.');
                return;
            }

            const res = await fetch(`/api/policy-requests/${activePolicyId}/reconcile`, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
            });

            const data = await res.json();
            alert(`Reconciliation Result:\n${data.message}\nStatus: ${data.data.status}`);
            await refreshActivePolicy();
            loadRequestsTable();
        }

        async function refreshActivePolicy() {
            if (!activePolicyId) return;

            const res = await fetch(`/api/policy-requests/${activePolicyId}`, {
                headers: { 'Accept': 'application/json' },
            });

            if (!res.ok) return;

            const json = await res.json();
            const p = json.data;

            document.getElementById('statusAuditCard').style.display = 'block';
            document.getElementById('statusAuditCard').scrollIntoView({ behavior: 'smooth' });

            const badge = document.getElementById('currentStatusBadge');
            badge.className = `badge-status badge-${p.status}`;
            badge.innerText = p.status;

            document.getElementById('activeClientReqId').innerText = `ID: #${p.id} • ${p.client_request_id}`;
            document.getElementById('policyNumberDisplay').innerText = p.policy_number ? `Policy #: ${p.policy_number}` : '';
            document.getElementById('providerRefDisplay').innerText = p.provider_reference ? `Ref: ${p.provider_reference}` : '';

            // Render Timeline
            const tl = document.getElementById('timelineContainer');
            tl.innerHTML = '';
            (p.audit_trail || []).forEach(h => {
                const item = document.createElement('div');
                item.className = 'timeline-item';
                item.innerHTML = `
                    <div class="timeline-title">${h.from_state ? h.from_state + ' → ' : ''}${h.to_state}</div>
                    <div class="timeline-desc">${h.reason || 'State update'}</div>
                    <div class="timeline-time">${new Date(h.created_at).toLocaleTimeString()}</div>
                `;
                tl.appendChild(item);
            });

            // Render Attempts
            const att = document.getElementById('attemptsContainer');
            att.innerHTML = '';
            (p.attempts || []).forEach(a => {
                const box = document.createElement('div');
                box.style = 'padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px;';
                box.innerHTML = `
                    <div style="font-weight: 700; color: #0a2540;">Attempt #${a.attempt_number} • Status: ${a.status} (HTTP ${a.http_status || 'N/A'})</div>
                    <div style="font-family: monospace; color: #626f86; margin-top: 4px;">${a.idempotency_key}</div>
                    ${a.error_message ? `<div style="color: #bf2600; margin-top: 4px;">Error: ${a.error_message}</div>` : ''}
                `;
                att.appendChild(box);
            });
        }

        async function triggerSimulatedCallback(count) {
            if (!activePolicyId) {
                alert('No active policy selected.');
                return;
            }

            const res = await fetch(`/api/policy-requests/${activePolicyId}`);
            const data = await res.json();
            const p = data.data;

            const cbRes = await fetch('/api/mock-insurer/trigger-callback', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({
                    provider_reference: p.provider_reference || `REF-${Math.random().toString(36).substring(7).toUpperCase()}`,
                    client_request_id: p.client_request_id,
                    duplicate_count: count,
                }),
            });

            const cbData = await cbRes.json();
            alert(`Simulated Callback Delivery (${count}x):\n${JSON.stringify(cbData.results, null, 2)}`);
            await refreshActivePolicy();
            loadRequestsTable();
        }

        async function loadRequestsTable() {
            const filter = document.getElementById('filterStatus').value;
            const url = filter ? `/api/policy-requests?status=${filter}` : '/api/policy-requests';
            
            try {
                const res = await fetch(url);
                const json = await res.json();
                const tbody = document.getElementById('requestsTableBody');
                tbody.innerHTML = '';

                if (!json.data || json.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 24px; color: #8993a4;">No records found. Ingest a policy request above!</td></tr>';
                    return;
                }

                json.data.forEach(r => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><strong>#${r.id}</strong></td>
                        <td><code>${r.client_request_id}</code></td>
                        <td>${r.agent_id}</td>
                        <td>${r.customer_name}</td>
                        <td>${r.trip_start} to ${r.trip_end} (${r.travel_days}d)</td>
                        <td>${r.plan_code} (₹${(r.sum_insured/100000).toFixed(0)}L)</td>
                        <td><strong>₹${Number(r.calculated_premium).toFixed(2)}</strong></td>
                        <td><span class="badge-status badge-${r.status}">${r.status}</span></td>
                        <td>${r.policy_number ? `<code>${r.policy_number}</code>` : '<span style="color: #a5adba;">—</span>'}</td>
                        <td><button class="btn-action btn-secondary" style="padding: 4px 10px; font-size: 11px;" onclick="viewPolicyDetails(${r.id})">Inspect</button></td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (e) {
                console.error(e);
            }
        }

        function viewPolicyDetails(id) {
            activePolicyId = id;
            refreshActivePolicy();
        }

        function scrollToExplorer() {
            document.getElementById('requestsExplorer').scrollIntoView({ behavior: 'smooth' });
        }

        // Init
        window.addEventListener('DOMContentLoaded', () => {
            calculateLive();
            loadRequestsTable();
        });
    </script>
</body>
</html>
