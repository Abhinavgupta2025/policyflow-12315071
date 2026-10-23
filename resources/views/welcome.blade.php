<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrippersShield - Travel Insurance</title>
    <!-- Editorial Luxury Typography: Playfair Display + Cormorant Garamond + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-display: 'Playfair Display', Georgia, serif;
            --font-serif-sub: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Plus Jakarta Sans', -apple-system, sans-serif;
            
            --luxury-dark: #121316;
            --luxury-card: #ffffff;
            --luxury-bg: #f7f6f4;
            --luxury-accent: #1e3a8a;
            --luxury-gold: #c5a880;
            --luxury-muted: #6b7280;
            --luxury-border: #e7e5e0;
            --radius-md: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
        }

        body {
            background-color: var(--luxury-bg);
            color: var(--luxury-dark);
            line-height: 1.5;
            padding-bottom: 60px;
        }

        /* Editorial Header */
        header {
            background: #ffffff;
            border-bottom: 1px solid var(--luxury-border);
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo-text {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--luxury-dark);
        }

        .header-tagline {
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--luxury-muted);
            margin-left: 8px;
            padding-left: 10px;
            border-left: 1px solid var(--luxury-border);
        }

        .header-btn {
            font-family: var(--font-body);
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--luxury-dark);
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 4px;
            border: 1px solid var(--luxury-dark);
            background: transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .header-btn:hover {
            background: var(--luxury-dark);
            color: white;
        }

        /* Page Container */
        .page-container {
            max-width: 1040px;
            margin: 40px auto;
            padding: 0 24px;
        }

        /* Editorial Main Card */
        .editorial-card {
            background: var(--luxury-card);
            border: 1px solid var(--luxury-border);
            border-radius: var(--radius-md);
            padding: 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02);
            margin-bottom: 32px;
        }

        .eyebrow-text {
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #8c7851;
            margin-bottom: 12px;
            display: block;
        }

        .display-title {
            font-family: var(--font-display);
            font-size: 42px;
            font-weight: 500;
            color: var(--luxury-dark);
            line-height: 1.18;
            margin-bottom: 14px;
            letter-spacing: -0.01em;
        }

        .display-title em {
            font-family: var(--font-display);
            font-style: italic;
            font-weight: 400;
            color: #3b4252;
        }

        .display-desc {
            font-size: 14px;
            color: var(--luxury-muted);
            max-width: 680px;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        /* Form Controls */
        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .field-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--luxury-dark);
            margin-bottom: 8px;
            display: block;
        }

        .text-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 1px solid var(--luxury-border);
            border-radius: 6px;
            outline: none;
            background: #ffffff;
            color: var(--luxury-dark);
            transition: all 0.2s;
        }

        .text-input:focus {
            border-color: var(--luxury-dark);
            box-shadow: 0 0 0 1px var(--luxury-dark);
        }

        /* Destination Pills */
        .pills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .pill-btn {
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 500;
            color: var(--luxury-muted);
            background: #f8fafc;
            border: 1px solid var(--luxury-border);
            padding: 7px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .pill-btn:hover {
            border-color: var(--luxury-dark);
            color: var(--luxury-dark);
        }

        .pill-btn.active {
            background: var(--luxury-dark);
            border-color: var(--luxury-dark);
            color: #ffffff;
            font-weight: 600;
        }

        /* Columns */
        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .four-cols {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .info-box {
            background: #fafaf9;
            border: 1px solid var(--luxury-border);
            border-radius: 6px;
            padding: 20px;
        }

        .btn-luxury-action {
            width: 100%;
            background: var(--luxury-dark);
            color: white;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-luxury-action:hover {
            background: #2b2d35;
        }

        /* Plans Section */
        .plans-card {
            display: none;
            background: var(--luxury-card);
            border: 1px solid var(--luxury-border);
            border-radius: var(--radius-md);
            padding: 36px 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02);
            margin-bottom: 32px;
        }

        .plans-topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--luxury-border);
        }

        .plans-title-serif {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 600;
            color: var(--luxury-dark);
            margin-bottom: 4px;
        }

        .sum-buttons {
            display: flex;
            gap: 8px;
        }

        .sum-btn {
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 4px;
            border: 1px solid var(--luxury-border);
            background: white;
            color: var(--luxury-dark);
            cursor: pointer;
            transition: all 0.2s;
        }

        .sum-btn.active {
            background: var(--luxury-dark);
            color: white;
            border-color: var(--luxury-dark);
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .plan-item {
            border: 1px solid var(--luxury-border);
            border-radius: 6px;
            padding: 24px;
            cursor: pointer;
            position: relative;
            background: white;
            transition: all 0.2s;
        }

        .plan-item:hover {
            border-color: var(--luxury-dark);
        }

        .plan-item.selected {
            border-color: var(--luxury-dark);
            box-shadow: 0 0 0 1px var(--luxury-dark);
            background: #fafaf9;
        }

        .plan-tag {
            position: absolute;
            top: -10px;
            right: 16px;
            background: #8c7851;
            color: white;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 4px;
        }

        .plan-item-name {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .plan-item-rate {
            font-size: 12px;
            color: var(--luxury-muted);
            margin-bottom: 16px;
        }

        .plan-item-price {
            font-family: var(--font-display);
            font-size: 32px;
            font-weight: 600;
            color: var(--luxury-dark);
            margin-bottom: 14px;
        }

        .plan-item-features {
            list-style: none;
            font-size: 12px;
            color: var(--luxury-muted);
            display: flex;
            flex-direction: column;
            gap: 8px;
            border-top: 1px solid #f1f0ee;
            padding-top: 14px;
        }

        /* Formula Card */
        .formula-card {
            background: #fafaf9;
            border: 1px solid var(--luxury-border);
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 28px;
            font-size: 13px;
        }

        .formula-code {
            font-family: ui-monospace, Menlo, Monaco, monospace;
            font-size: 12px;
            color: var(--luxury-dark);
            background: #ffffff;
            border: 1px solid var(--luxury-border);
            padding: 10px 14px;
            border-radius: 4px;
            margin-top: 8px;
            display: block;
        }

        /* Sandbox */
        .sandbox-box {
            background: #f7f6f4;
            border: 1px solid #ded9d1;
            border-radius: 6px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            justify-content: space-between;
        }

        .sandbox-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 300px;
        }

        .btn-action-serif {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 11px 18px;
            border-radius: 4px;
            border: 1px solid var(--luxury-dark);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-issue { background: var(--luxury-dark); color: white; }
        .btn-issue:hover { background: #2b2d35; }
        .btn-outline { background: white; color: var(--luxury-dark); }
        .btn-outline:hover { background: #f1f0ee; }

        /* Status & Timeline */
        .status-card {
            display: none;
            background: var(--luxury-card);
            border: 1px solid var(--luxury-border);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02);
            margin-bottom: 32px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .status-ISSUED { background: #dcfce7; color: #166534; }
        .status-VALIDATED { background: #e0f2fe; color: #0369a1; }
        .status-SUBMITTED { background: #ede9fe; color: #6d28d9; }
        .status-PENDING_CONFIRMATION { background: #fef3c7; color: #92400e; }
        .status-NEEDS_RECONCILIATION { background: #ffedd5; color: #c2410c; }
        .status-FAILED { background: #fee2e2; color: #991b1b; }

        .timeline-clean {
            border-left: 2px solid var(--luxury-border);
            padding-left: 18px;
            margin-left: 8px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 14px;
        }

        .timeline-node {
            position: relative;
        }

        .timeline-node::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--luxury-dark);
            border: 2px solid #ffffff;
        }

        /* Requests Table */
        .table-card {
            background: var(--luxury-card);
            border: 1px solid var(--luxury-border);
            border-radius: var(--radius-md);
            padding: 32px 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02);
        }

        .table-title-serif {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 600;
            color: var(--luxury-dark);
        }

        .simple-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 16px;
        }

        .simple-table th {
            text-align: left;
            padding: 12px 14px;
            background: #fafaf9;
            color: var(--luxury-muted);
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 11px;
            border-bottom: 1px solid var(--luxury-border);
        }

        .simple-table td {
            padding: 14px;
            border-bottom: 1px solid #f3f2ef;
        }

        .simple-table tr:hover {
            background: #fafaf9;
        }

        @media (max-width: 768px) {
            .display-title { font-size: 32px; }
            .two-cols, .four-cols, .plans-grid { grid-template-columns: 1fr; }
            .sandbox-box { flex-direction: column; align-items: stretch; }
            .plans-topbar { flex-direction: column; align-items: flex-start; gap: 14px; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <a href="/" class="brand-link">
            <div class="brand-logo-text">TRIPPERSSHIELD</div>
            <span class="header-tagline">Travel Insurance</span>
        </a>
        <div>
            <button class="header-btn" onclick="scrollToTable()">Operations Log</button>
        </div>
    </header>

    <div class="page-container">

        <!-- Editorial Hero & Intake Form -->
        <section class="editorial-card">
            <span class="eyebrow-text">TrippersShield • Fictional Distribution Engine</span>
            <h1 class="display-title">
                Travel Insurance,<br>
                <em>safely orchestrated.</em>
            </h1>
            <p class="display-desc">
                Deterministic policy pricing, concurrency-safe duplicate prevention, and automated mock insurer reconciliation built for campus engineering assessment.
            </p>

            <div class="form-grid">
                <!-- Destination -->
                <div>
                    <label class="field-label" for="destinationInput">Destination Country</label>
                    <input type="text" id="destinationInput" class="text-input" value="United Kingdom" oninput="updateDestinationType()">
                    <div class="pills-container">
                        <button type="button" class="pill-btn" onclick="selectDestination('Domestic India', 'DOMESTIC')">Domestic India</button>
                        <button type="button" class="pill-btn" onclick="selectDestination('Schengen Area', 'INTERNATIONAL')">Schengen Area</button>
                        <button type="button" class="pill-btn" onclick="selectDestination('USA', 'INTERNATIONAL')">USA</button>
                        <button type="button" class="pill-btn" onclick="selectDestination('UAE', 'INTERNATIONAL')">UAE</button>
                        <button type="button" class="pill-btn" onclick="selectDestination('Germany', 'INTERNATIONAL')">Germany</button>
                        <button type="button" class="pill-btn active" onclick="selectDestination('United Kingdom', 'INTERNATIONAL')">United Kingdom</button>
                        <button type="button" class="pill-btn" onclick="selectDestination('Thailand', 'INTERNATIONAL')">Thailand</button>
                    </div>
                </div>

                <!-- Dates -->
                <div class="two-cols">
                    <div>
                        <label class="field-label" for="tripStart">Trip Start Date</label>
                        <input type="date" id="tripStart" class="text-input" value="2026-11-10" onchange="calculateLive()">
                    </div>
                    <div>
                        <label class="field-label" for="tripEnd">Trip End Date</label>
                        <input type="date" id="tripEnd" class="text-input" value="2026-11-14" onchange="calculateLive()">
                    </div>
                </div>

                <!-- Traveller & Request Identification -->
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span class="field-label" style="margin-bottom: 0;">Identification & Agent Credentials</span>
                        <span style="font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #8c7851; cursor: pointer; font-weight: 700;" onclick="randomizeRequestId()">
                            ⚡ Generate New Request ID
                        </span>
                    </div>
                    <div class="four-cols">
                        <div>
                            <label class="field-label" style="font-size: 11px;">Customer Name</label>
                            <input type="text" id="customerName" class="text-input" value="Sample Customer">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 11px;">Date of Birth</label>
                            <input type="date" id="dob" class="text-input" value="1998-04-10" onchange="calculateLive()">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 11px;">Agent ID</label>
                            <input type="text" id="agentId" class="text-input" value="AGENT-17">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 11px;">Client Request ID</label>
                            <input type="text" id="clientRequestId" class="text-input" value="AGT-2026-0001">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-luxury-action" onclick="showPlans()">
                    Calculate Premium & Explore Plans →
                </button>
            </div>
        </section>

        <!-- Plans & Pricing Comparison Card -->
        <section class="plans-card" id="plansCard">
            <div class="plans-topbar">
                <div>
                    <h2 class="plans-title-serif">Coverage Plans</h2>
                    <p style="font-size: 13px; color: var(--luxury-muted);" id="tripSummarySubtitle">5 Days • International • Age 28</p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--luxury-muted);">Sum Insured:</span>
                    <div class="sum-buttons">
                        <button type="button" class="sum-btn" onclick="selectSumInsured(100000)">₹1,00,000</button>
                        <button type="button" class="sum-btn active" onclick="selectSumInsured(300000)">₹3,00,000</button>
                        <button type="button" class="sum-btn" onclick="selectSumInsured(500000)">₹5,00,000</button>
                    </div>
                </div>
            </div>

            <!-- Plans Grid -->
            <div class="plans-grid">
                <div class="plan-item" id="planBoxBASIC" onclick="selectPlan('BASIC')">
                    <div class="plan-item-name">Basic</div>
                    <div class="plan-item-rate">₹12 per day base</div>
                    <div class="plan-item-price" id="priceBASIC">₹135.00</div>
                    <ul class="plan-item-features">
                        <li>• Emergency Inpatient Hospitalisation</li>
                        <li>• Baggage Delay & Loss Protection</li>
                    </ul>
                </div>

                <div class="plan-item selected" id="planBoxPLUS" onclick="selectPlan('PLUS')">
                    <span class="plan-tag">Recommended</span>
                    <div class="plan-item-name">Plus</div>
                    <div class="plan-item-rate">₹20 per day base</div>
                    <div class="plan-item-price" id="pricePLUS">₹225.00</div>
                    <ul class="plan-item-features">
                        <li>• All Basic Plan Coverages</li>
                        <li>• Trip Interruption & Flight Cancellation</li>
                        <li>• Worldwide Cashless OPD Network</li>
                    </ul>
                </div>

                <div class="plan-item" id="planBoxPREMIUM" onclick="selectPlan('PREMIUM')">
                    <div class="plan-item-name">Premium</div>
                    <div class="plan-item-rate">₹30 per day base</div>
                    <div class="plan-item-price" id="pricePREMIUM">₹337.50</div>
                    <ul class="plan-item-features">
                        <li>• All Plus Plan Coverages</li>
                        <li>• High-Altitude Sports & Personal Liability</li>
                        <li>• Zero Claim Deductibles</li>
                    </ul>
                </div>
            </div>

            <!-- Pricing Breakdown -->
            <div class="formula-card">
                <div style="font-weight: 600; font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase; color: #8c7851;">
                    Deterministic Pricing Snapshot
                </div>
                <code class="formula-code" id="formulaDisplay">
                    premium = base_rate(₹20) × travel_days(5) × age_multiplier(1.00) × destination_multiplier(1.80) × coverage_multiplier(1.25) = ₹225.00
                </code>
            </div>

            <!-- Mock Insurer Testing Sandbox -->
            <div class="sandbox-box">
                <div class="sandbox-left">
                    <span style="font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; white-space: nowrap;">Scenario:</span>
                    <select id="scenarioSelect" class="text-input" style="padding: 9px 12px; font-size: 13px;">
                        <option value="SUCCESS">🟢 SUCCESS (Issue immediately)</option>
                        <option value="TEMPORARY_FAILURE">🔴 TEMPORARY_FAILURE (503 retriable)</option>
                        <option value="TIMEOUT_AFTER_ISSUE">🟡 TIMEOUT_AFTER_ISSUE (Requires reconcile)</option>
                        <option value="DELAYED_CALLBACK">🔵 DELAYED_CALLBACK (Async webhook)</option>
                        <option value="DUPLICATE_CALLBACK">🟣 DUPLICATE_CALLBACK (Webhook deduplication)</option>
                    </select>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn-action-serif btn-issue" id="btnSubmit" onclick="runIntakeAndSubmit()">Submit & Issue</button>
                    <button type="button" class="btn-action-serif btn-outline" onclick="simulateDuplicateIntake()">Test Duplicate</button>
                    <button type="button" class="btn-action-serif btn-outline" onclick="runReconciliation()">Reconcile</button>
                </div>
            </div>
        </section>

        <!-- Status & Audit Trail Card -->
        <section class="status-card" id="statusCard">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--luxury-border);">
                <div>
                    <span style="font-size: 11px; color: var(--luxury-muted); font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;">STATUS:</span>
                    <span class="status-badge status-VALIDATED" id="statusBadge">VALIDATED</span>
                    <span id="activeReqText" style="margin-left: 10px; font-size: 13px; font-weight: 600;"></span>
                </div>
                <div style="display: flex; gap: 16px; font-size: 13px;">
                    <div id="policyNumberText" style="font-weight: 700; color: #166534;"></div>
                    <div id="providerRefText" style="color: var(--luxury-muted);"></div>
                    <button class="header-btn" style="padding: 4px 10px; font-size: 11px;" onclick="refreshActivePolicy()">↻ Refresh</button>
                </div>
            </div>

            <div class="two-cols">
                <div>
                    <div class="field-label">State Transition History</div>
                    <div class="timeline-clean" id="timelineContainer"></div>
                </div>
                <div>
                    <div class="field-label">Issuance Attempts & Idempotency</div>
                    <div id="attemptsContainer" style="display: flex; flex-direction: column; gap: 8px;"></div>
                </div>
            </div>
        </section>

        <!-- Requests Log Table -->
        <section class="table-card" id="requestsTableSection">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 18px;">
                <div>
                    <h3 class="table-title-serif">Policy Requests Registry</h3>
                    <p style="font-size: 13px; color: var(--luxury-muted);">Persisted policy purchase records with audit trails and unique constraints</p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <select id="filterStatus" class="text-input" style="padding: 7px 12px; font-size: 12px; width: auto;" onchange="loadRequestsTable()">
                        <option value="">All Statuses</option>
                        <option value="RECEIVED">RECEIVED</option>
                        <option value="VALIDATED">VALIDATED</option>
                        <option value="SUBMITTED">SUBMITTED</option>
                        <option value="PENDING_CONFIRMATION">PENDING_CONFIRMATION</option>
                        <option value="ISSUED">ISSUED</option>
                        <option value="FAILED">FAILED</option>
                        <option value="NEEDS_RECONCILIATION">NEEDS_RECONCILIATION</option>
                    </select>
                    <button class="header-btn" style="padding: 7px 14px; font-size: 12px;" onclick="loadRequestsTable()">↻</button>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Request ID</th>
                            <th>Agent</th>
                            <th>Customer</th>
                            <th>Dates</th>
                            <th>Plan / Sum</th>
                            <th>Premium</th>
                            <th>Status</th>
                            <th>Policy Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTableBody">
                        <tr><td colspan="10" style="text-align: center; color: var(--luxury-muted); padding: 20px;">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    <!-- Script -->
    <script>
        let currentDestination = 'INTERNATIONAL';
        let currentPlan = 'PLUS';
        let currentSumInsured = 300000;
        let activePolicyId = null;

        const BASE_RATES = { BASIC: 12.00, PLUS: 20.00, PREMIUM: 30.00 };
        const DEST_MULTIPLIERS = { DOMESTIC: 1.00, INTERNATIONAL: 1.80 };
        const COV_MULTIPLIERS = { 100000: 1.00, 300000: 1.25, 500000: 1.50 };

        function selectDestination(name, type) {
            document.getElementById('destinationInput').value = name;
            currentDestination = type;
            document.querySelectorAll('.pill-btn').forEach(b => {
                b.classList.toggle('active', b.innerText.includes(name.split(' ')[0]));
            });
            calculateLive();
        }

        function updateDestinationType() {
            const val = document.getElementById('destinationInput').value.toLowerCase();
            currentDestination = (val.includes('india') || val.includes('domestic')) ? 'DOMESTIC' : 'INTERNATIONAL';
            calculateLive();
        }

        function selectSumInsured(amount) {
            currentSumInsured = amount;
            document.querySelectorAll('.sum-btn').forEach(b => {
                b.classList.toggle('active', b.innerText.includes(amount.toLocaleString('en-IN')));
            });
            calculateLive();
        }

        function selectPlan(plan) {
            currentPlan = plan;
            document.querySelectorAll('.plan-item').forEach(p => p.classList.remove('selected'));
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
            if (m < 0 || (m === 0 && s.getDate() < b.getDate())) age--;
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
            const days = Math.max(1, Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1);
            const age = getAge(dobVal, startVal);
            const ageMul = getAgeMultiplier(age);
            const destMul = DEST_MULTIPLIERS[currentDestination] || 1.80;
            const covMul = COV_MULTIPLIERS[currentSumInsured] || 1.25;

            ['BASIC', 'PLUS', 'PREMIUM'].forEach(plan => {
                const base = BASE_RATES[plan];
                const total = (base * days * ageMul * destMul * covMul).toFixed(2);
                document.getElementById(`price${plan}`).innerText = `₹${total}`;
            });

            document.getElementById('tripSummarySubtitle').innerText = `${days} Days • ${currentDestination} • Age ${age} (${ageMul.toFixed(2)}x)`;

            const currentBase = BASE_RATES[currentPlan];
            const currentTotal = (currentBase * days * ageMul * destMul * covMul).toFixed(2);
            document.getElementById('formulaDisplay').innerText = 
                `premium = base_rate(₹${currentBase}) × travel_days(${days}) × age_multiplier(${ageMul.toFixed(2)}) × destination_multiplier(${destMul.toFixed(2)}) × coverage_multiplier(${covMul.toFixed(2)}) = ₹${currentTotal}`;
        }

        function showPlans() {
            calculateLive();
            const el = document.getElementById('plansCard');
            el.style.display = 'block';
            el.scrollIntoView({ behavior: 'smooth' });
        }

        async function runIntakeAndSubmit() {
            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerText = 'Processing...';

            try {
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

                const scenario = document.getElementById('scenarioSelect').value;
                await fetch(`/api/policy-requests/${activePolicyId}/submit`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ scenario }),
                });

                await refreshActivePolicy();
                loadRequestsTable();
            } catch (err) {
                alert(`Error: ${err.message}`);
            } finally {
                btn.disabled = false;
                btn.innerText = 'Submit & Issue';
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
            alert(`Duplicate Check:\nHTTP ${res.status}\nis_duplicate: ${data.is_duplicate}\n${data.message}`);
            if (data.data?.id) {
                activePolicyId = data.data.id;
                refreshActivePolicy();
            }
            loadRequestsTable();
        }

        async function runReconciliation() {
            if (!activePolicyId) {
                alert('Submit a policy request first.');
                return;
            }
            const res = await fetch(`/api/policy-requests/${activePolicyId}/reconcile`, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();
            alert(`Reconciliation:\n${data.message}\nStatus: ${data.data.status}`);
            await refreshActivePolicy();
            loadRequestsTable();
        }

        async function refreshActivePolicy() {
            if (!activePolicyId) return;
            const res = await fetch(`/api/policy-requests/${activePolicyId}`, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;

            const json = await res.json();
            const p = json.data;

            const card = document.getElementById('statusCard');
            card.style.display = 'block';
            card.scrollIntoView({ behavior: 'smooth' });

            const badge = document.getElementById('statusBadge');
            badge.className = `status-badge status-${p.status}`;
            badge.innerText = p.status;

            document.getElementById('activeReqText').innerText = `#${p.id} • ${p.client_request_id}`;
            document.getElementById('policyNumberText').innerText = p.policy_number ? `Policy: ${p.policy_number}` : '';
            document.getElementById('providerRefText').innerText = p.provider_reference ? `Ref: ${p.provider_reference}` : '';

            const tl = document.getElementById('timelineContainer');
            tl.innerHTML = '';
            (p.audit_trail || []).forEach(h => {
                const item = document.createElement('div');
                item.className = 'timeline-node';
                item.innerHTML = `
                    <div style="font-weight: 600; font-size: 13px;">${h.from_state ? h.from_state + ' → ' : ''}${h.to_state}</div>
                    <div style="font-size: 12px; color: var(--luxury-muted);">${h.reason || ''}</div>
                    <div style="font-size: 11px; color: #94a3b8;">${new Date(h.created_at).toLocaleTimeString()}</div>
                `;
                tl.appendChild(item);
            });

            const att = document.getElementById('attemptsContainer');
            att.innerHTML = '';
            (p.attempts || []).forEach(a => {
                const box = document.createElement('div');
                box.style = 'padding: 8px 12px; background: #fafaf9; border: 1px solid var(--luxury-border); border-radius: 4px; font-size: 12px;';
                box.innerHTML = `
                    <div style="font-weight: 600;">Attempt #${a.attempt_number} • ${a.status} (${a.http_status || 'N/A'})</div>
                    <div style="font-family: monospace; font-size: 11px; color: var(--luxury-muted);">${a.idempotency_key}</div>
                    ${a.error_message ? `<div style="color: #991b1b; font-size: 11px;">${a.error_message}</div>` : ''}
                `;
                att.appendChild(box);
            });
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
                    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 18px; color: var(--luxury-muted);">No records found.</td></tr>';
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
                        <td><span class="status-badge status-${r.status}">${r.status}</span></td>
                        <td>${r.policy_number ? `<code>${r.policy_number}</code>` : '<span style="color: #94a3b8;">—</span>'}</td>
                        <td><button class="header-btn" style="padding: 2px 8px; font-size: 11px;" onclick="viewPolicy(${r.id})">Inspect</button></td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (e) {
                console.error(e);
            }
        }

        function viewPolicy(id) {
            activePolicyId = id;
            refreshActivePolicy();
        }

        function scrollToTable() {
            document.getElementById('requestsTableSection').scrollIntoView({ behavior: 'smooth' });
        }

        window.addEventListener('DOMContentLoaded', () => {
            calculateLive();
            loadRequestsTable();
        });
    </script>
</body>
</html>
