/**
 * student_login.js — Student login page: Login, Sign Up, Forgot Password.
 * All auth actions POST to auth.php (action: login | signup | get_questions | get_reset_questions | reset_password).
 * Requires backend auth.php and DB tables for students and security questions.
 */
/* ════════════════════════════════════════════
      STATE & HELPERS
════════════════════════════════════════════ */
let allQuestions = [];
let resetQuestions = [];

function showAlert(id, msg, type = 'error') {
      const el = document.getElementById(id);
      el.className = 'alert-custom ' + (type === 'error' ? 'alert-error' : 'alert-success');
      el.textContent = msg;
      el.style.display = 'block';
      if (type === 'success') setTimeout(() => el.style.display = 'none', 4000);
}
function hideAlert(id) { document.getElementById(id).style.display = 'none'; }

function togglePwd(id, btn) {
      const inp = document.getElementById(id);
      const icon = btn.querySelector('i');
      if (inp.type === 'password') {
            inp.type = 'text';
            icon.className = 'bi bi-eye-slash';
      } else {
            inp.type = 'password';
            icon.className = 'bi bi-eye';
      }
}

/* Panel slide transitions */
function showPanel(targetId, currentDirection) {
      const panels = document.querySelectorAll('.auth-panel');
      panels.forEach(p => {
            if (p.id === targetId) {
                  p.classList.remove('left', 'right');
                  p.classList.add('active');
            } else if (p.classList.contains('active')) {
                  p.classList.remove('active');
                  p.classList.add(currentDirection === 'reset' ? 'left' : 'right');
            }
      });
}

/* Tab switch between Login / Signup inside panelAuth */
function switchTab(tab) {
      const lf = document.getElementById('loginForm');
      const sf = document.getElementById('signupForm');
      const tl = document.getElementById('tabLogin');
      const ts = document.getElementById('tabSignup');
      hideAlert('loginAlert'); hideAlert('signupAlert');
      if (tab === 'login') {
            lf.style.display = 'block'; sf.style.display = 'none';
            tl.classList.add('active'); ts.classList.remove('active');
      } else {
            lf.style.display = 'none'; sf.style.display = 'block';
            tl.classList.remove('active'); ts.classList.add('active');
            loadQuestions();
      }
}

/* Password strength meter */
function checkStrength(pwd) {
      const fill = document.getElementById('strengthFill');
      const lbl = document.getElementById('strengthLabel');
      let score = 0;
      if (pwd.length >= 6) score++;
      if (/[A-Z]/.test(pwd)) score++;
      if (/[0-9]/.test(pwd)) score++;
      if (/[^A-Za-z0-9]/.test(pwd)) score++;
      const w = [0, 25, 50, 75, 100][score];
      const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'];
      const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
      fill.style.width = w + '%';
      fill.style.background = colors[score] || '#ef4444';
      lbl.textContent = labels[score] || '';
}

/* ════════════════════════════════════════════
      LOAD SECURITY QUESTIONS
════════════════════════════════════════════ */
function loadQuestions() {
      if (allQuestions.length) { populateQDropdowns(); return; }
      const fd = new FormData();
      fd.append('action', 'get_questions');
      fetch('auth.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                  if (d.status === 'success') {
                        allQuestions = d.questions;
                        populateQDropdowns();
                  }
            });
}

function populateQDropdowns() {
      const s1 = document.getElementById('sq1');
      const s2 = document.getElementById('sq2');
      [s1, s2].forEach(sel => {
            sel.innerHTML = '<option value="">— Select a question —</option>';
            allQuestions.forEach(q => {
                  sel.innerHTML += `<option value="${q.id}">${q.question}</option>`;
            });
      });
}

function filterQ2() {
      const v = document.getElementById('sq1').value;
      const s2 = document.getElementById('sq2');
      Array.from(s2.options).forEach(opt => {
            opt.disabled = (opt.value === v && v !== '');
      });
}

/* ════════════════════════════════════════════
      SIGNUP STEPS
════════════════════════════════════════════ */
function goStep2() {
      hideAlert('signupAlert');
      const name = document.getElementById('regName').value.trim();
      const adm = document.getElementById('regAdm').value.trim();
      const phone = document.getElementById('regPhone').value.trim();
      const email = document.getElementById('regEmail').value.trim();
      const pass = document.getElementById('regPass').value;

      if (!name || !adm || !phone || !email || !pass) {
            return showAlert('signupAlert', 'All fields in this step are required.');
      }
      if (!/^\d{10}$/.test(phone)) {
            return showAlert('signupAlert', 'Enter a valid 10-digit phone number.');
      }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            return showAlert('signupAlert', 'Enter a valid email address.');
      }
      if (pass.length < 6) {
            return showAlert('signupAlert', 'Password must be at least 6 characters.');
      }

      document.getElementById('signupStep1').style.display = 'none';
      document.getElementById('signupStep2').style.display = 'block';
      document.getElementById('dot1').classList.remove('active');
      document.getElementById('dot2').classList.add('active');
      loadQuestions();
}

function goStep1() {
      document.getElementById('signupStep2').style.display = 'none';
      document.getElementById('signupStep1').style.display = 'block';
      document.getElementById('dot2').classList.remove('active');
      document.getElementById('dot1').classList.add('active');
}

/* ════════════════════════════════════════════
      AUTH ACTIONS  (AJAX → auth.php)
════════════════════════════════════════════ */

/* ── LOGIN ── */
function doLogin() {
      hideAlert('loginAlert');
      const adm = document.getElementById('loginAdm').value.trim();
      const pass = document.getElementById('loginPass').value;
      if (!adm || !pass) return showAlert('loginAlert', 'Please enter admission number and password.');

      const fd = new FormData();
      fd.append('action', 'login');
      fd.append('admission_no', adm);
      fd.append('password', pass);

      fetch('auth.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                  if (d.status === 'success') {
                        showAlert('loginAlert', 'Login successful! Redirecting…', 'success');
                        setTimeout(() => window.location.href = d.redirect, 800);
                  } else {
                        showAlert('loginAlert', d.message);
                  }
            })
            .catch(() => showAlert('loginAlert', 'Network error. Please try again.'));
}

/* ── SIGNUP ── */
function doSignup() {
      hideAlert('signupAlert');
      const q1 = document.getElementById('sq1').value;
      const a1 = document.getElementById('sa1').value.trim();
      const q2 = document.getElementById('sq2').value;
      const a2 = document.getElementById('sa2').value.trim();

      if (!q1 || !a1 || !q2 || !a2) return showAlert('signupAlert', 'Please answer both security questions.');
      if (q1 === q2) return showAlert('signupAlert', 'Please choose two different questions.');

      const fd = new FormData();
      fd.append('action', 'signup');
      fd.append('name', document.getElementById('regName').value.trim());
      fd.append('admission_no', document.getElementById('regAdm').value.trim());
      fd.append('phone', document.getElementById('regPhone').value.trim());
      fd.append('email', document.getElementById('regEmail').value.trim());
      fd.append('password', document.getElementById('regPass').value);
      fd.append('question1_id', q1);
      fd.append('question1_answer', a1);
      fd.append('question2_id', q2);
      fd.append('question2_answer', a2);

      fetch('auth.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                  if (d.status === 'success') {
                        showAlert('signupAlert', d.message, 'success');
                        setTimeout(() => switchTab('login'), 1800);
                  } else {
                        showAlert('signupAlert', d.message);
                  }
            })
            .catch(() => showAlert('signupAlert', 'Network error. Please try again.'));
}

/* ── FORGOT: FETCH QUESTIONS ── */
function fetchResetQuestions() {
      hideAlert('resetAlert');
      const adm = document.getElementById('resetAdm').value.trim();
      if (!adm) return showAlert('resetAlert', 'Enter your admission number.');

      const fd = new FormData();
      fd.append('action', 'get_reset_questions');
      fd.append('admission_no', adm);

      fetch('auth.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                  if (d.status === 'success') {
                        resetQuestions = d.questions;
                        document.getElementById('resetQ1Label').textContent = d.questions[0].question;
                        document.getElementById('resetQ1Id').value = d.questions[0].id;
                        document.getElementById('resetQ2Label').textContent = d.questions[1].question;
                        document.getElementById('resetQ2Id').value = d.questions[1].id;
                        document.getElementById('resetStep1').style.display = 'none';
                        document.getElementById('resetStep2').style.display = 'block';
                  } else {
                        showAlert('resetAlert', d.message);
                  }
            })
            .catch(() => showAlert('resetAlert', 'Network error.'));
}

function resetStepBack() {
      document.getElementById('resetStep2').style.display = 'none';
      document.getElementById('resetStep1').style.display = 'block';
}

/* ── FORGOT: DO RESET ── */
function doReset() {
      hideAlert('resetAlert');
      const a1 = document.getElementById('resetA1').value.trim();
      const a2 = document.getElementById('resetA2').value.trim();
      const np = document.getElementById('resetNewPass').value;
      const cp = document.getElementById('resetConfPass').value;

      if (!a1 || !a2) return showAlert('resetAlert', 'Please answer both security questions.');
      if (!np || np !== cp) return showAlert('resetAlert', 'Passwords do not match or are empty.');
      if (np.length < 6) return showAlert('resetAlert', 'New password must be at least 6 characters.');

      const fd = new FormData();
      fd.append('action', 'reset_password');
      fd.append('admission_no', document.getElementById('resetAdm').value.trim());
      fd.append('question1_id', document.getElementById('resetQ1Id').value);
      fd.append('question1_answer', a1);
      fd.append('question2_id', document.getElementById('resetQ2Id').value);
      fd.append('question2_answer', a2);
      fd.append('new_password', np);

      fetch('auth.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                  if (d.status === 'success') {
                        showAlert('resetAlert', d.message, 'success');
                        setTimeout(() => {
                              showPanel('panelAuth', 'reset');
                              switchTab('login');
                        }, 2000);
                  } else {
                        showAlert('resetAlert', d.message);
                  }
            })
            .catch(() => showAlert('resetAlert', 'Network error.'));
}

/* Enter key support */
document.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
            if (document.getElementById('panelAuth').classList.contains('active')) {
                  if (document.getElementById('loginForm').style.display !== 'none') doLogin();
            } else {
                  const s2 = document.getElementById('resetStep2');
                  if (s2 && s2.style.display !== 'none') doReset();
            }
      }
});