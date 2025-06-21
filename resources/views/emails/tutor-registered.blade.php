<h2>Welcome, {{ $tutorName }}!</h2>
<p>Your tutor account has been successfully registered.</p>
<p><strong>Login Details:</strong></p>
<ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>
<p>Please log in and change your password upon first login.</p>

<!-- Login Button -->
<a href="{{ route('login') }}" 
   style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
   Go to Login
</a>
