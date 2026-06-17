<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="auth-page">
  <main class="auth-container">
    <section class="auth-card">
      <h1>Create an Account</h1>

      <div class="auth-toggle">
        <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/register') }}" class="active">Register</a>
      </div>

      <form action="{{ url('/register') }}" method="POST">
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="e.g. Andy" required>
          </div>
          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" placeholder="e.g. Jackson" required>
          </div>
        </div>

        <div class="form-group">
          <label for="uni_id">University ID (NIM)</label>
          <div class="input-wrapper has-icon">
            <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <input type="text" id="uni_id" name="uni_id" placeholder="e.g. 187241097" required>
          </div>
        </div>

        <div class="form-group">
          <label for="reg_email">University Email</label>
          <div class="input-wrapper has-icon">
            <svg class="icon-left" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <input type="email" id="reg_email" name="email" placeholder="student@university.edu" required autocomplete="username">
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper has-icon has-icon-right">
            <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
            <svg class="icon-right" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
          </div>
        </div>

        <label class="checkbox-container">
          <input type="checkbox" name="terms">
          <div class="checkmark"><svg viewBox="0 0 12 12"><polyline points="3 6 5 8 9 4"></polyline></svg></div>
          <span>I agree to the <a href="javascript:void(0)" onclick="Toast.show('Terms of Service is not available in the demo.', 'info')">Terms of Service</a> and <a href="javascript:void(0)" onclick="Toast.show('Privacy Policy is not available in the demo.', 'info')">Privacy Policy</a>.</span>
        </label>

        <button type="submit" class="btn-submit">Create Account</button>
      </form>

      <div class="divider">OR SIGN UP WITH</div>
      <button class="btn-sso">
        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
        University SSO
      </button>

      <p class="auth-footer-text" style="margin-top:16px;">
        Are you a doctor or staff? Contact your admin to get access.
      </p>
    </section>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/guest.js') }}"></script>
<script>
  document.querySelector('.btn-sso')?.addEventListener('click', () => {
    Toast.show('University SSO is not configured for this demo environment.', 'info', 4000);
  });
</script>
</body>
</html>
