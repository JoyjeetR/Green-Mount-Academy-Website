<!DOCTYPE html>
<!-- Student login: left panel (branding), right panel with Login / Sign Up tabs and Forgot Password slide. Auth handled by student_login.js → auth.php (backend not included in repo). -->
<html lang="en">

<head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>G.M.A — Student Login</title>

      <!-- Bootstrap 5 -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
      <!-- Bootstrap Icons -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
            rel="stylesheet" />

      <link rel="stylesheet" href="../css/student_login.css">
</head>

<body>

      <div class="page-wrapper">
            <!-- Left: branding and feature list; hidden on small screens -->
            <div class="left-panel">
                  <div class="logo">Green Mount Academy
                        <span> <br>Student Dashboard</span>
                  </div>
                  <p class="tagline">Your all-in-one student management dashboard — track fees, results, and more.</p>
                  <ul class="feature-list">
                        <li><i class="bi bi-bar-chart-fill"></i> View exam results & grades</li>
                        <li><i class="bi bi-credit-card-fill"></i> Track fee payments</li>
                        <li><i class="bi bi-bell-fill"></i> School notices & updates</li>
                        <li><i class="bi bi-shield-fill-check"></i> Secure login with recovery</li>
                  </ul>
            </div>

            <!-- Right: sliding panels — Login/Signup (panelAuth) and Forgot Password (panelForgot) -->
            <div class="right-panel" id="rightPanel">
                  <div class="auth-panel active" id="panelAuth">
                        <!-- tab bar -->
                        <div class="auth-tabs">
                              <div class="auth-tab active" id="tabLogin" onclick="switchTab('login')">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                              </div>
                              <div class="auth-tab" id="tabSignup" onclick="switchTab('signup')">
                                    <i class="bi bi-person-plus me-1"></i>Sign Up
                              </div>
                        </div>

                        <!-- ══ LOGIN FORM ══ -->
                        <div id="loginForm">
                              <h2 class="panel-title">Welcome back</h2>
                              <p class="panel-sub">Sign in to access your student portal</p>

                              <div id="loginAlert" class="alert-custom"></div>

                              <div class="mb-3">
                                    <label class="form-label">Admission Number</label>
                                    <div class="input-group">
                                          <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                          <input type="text" class="form-control" id="loginAdm"
                                                placeholder="e.g. ADM2024001" />
                                    </div>
                              </div>

                              <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                          <input type="password" class="form-control" id="loginPass"
                                                placeholder="Enter password" />
                                          <button class="toggle-eye btn" onclick="togglePwd('loginPass',this)"
                                                type="button">
                                                <i class="bi bi-eye"></i>
                                          </button>
                                    </div>
                              </div>

                              <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="rememberMe" />
                                          <label class="form-check-label" for="rememberMe"
                                                style="font-size:.85rem;color:var(--text-light)">Remember me</label>
                                    </div>
                                    <button class="link-btn" onclick="showPanel('panelForgot','reset')">Forgot
                                          password?</button>
                              </div>

                              <button class="btn-primary-custom" onclick="doLogin()">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                              </button>

                              <p class="text-center mt-3" style="font-size:.85rem;color:var(--text-light)">
                                    New student? <button class="link-btn" onclick="switchTab('signup')">Create
                                          account</button>
                              </p>
                        </div>

                        <!-- ══ SIGNUP FORM ══ -->
                        <div id="signupForm" style="display:none">
                              <h2 class="panel-title">Create account</h2>
                              <p class="panel-sub">Register to access your student portal</p>

                              <div id="signupAlert" class="alert-custom"></div>

                              <div class="step-dots">
                                    <div class="dot active" id="dot1"></div>
                                    <div class="dot" id="dot2"></div>
                              </div>

                              <!-- Step 1 -->
                              <div id="signupStep1">
                                    <div class="mb-3">
                                          <label class="form-label">Full Name</label>
                                          <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" id="regName"
                                                      placeholder="Your full name" />
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Admission Number</label>
                                          <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                <input type="text" class="form-control" id="regAdm"
                                                      placeholder="e.g. ADM2024001" />
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Phone Number</label>
                                          <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                                <input type="tel" class="form-control" id="regPhone"
                                                      placeholder="10-digit mobile number" />
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Email Address</label>
                                          <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control" id="regEmail"
                                                      placeholder="you@email.com" />
                                          </div>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Password</label>
                                          <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                <input type="password" class="form-control" id="regPass"
                                                      placeholder="Min 6 characters"
                                                      oninput="checkStrength(this.value)" />
                                                <button class="toggle-eye btn" onclick="togglePwd('regPass',this)"
                                                      type="button">
                                                      <i class="bi bi-eye"></i>
                                                </button>
                                          </div>
                                          <div class="strength-bar mt-2">
                                                <div class="strength-fill" id="strengthFill"></div>
                                          </div>
                                          <small id="strengthLabel"
                                                style="font-size:.78rem;color:var(--text-light)"></small>
                                    </div>
                                    <button class="btn-primary-custom" onclick="goStep2()">
                                          Continue <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                              </div>

                              <!-- Step 2: Security Questions -->
                              <div id="signupStep2" style="display:none">
                                    <p style="font-size:.85rem;color:var(--text-mid);margin-bottom:18px;">
                                          <i class="bi bi-shield-lock me-1 text-success"></i>
                                          Choose 2 security questions you'll use to reset your password.
                                    </p>

                                    <div class="mb-3">
                                          <label class="form-label">Security Question 1</label>
                                          <select class="form-select" id="sq1" onchange="filterQ2()">
                                                <option value="">— Select a question —</option>
                                          </select>
                                    </div>
                                    <div class="mb-3">
                                          <label class="form-label">Your Answer</label>
                                          <input type="text" class="form-control" id="sa1"
                                                placeholder="Your answer (case-insensitive)" />
                                    </div>

                                    <div class="mb-3">
                                          <label class="form-label">Security Question 2</label>
                                          <select class="form-select" id="sq2">
                                                <option value="">— Select a question —</option>
                                          </select>
                                    </div>
                                    <div class="mb-4">
                                          <label class="form-label">Your Answer</label>
                                          <input type="text" class="form-control" id="sa2"
                                                placeholder="Your answer (case-insensitive)" />
                                    </div>

                                    <div class="d-flex gap-2">
                                          <button class="btn-ghost" onclick="goStep1()"><i
                                                      class="bi bi-arrow-left me-1"></i>Back</button>
                                          <button class="btn-primary-custom" style="flex:1" onclick="doSignup()">
                                                <i class="bi bi-person-check me-1"></i>Register
                                          </button>
                                    </div>
                              </div>
                        </div>
                  </div><!-- /panelAuth -->

                  <!-- ─── PANEL 2: FORGOT PASSWORD ─── -->
                  <div class="auth-panel right" id="panelForgot">
                        <button class="btn-ghost mb-3" onclick="showPanel('panelAuth','left')" style="width:auto">
                              <i class="bi bi-arrow-left me-1"></i>Back to Login
                        </button>
                        <h2 class="panel-title">Reset Password</h2>
                        <p class="panel-sub">Verify your identity using your security questions</p>

                        <div id="resetAlert" class="alert-custom"></div>

                        <!-- Step A: Enter admission no -->
                        <div id="resetStep1">
                              <div class="mb-3">
                                    <label class="form-label">Admission Number</label>
                                    <div class="input-group">
                                          <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                          <input type="text" class="form-control" id="resetAdm"
                                                placeholder="Enter your admission number" />
                                    </div>
                              </div>
                              <button class="btn-primary-custom" onclick="fetchResetQuestions()">
                                    <i class="bi bi-search me-2"></i>Find My Account
                              </button>
                        </div>

                        <!-- Step B: Answer questions + new password -->
                        <div id="resetStep2" style="display:none">
                              <div class="mb-3">
                                    <label class="form-label" id="resetQ1Label">Question 1</label>
                                    <input type="text" class="form-control" id="resetA1" placeholder="Your answer" />
                                    <input type="hidden" id="resetQ1Id" />
                              </div>
                              <div class="mb-3">
                                    <label class="form-label" id="resetQ2Label">Question 2</label>
                                    <input type="text" class="form-control" id="resetA2" placeholder="Your answer" />
                                    <input type="hidden" id="resetQ2Id" />
                              </div>

                              <div class="divider">New Password</div>

                              <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                          <input type="password" class="form-control" id="resetNewPass"
                                                placeholder="Min 6 characters" />
                                          <button class="toggle-eye btn" onclick="togglePwd('resetNewPass',this)"
                                                type="button">
                                                <i class="bi bi-eye"></i>
                                          </button>
                                    </div>
                              </div>
                              <div class="mb-4">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                          <input type="password" class="form-control" id="resetConfPass"
                                                placeholder="Re-enter password" />
                                    </div>
                              </div>

                              <div class="d-flex gap-2">
                                    <button class="btn-ghost" onclick="resetStepBack()"><i
                                                class="bi bi-arrow-left"></i></button>
                                    <button class="btn-primary-custom" style="flex:1" onclick="doReset()">
                                          <i class="bi bi-check2-circle me-1"></i>Reset Password
                                    </button>
                              </div>
                        </div>
                  </div><!-- /panelForgot -->

            </div><!-- /rightPanel -->
      </div><!-- /page-wrapper -->

      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="../js/student_login.js"></script>
</body>

</html>