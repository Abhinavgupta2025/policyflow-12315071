<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrippersShield - Travel Insurance</title>
    <!-- Modern Clean Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0056d2;
            --primary-hover: #0043a8;
            --primary-light: #eff5ff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --radius-lg: 14px;
            --radius-md: 10px;
            --radius-sm: 6px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background-color: var(--bg);
            color: var(--text-dark);
            line-height: 1.5;
            padding-bottom: 60px;
        }

        /* Simplified Header */
        header {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-logo-icon {
            width: 34px;
            height: 34px;
            background: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .brand-title span {
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .header-btn {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            transition: all 0.15s;
        }

        .header-btn:hover {
            color: var(--text-dark);
            border-color: #cbd5e1;
        }

        /* Main Container */
        .page-container {
            max-width: 1080px;
            margin: 36px auto;
            padding: 0 20px;
        }

        /* Simple Hero Card (Policybazaar Style, Cleaned Up) */
        .main-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            margin-bottom: 28px;
        }

        .card-header-simple {
            margin-bottom: 24px;
        }

        .card-header-simple h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.4px;
            margin-bottom: 6px;
        }

        .card-header-simple p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Form Controls */
        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .text-input {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            outline: none;
            background: #ffffff;
            color: var(--text-dark);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .text-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 86, 210, 0.1);
        }

        /* Destination Pills */
        .pills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .pill-btn {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
        }

        .pill-btn:hover {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        .pill-btn.active {
            background: var(--primary-light);
            border-color: #bfdbfe;
            color: var(--primary);
            font-weight: 600;
        }

        /* Input Rows */
        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .four-cols {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
        }

        .btn-primary-large {
            width: 100%;
            background: var(--primary);
            color: white;
            font-size: 15px;
            font-weight: 600;
            padding: 14px;
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary-large:hover {
            background: var(--primary-hover);
        }

        /* Plans Section (Clean & Simple) */
        .plans-card {
            display: none;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            margin-bottom: 28px;
        }

        .plans-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .sum-buttons {
            display: flex;
            gap: 6px;
        }

        .sum-btn {
            font-size: 12px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.15s;
        }

        .sum-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .plan-item {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            cursor: pointer;
            position: relative;
            background: white;
            transition: all 0.15s;
        }

        .plan-item:hover {
            border-color: #cbd5e1;
        }

        .plan-item.selected {
            border-color: var(--primary);
            background: #fafcff;
            box-shadow: 0 0 0 1px var(--primary);
        }

        .plan-tag {
            position: absolute;
            top: -10px;
            right: 14px;
            background: #0284c7;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .plan-item-name {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .plan-item-rate {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 14px;
        }

        .plan-item-price {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .plan-item-features {
            list-style: none;
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Formula Box */
        .formula-card {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .formula-code {
            font-family: ui-monospace, Menlo, Monaco, monospace;
            font-size: 12px;
            color: #0f172a;
            background: #ffffff;
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            margin-top: 6px;
            display: block;
        }

        /* Simplified Test Sandbox */
        .sandbox-box {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-md);
            padding: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }

        .sandbox-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 280px;
        }

        .sandbox-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action-simple {
            font-size: 13px;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-issue { background: var(--primary); color: white; }
        .btn-issue:hover { background: var(--primary-hover); }
        .btn-secondary { background: white; border: 1px solid var(--border); color: var(--text-dark); }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }
        .btn-warn { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .btn-warn:hover { background: #fde68a; }

        /* Status & Timeline Section */
        .status-card {
            display: none;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            margin-bottom: 28px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
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
            border-left: 2px solid var(--border);
            padding-left: 16px;
            margin-left: 8px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 14px;
        }

        .timeline-node {
            position: relative;
        }

        .timeline-node::before {
            content: '';
            position: absolute;
            left: -21px;
            top: 5px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
        }

        /* Simplified Table */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        }

        .simple-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 14px;
        }

        .simple-table th {
            text-align: left;
            padding: 10px 12px;
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        .simple-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .simple-table tr:hover {
            background: #f8fafc;
        }

        @media (max-width: 768px) {
            .two-cols, .four-cols, .plans-grid { grid-template-columns: 1fr; }
            .sandbox-box { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <a href="/" class="brand-link">
            <div class="brand-logo-icon">🛡️</div>
            <div class="brand-title">Trippers<span>Shield</span></div>
        </a>
        <div class="header-actions">
            <button class="header-btn" onclick="scrollToTable()">Requests Log</button>
        </div>
    </header>

    <div class="page-container">

        <!-- Policy Intake Form Card -->
        <section class="main-card">
            <div class="card-header-simple">
                <h1>Travel Insurance Purchase Intake</h1>
                <p>Fill out the travel details below to calculate deterministic premium and issue policy.</p>
            </div>

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

                <!-- Traveller & Agent Details -->
                <div class="info-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-size: 13px; font-weight: 600;">Customer & Request Identification</span>
                        <span style="font-size: 12px; color: var(--primary); cursor: pointer;" onclick="randomizeRequestId()">⚡ New Client Request ID</span>
                    </div>
                    <div class="four-cols">
                        <div>
                            <label class="field-label" style="font-size: 12px; font-weight: 500;">Customer Name</label>
                            <input type="text" id="customerName" class="text-input" value="Sample Customer">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 12px; font-weight: 500;">Date of Birth</label>
                            <input type="date" id="dob" class="text-input" value="1998-04-10" onchange="calculateLive()">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 12px; font-weight: 500;">Agent ID</label>
                            <input type="text" id="agentId" class="text-input" value="AGENT-17">
                        </div>
                        <div>
                            <label class="field-label" style="font-size: 12px; font-weight: 500;">Client Request ID</label>
                            <input type="text" id="clientRequestId" class="text-input" value="AGT-2026-0001">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-primary-large" onclick="showPlans()">
                    View Plans & Calculate Premium →
                </button>
            </div>
        </section>

        <!-- Plans & Pricing Comparison Card -->
        <section class="plans-card" id="plansCard">
            <div class="plans-topbar">
                <div>
                    <h2 style="font-size: 18px; font-weight: 700;">Compare Plans</h2>
                    <p style="font-size: 13px; color: var(--text-muted);" id="tripSummarySubtitle">5 Days • International • Age 28</p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">Sum Insured:</span>
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
                    <div class="plan-item-name">BASIC</div>
                    <div class="plan-item-rate">Base ₹12/day</div>
                    <div class="plan-item-price" id="priceBASIC">₹135.00</div>
                    <ul class="plan-item-features">
                        <li>• Emergency Medical Evacuation</li>
                        <li>• Baggage Delay/Loss Cover</li>
                    </ul>
                </div>

                <div class="plan-item selected" id="planBoxPLUS" onclick="selectPlan('PLUS')">
                    <span class="plan-tag">Popular</span>
                    <div class="plan-item-name">PLUS</div>
                    <div class="plan-item-rate">Base ₹20/day</div>
                    <div class="plan-item-price" id="pricePLUS">₹225.00</div>
                    <ul class="plan-item-features">
                        <li>• All Basic Plan Benefits</li>
                        <li>• Trip Cancellation & Curtailment</li>
                        <li>• Cashless Hospitalisation</li>
                    </ul>
                </div>

                <div class="plan-item" id="planBoxPREMIUM" onclick="selectPlan('PREMIUM')">
                    <div class="plan-item-name">PREMIUM</div>
                    <div class="plan-item-rate">Base ₹30/day</div>
                    <div class="plan-item-price" id="pricePREMIUM">₹337.50</div>
                    <ul class="plan-item-features">
                        <li>• All Plus Plan Benefits</li>
                        <li>• Adventure Sports & Personal Liability</li>
                        <li>• Zero Claim Deductibles</li>
                    </ul>
                </div>
            </div>

            <!-- Pricing Breakdown -->
            <div class="formula-card">
                <div style="font-weight: 600; color: var(--text-dark);">Deterministic Pricing Breakdown</div>
                <code class="formula-code" id="formulaDisplay">
                    premium = base_daily_rate(₹20) × travel_days(5) × age_multiplier(1.00) × destination_multiplier(1.80) × coverage_multiplier(1.25) = ₹225.00
                </code>
            </div>

            <!-- Mock Insurer Testing Sandbox -->
            <div class="sandbox-box">
                <div class="sandbox-left">
                    <span style="font-size: 13px; font-weight: 600; white-space: nowrap;">Insurer Scenario:</span>
                    <select id="scenarioSelect" class="text-input" style="padding: 8px 12px; font-size: 13px;">
                        <option value="SUCCESS">🟢 SUCCESS (Issue immediately)</option>
                        <option value="TEMPORARY_FAILURE">🔴 TEMPORARY_FAILURE (503 retriable)</option>
                        <option value="TIMEOUT_AFTER_ISSUE">🟡 TIMEOUT_AFTER_ISSUE (Requires reconcile)</option>
                        <option value="DELAYED_CALLBACK">🔵 DELAYED_CALLBACK (Async webhook)</option>
                        <option value="DUPLICATE_CALLBACK">🟣 DUPLICATE_CALLBACK (Webhook deduplication)</option>
                    </select>
                </div>

                <div class="sandbox-actions">
                    <button type="button" class="btn-action-simple btn-issue" id="btnSubmit" onclick="runIntakeAndSubmit()">Submit & Issue</button>
                    <button type="button" class="btn-action-simple btn-secondary" onclick="simulateDuplicateIntake()">Test Duplicate</button>
                    <button type="button" class="btn-action-simple btn-warn" onclick="runReconciliation()">Reconcile</button>
                </div>
            </div>
        </section>

        <!-- Status & Audit Trail Card -->
        <section class="status-card" id="statusCard">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                <div>
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">STATUS:</span>
                    <span class="status-badge status-VALIDATED" id="statusBadge">VALIDATED</span>
                    <span id="activeReqText" style="margin-left: 10px; font-size: 13px; font-weight: 600;"></span>
                </div>
                <div style="display: flex; gap: 14px; font-size: 13px;">
                    <div id="policyNumberText" style="font-weight: 600; color: #166534;"></div>
                    <div id="providerRefText" style="color: var(--text-muted);"></div>
                    <button class="header-btn" style="padding: 4px 8px; font-size: 11px;" onclick="refreshActivePolicy()">↻ Refresh</button>
                </div>
            </div>

            <div class="two-cols">
                <div>
                    <div style="font-size: 13px; font-weight: 600; margin-bottom: 8px;">State Transition History</div>
                    <div class="timeline-clean" id="timelineContainer"></div>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 600; margin-bottom: 8px;">Issuance Attempts</div>
                    <div id="attemptsContainer" style="display: flex; flex-direction: column; gap: 8px;"></div>
                </div>
            </div>
        </section>

        <!-- Requests Log Table -->
        <section class="table-card" id="requestsTableSection">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700;">Policy Requests Log</h3>
                    <p style="font-size: 12px; color: var(--text-muted);">All persisted policy requests in the database</p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <select id="filterStatus" class="text-input" style="padding: 6px 10px; font-size: 12px; width: auto;" onchange="loadRequestsTable()">
                        <option value="">All Statuses</option>
                        <option value="RECEIVED">RECEIVED</option>
                        <option value="VALIDATED">VALIDATED</option>
                        <option value="SUBMITTED">SUBMITTED</option>
                        <option value="PENDING_CONFIRMATION">PENDING_CONFIRMATION</option>
                        <option value="ISSUED">ISSUED</option>
                        <option value="FAILED">FAILED</option>
                        <option value="NEEDS_RECONCILIATION">NEEDS_RECONCILIATION</option>
                    </select>
                    <button class="header-btn" style="padding: 6px 12px; font-size: 12px;" onclick="loadRequestsTable()">↻</button>
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
                        <tr><td colspan="10" style="text-align: center; color: var(--text-muted); padding: 20px;">Loading...</td></tr>
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
                    <div style="font-size: 12px; color: var(--text-muted);">${h.reason || ''}</div>
                    <div style="font-size: 11px; color: #94a3b8;">${new Date(h.created_at).toLocaleTimeString()}</div>
                `;
                tl.appendChild(item);
            });

            const att = document.getElementById('attemptsContainer');
            att.innerHTML = '';
            (p.attempts || []).forEach(a => {
                const box = document.createElement('div');
                box.style = 'padding: 8px 12px; background: #f8fafc; border: 1px solid var(--border); border-radius: 6px; font-size: 12px;';
                box.innerHTML = `
                    <div style="font-weight: 600;">Attempt #${a.attempt_number} • ${a.status} (${a.http_status || 'N/A'})</div>
                    <div style="font-family: monospace; font-size: 11px; color: var(--text-muted);">${a.idempotency_key}</div>
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
                    tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 18px; color: var(--text-muted);">No records found.</td></tr>';
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
